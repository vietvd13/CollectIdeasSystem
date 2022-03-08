<?php
/**
 * Created by TienNamNguyen.
 * User: namnt
 * Year: 2022-03-07
 */

namespace App\Http\Resources;

class CategoryResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
