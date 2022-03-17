<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdeaLike extends Model
{
    use HasFactory;

    protected $table = 'idea_likes';

    protected $fillable = [
        'idea_id',
        'owner',
        'status'
    ];
}
