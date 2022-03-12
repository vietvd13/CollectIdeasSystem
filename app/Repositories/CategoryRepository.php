<?php
/**
 * Created by TienNamNguyen.
 * User: namnt
 * Year: 2022-03-07
 */

namespace Repository;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{

     public function __construct(Application $app)
     {
         parent::__construct($app);

     }

    /**
       * Instantiate model
       *
       * @param Category $model
       */

    public function model()
    {
        return Category::class;
    }

    public function paginate($limit = null, $columns = ['*'], $method = "paginate")
    {
        return $this->model->with('user')->paginate($limit, $columns);
    }


}
