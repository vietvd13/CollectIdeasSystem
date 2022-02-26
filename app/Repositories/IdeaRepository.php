<?php
/**
 * Created by PhpStorm.
 * User: autoDump
 * Year: 2022-02-26
 */

namespace Repository;

use App\Models\Idea;
use App\Repositories\Contracts\IdeaRepositoryInterface;
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


}
