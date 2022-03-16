<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdeaComment extends Model
{
    protected $table = 'iead_attatch_files';

    protected $fillable = [
        'idea_id',
        'file_extension',
        'path'
    ];
}
