<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdeaComment extends Model
{
    use HasFactory;

    protected $table = 'idea_comments';

    protected $fillable = [
        'idea_id',
        'owner',
        'comment'
    ];
}
