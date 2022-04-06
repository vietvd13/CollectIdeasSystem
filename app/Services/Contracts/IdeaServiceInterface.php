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
    public function loadIdeas($category_id, $user, $limit = null, $columns = ['*']);
    public function like(int $idea_id, int $owner_id, int $status);
    public function comment(array $attributes);
    public function comments(int $idea_id, int $limit);
    public function attatchFile(int $idea_id, $file);
    public function detatchFile(int $idea_id, $file_id);
}
