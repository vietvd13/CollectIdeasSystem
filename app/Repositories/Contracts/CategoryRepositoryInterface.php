<?php
/**
 * Created by TienNamNguyen.
 * User: namnt
 * Year: 2022-03-07
 */

namespace App\Repositories\Contracts;


interface CategoryRepositoryInterface extends BaseRepositoryInterface
{
    public function dataChartDonut(int $limit, int $department_id);
    public function ideaInCategory(int $category_id);
}

