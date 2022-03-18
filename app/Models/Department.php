<?php
/**
 * Created by TienNamNguyen.
 * User: namnt
 * Year: 2022-03-16
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'departments';

    protected $fillable = [
        'name'
    ];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'data' => 'array'
    ];

    public function users() {
        return $this->hasMany('App\Models\User', 'id', 'department_id');
    }

}
