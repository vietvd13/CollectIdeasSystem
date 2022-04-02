<?php
/**
 * Created by TienNamNguyen.
 * User: namnt
 * Year: 2022-03-07
 */

namespace App\Services\Contracts;

interface DasboardServiceInterface extends BaseServiceInterface
{
    public function categoryByOwner($request);
    public function chartDonut($request);
}
