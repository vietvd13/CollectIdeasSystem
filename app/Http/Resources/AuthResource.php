<?php
/**
 * Created by PhpStorm.
 * User: autoDump
 * Year: 2021-10-06
 */

namespace App\Http\Resources;

class AuthResource extends BaseResource
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
