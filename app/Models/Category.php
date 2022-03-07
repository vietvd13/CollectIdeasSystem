<?php
/**
 * Created by TienNamNguyen.
 * User: namnt
 * Year: 2022-03-07
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;

    const NAME = "name";
    protected $table = 'categories';

    protected $fillable = [
        User::NAME
    ];

    protected $casts = [
        'data' => 'array'
    ];

}
