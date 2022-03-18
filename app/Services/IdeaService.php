<?php
/**
 * Created by TienNamNguyen.
 * User: namnt
 * Year: 2022-02-26
 */

namespace Service;

use App\Events\IdeaPost;
use App\Events\IdeaComment;
use App\Jobs\MailJob;
use App\Models\Idea;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\IdeaRepositoryInterface;
use App\Services\Contracts\IdeaServiceInterface;
use Service\BaseService;
use Service\TransactionService;
use Service\UploadService;
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
                            $pathFile = $this->uploadFile($file, [
                                'idea_id' => $idea->id,
                                'owner' => $idea->owner,
                                'file_order' => $key
                            ]);
                            // dd($file->getClientOriginalExtension());
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
                        "topic_contents" => $category->contents,
                        "created_at" => $idea->created_at
                    ];
                    event(new IdeaPost($send));
                }
                MailJob::dispatch('thangld2407@gmail.com', $send)->onQueue('emails');
            }
        });
        $status;
    }

    public function update(array $attributes, $id)
    {

    }

    public function delete($id)
    {

    }

    public function like(int $idea_id)
    {

    }

    public function comment(array $attributes)
    {
        if($idea = $this->repository->find($attributes['idea_id'])) {
            if ($comment = $idea->comments()->create([
                'idea_id' => $idea->id,
                'owner' => $attributes['owner']->id,
                'comment' => $attributes['comment']
            ])) {
                event(new IdeaComment($attributes));
            }
            return $comment;
        }
    }

    public function attatchFile(int $idea_id, $file)
    {

    }

    public function detatchFile(int $idea_id, $file_id)
    {

    }
}
