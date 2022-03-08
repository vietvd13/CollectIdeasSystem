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
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
            $user->roles =$user->getRoleNames();
            return [
                'status' => 200,
                'profile' => $user,
            ];
        }
        return [
            'status' => 404,
            'message' => ERROR_USER_NOT_FOUND
        ];
    }

    public function create(array $attributes) : array
    {
        if ($role = Role::findById($attributes[User::ROLE])) {
            unset($attributes[User::ROLE]);
            $attributes[User::PASSWORD] = Hash::make($attributes[User::PASSWORD]);
            if ($user = $this->repository->create($attributes)) {
                $user->syncRoles($role);
                $user->roles =$user->getRoleNames();
                return [
                    'status' => 200,
                    'data' => $user
                ];
            }
        } else {
            return [
                'status' => 404,
                'message' => ERROR_ROLE_NOT_FOUND
            ];
        }
    }

    public function update(array $attributes, $id)
    {
        if ($user = $this->repository->find($id)) {
            $user = $user->toArray();
            // dd($user);
            // $attributes[User::PASSWORD] = $user[User::PASSWORD];
            if (isset($attributes[User::NEW_PASSWORD])) {
                $attributes[User::PASSWORD] = Hash::make($attributes[User::NEW_PASSWORD]);
            }
            unset($attributes[User::NEW_PASSWORD]);
            unset($attributes[User::EMAIL]);
            if ($user = $this->repository->update($attributes, $id)) {
                if ($role = Role::findById($attributes[User::ROLE])) {
                    $user->syncRoles($role);
                }
                $user->roles =$user->getRoleNames();
                return [
                    "status" => 200,
                    "data" => $user
                ];
            }

        } else {
            return [
                "status" => 404,
                "message" => ERROR_USER_NOT_FOUND
            ];
        }
    }
}
