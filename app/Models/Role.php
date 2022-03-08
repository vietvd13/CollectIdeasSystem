<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Role extends \Spatie\Permission\Models\Role
{
    //
    public $guard_name = 'api';

    protected $hidden = [
        "pivot"
    ];
    /**
     * Check whether current role is admin
     * @return bool
     */

    public function isAdmin(): bool
    {
        return $this->name === ROLES['ADMIN'];
    }
}
