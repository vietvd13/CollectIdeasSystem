<?php
/**
 * Created by PhpStorm.
 * User: autoDump
 * Year: 2022-02-26
 */

namespace Repository;

use App\Models\Idea;
use App\Models\IdeaComment;
use App\Repositories\Contracts\IdeaRepositoryInterface;
use App\Models\IdeaLike;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;

class IdeaRepository extends BaseRepository implements IdeaRepositoryInterface
{

     public function __construct(Application $app)
     {
         parent::__construct($app);

     }

    /**
       * Instantiate model
       *
       * @param Idea $model
       */

    public function model()
    {
        return Idea::class;
    }

    public function dataChartDonut(int $category_id, int $limit, int $department_id) {
        $data = $this->model->where([
            'category_id' => $category_id
        ])->whereHas('user', function ($query) use($department_id) {
            return $query->where(['department_id' => $department_id])->select(['*']);
        })
        ->withCount('likes')->orderBy('likes_count', 'desc')->limit($limit)->get(['*']);
        return $data;
    }

    public function countInDepartment($userDepartment) {
        return $this->model->whereHas('user', function ($query) use($userDepartment) {
            return $query->where(['department_id' => $userDepartment]);
        })->count();
    }

    public function total(int $department_id) {
        $ideas = $this->model->whereHas('user', function ($query) use($department_id) {
            return $query->where(['department_id' => $department_id]);
        })->get('id')->pluck('id')->toArray();
        return [
            'total_like' => IdeaLike::where('status', 1)->whereIn('idea_id', $ideas)->count(),
            'total_dislike' => IdeaLike::where('status', 0)->whereIn('idea_id', $ideas)->count(),
            'total_comment' => IdeaComment::whereIn('idea_id', $ideas)->count(),
        ];
    }


}
