<?php
/**
 * Created by TienNamNguyen.
 * User: namnt
 * Year: 2022-02-26
 */

namespace Service;

use App\Repositories\Contracts\DepartmentRepositoryInterface;
use App\Services\Contracts\DepartmentServiceInterface;
use Service\BaseService;

class DepartmentService extends BaseService implements DepartmentServiceInterface
{

    protected $repository;

    public function __construct(DepartmentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


}
