<?php
/**
 * Created by TienNamNguyen.
 * User: namnt
 * Year: 2022-02-26
 */

namespace Service;
use Service\BaseService;
use App\Services\Contracts\CategoryServiceInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;
class CategoryService extends BaseService implements CategoryServiceInterface
{

    protected $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function create(array $attributes)
    {
        $this->repository->create($attributes);
    }
}
