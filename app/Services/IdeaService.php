<?php
/**
 * Created by TienNamNguyen.
 * User: namnt
 * Year: 2022-02-26
 */

namespace Service;

use App\Events\IdeaPost;
use App\Events\IdeaComment;
use App\Events\IdeaLiked;
use App\Jobs\MailJob;
use App\Models\Idea;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\IdeaRepositoryInterface;
use App\Services\Contracts\IdeaServiceInterface;
use Service\BaseService;
use Service\TransactionService;
use Service\UploadService;
use App\Models\User;
use Redis;
class IdeaService extends BaseService implements IdeaServiceInterface
{

    protected $repository;
    protected $categoryRepository;

    public function __construct(IdeaRepositoryInterface $repository, CategoryRepositoryInterface $categoryRepository)
    {
        $this->repository = $repository;
        $this->categoryRepository = $categoryRepository;
    }

    public function loadIdeas($category_id, $user, $limit = null, $columns = ['*']) {
        $ideas = $this->repository
                ->where(['category_id' => $category_id])
                ->with([
                    'comments' => function ($query) {
                        $query->select(['*'])->orderBy('created_at', 'DESC')->limit(1);
                    },
                    'likes' => function ($query) use($user) {
                        $query->where('owner', $user)->select(['*']);
                    },
                    'user' => function ($query) {
                        $query->select(['*']);
                    }
                ])
                ->withCount('likes')
                ->orderBy('created_at', 'DESC')
                ->paginate($limit, $columns);
        return $ideas;
    }

    public function create(array $attributes)
    {
        $repository = $this->repository;
        $status = TransactionService::transaction(function () use($attributes, $repository){
            if ($category = $this->categoryRepository->find($attributes['category_id'])) {
                $ideadContents = [
                    Idea::CATEGORY => $attributes[Idea::CATEGORY],
                    Idea::OWNER => $attributes[Idea::OWNER],
                    Idea::CONTENTS => $attributes[Idea::CONTENTS]
                ];
                if ($idea = $category->idea()->create($ideadContents)) {
                    if (isset($attributes['files'])) {
                        foreach ($attributes['files'] as $key => $file) {
                            $pathFile = $this->uploadFile($file, "idea_{$idea->id}_owner_{$idea->owner}_file_order_{$key}");
                            $fileAttached[] = [
                                'file_extension' => $file->getClientOriginalExtension(),
                                'path' => $pathFile
                            ];
                        }
                        $idea->files()->createMany($fileAttached);
                    }
                    $send = [
                        "category_id" => $category->id,
                        "owner" => $idea->owner,
                        "idea_content" => $idea->contents,
                        "attatched_files" => isset($fileAttached) ? $fileAttached : null,
                        "topic_contents" => $category->topic_name,
                        "created_at" => $idea->created_at
                    ];

                    event(new IdeaPost($send));
                }
                MailJob::dispatch($category->user->email, $send)->onQueue('emails');
            }
        });
        return $status;
    }

    public function update(array $attributes, $id)
    {

    }

    public function delete($id)
    {

    }

    public function like(int $idea_id, int $owner_id, int $status)
    {
        $idea = $this->repository->find($idea_id);
        if ($idea) {
            $action = null;
            if ($liked = $idea->likes()->where(['owner' => $owner_id])->first()) {
                if ($liked->status != $status) {
                    $liked->status = $status;
                    $liked->save();
                    $action = ($status == 1) ? 'like' : 'dislike';
                } else if($liked->status ==  $status) {
                    $idea->likes()->where('owner', $owner_id)->delete();
                    $action = ($status == 1) ? 'unlike' : 'undislike';
                }
            } else {
                $liked = $idea->likes()->create([
                    'idea_id' => $idea_id,
                    'status' => $status,
                    'owner' => $owner_id,
                ]);
                $action = ($status == 1) ? 'like' : 'dislike';
            }
            $payLoad = [
                'owner' =>  User::find($owner_id),
                'idea_id' => $idea_id,
                'action' => $action,
                'status' => $status,
                'total_like' => $idea->likes()->where('status', 1)->count(),
                'total_dislike' => $idea->likes()->where('status', 0)->count()
            ];
            event(new IdeaLiked($payLoad));
            return [
                'code' => 200,
                'message' =>  $action,
                'total_like' => $idea->likes()->where('status', 1)->count(),
                'total_dislike' => $idea->likes()->where('status', 0)->count()
            ];
        }
        return [
            'code' => 404,
            'message' =>  'Idea not found'
        ];
    }

    public function comment(array $attributes)
    {
        if($idea = $this->repository->find($attributes['idea_id'])) {
            if ($comment = $idea->comments()->create([
                'idea_id' => $idea->id,
                'owner' => $attributes['owner']->id,
                'comment' => $attributes['comment']
            ])) {
                $attributes['comment'] = $comment;
                event(new IdeaComment($attributes));
            }
            return $comment;
        }
    }

    public function comments(int $idea_id, int $limit) {
        return $this->repository->find($idea_id)->comments()->orderBy('created_at', 'ASC')->paginate($limit);
    }

    public function attatchFile(int $idea_id, $file)
    {

    }

    public function detatchFile(int $idea_id, $file_id)
    {

    }
}
