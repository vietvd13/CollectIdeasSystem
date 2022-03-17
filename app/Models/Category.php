<?php
/**
 * Created by TienNamNguyen.
 * User: namnt
 * Year: 2022-03-07
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;

    const TOPIC_NAME = "topic_name";
    const DESCRIPTION = "description";
    const START_COLLECT_DATE = "start_collect_date";
    const END_COLLECT_DATE = "end_collect_date";
    const OWNER = "owner";
    protected $table = 'categories';

    protected $fillable = [
        Category::TOPIC_NAME,
        Category::DESCRIPTION,
        Category::START_COLLECT_DATE,
        Category::END_COLLECT_DATE,
        Category::OWNER
    ];

    protected $casts = [
        'data' => 'array'
    ];

    public function user() {
        return $this->HasOne('App\Models\User', 'id', 'owner');
    }

    public function idea() {
        return $this->hasMany('App\Models\Idea', 'category_id', 'id');
    }

}
