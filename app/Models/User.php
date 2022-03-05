<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    const NAME = 'name';
    const EMAIL = 'email';
    const PASSWORD = 'password';
    const BIRTH = 'birth';
    const ROLE = 'role';
    protected $hidden = [
        User::PASSWORD
    ];

    protected $fillable = [
        User::NAME,
        User::EMAIL,
        User::PASSWORD,
        User::BIRTH
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */

    /**
     * The attributes that should be cast.
     *
     * @var array
     */

    protected $guard_name = 'api';
}
