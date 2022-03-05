<?php
/**
 * Created by TienNamNguyen.
 * User: namnt
 * Year: 2022-02-26
 */

namespace Service;

use App\Models\User;
use Service\BaseService;
use App\Services\Contracts\AuthServiceInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class AuthService extends BaseService implements AuthServiceInterface
{

    protected $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function login(string $email, string $password): ?array
    {
        if (Auth::attempt(["email" => $email, "password" => $password])) {
            if ($user = $this->repository->where(['email' => $email])->first()) {
                return [
                    'status' => 200,
                    'data' => [
                        'token' => $user->createToken('admin_token')->plainTextToken,
                        'profile' => $user,
                        'roles' => $user->getRoleNames()
                    ]
                ];
            }
        }
        return [
            'status' => 403,
            'message' => ERROR_UNAUTHENTICATE
        ];
    }

    public function authUser(User $user): ?array
    {
        if ($user) {
            return [
                'status' => 200,
                'data' => [
                    'profile' => $user,
                    'roles' => $user->getRoleNames()
                ]
            ];
        }
        return [
            'status' => 403,
            'message' => ERROR_UNAUTHENTICATE
        ];
    }
}
