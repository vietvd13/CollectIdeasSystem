<?php
/**
 * Created by PhpStorm.
 * User: autoDump
 * Year: 2022-02-26
 */

namespace App\Repositories\Contracts;


interface IdeaRepositoryInterface extends BaseRepositoryInterface
{
    public function dataChartDonut(int $category_id, int $limit, int $department_id);
    public function loadIdeas($orderBy, $category_id, $user, $limit = null, $columns = ['*']);
}
