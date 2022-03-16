<?php
/**
 * Created by TienNamNguyen.
 * User: namnt
 * Year: 2022-02-26
 */

namespace Service;

use App\Events\IdeaPost;
use App\Models\Idea;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\IdeaRepositoryInterface;
use App\Services\Contracts\IdeaServiceInterface;
use Service\BaseService;
use Service\TransactionService;
use Service\UploadService;
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
                $idea = $category->idea()->create($ideadContents);
                event(new IdeaPost($idea->id, $idea->contents, $idea->owner));
            }

            // if ($idea = $repository->create($ideadContents)) {
            //     if (isset($attributes['file']))
            //     foreach ($attributes['file'] as $key => $file) {
            //         if (UploadService::attatchFile($file)) {

            //         }
            //     }
            //    // event(new IdeaPost($idea->id, $idea->contents, $idea->owner));
            // }
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

    }

    public function attatchFile(int $idea_id, $file)
    {

    }

    public function detatchFile(int $idea_id, $file_id)
    {

    }
}
