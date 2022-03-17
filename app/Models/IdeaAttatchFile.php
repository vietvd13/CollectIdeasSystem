<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdeaAttatchFile extends Model
{
    protected $table = 'idea_attatch_files';

    protected $fillable = [
        'idea_id',
        'file_extension',
        'path'
    ];

    public function idea() {
        return $this->hasOne('App\Models\Idea', 'idea_id', 'id');
    }
}
