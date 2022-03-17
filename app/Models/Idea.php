<?php
/**
 * Created by PhpStorm.
 * User: autoDump
 * Year: 2022-02-26
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Idea extends Model
{
    use HasFactory;

    const CONTENTS = 'contents';
    const OWNER = 'owner';
    const CATEGORY = 'category_id';
    protected $table = 'ideas';

    protected $fillable = [
        Idea::CONTENTS,
        Idea::OWNER,
        Idea::CATEGORY
    ];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'data' => 'array'
    ];

    public function files() {
        return $this->hasMany('App\Models\IdeaAttatchFile', 'idea_id', 'id');
    }

    public function comments() {
        return $this->hasMany('App\Models\IdeaComment', 'idea_id', 'id');
    }

    public function likes() {
        return $this->hasMany('App\Models\IdeaLike', 'idea_id', 'id');
    }

    // public function category() {
    //     return $this->hasOne('App\Models\Category', 'category_id', 'id');
    // }
}
