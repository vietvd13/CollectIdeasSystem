<?php
/**
 * Created by TienNamNguyen.
 * User: namnt
 * Year: 2022-03-01
 */

namespace App\Services\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface IdeaServiceInterface extends BaseServiceInterface
{
    public function loadIdeas($category_id, $limit = null, $columns = ['*']);
    public function like(int $idea_id);
    public function comment(array $attributes);
    public function comments(int $idea_id, int $limit);
    public function attatchFile(int $idea_id, $file);
    public function detatchFile(int $idea_id, $file_id);
}
