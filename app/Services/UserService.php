<?php
/**
 * Created by TienNamNguyen.
 * User: namnt
 * Year: 2022-02-26
 */

namespace Service;
use App\Services\Contracts\BaseServiceInterface;
use Service\BaseService;
use App\Services\Contracts\UserServiceInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
class UserService extends BaseService implements UserServiceInterface
{

    public $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function find($id)
    {
        $user = $this->repository->find($id);
        if ($user) {
            return [
                'status' => 200,
                'profile' => $user,
                'roles' => $user->getRoleNames()
            ];
        }
        return [
            'status' => 404,
            'message' => ERROR_USER_NOT_FOUND
        ];
    }

    public function create(array $attributes)
    {

    }
}
