<?php
/**
 * Created by PhpStorm.
 * User: autoDump
 * Year: 2022-02-26
 */

namespace Repository;

use App\Models\TmpRepository;
use App\Repositories\Contracts\TmpRepositoryRepositoryInterface;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;

class TmpRepositoryRepository extends BaseRepository implements TmpRepositoryRepositoryInterface
{

     public function __construct(Application $app)
     {
         parent::__construct($app);

     }

    /**
       * Instantiate model
       *
       * @param TmpRepository $model
       */

    public function model()
    {
        return TmpRepository::class;
    }


}
