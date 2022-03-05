<?php
/**
 * Created by TienNamNguyen.
 * User: namnt
 * Year: 2022-03-01
 */

namespace App\Services\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface AuthServiceInterface extends BaseServiceInterface
{
    public function login(string $email, string $password): ?array;
    public function authUser(User $user): ?array;
}
