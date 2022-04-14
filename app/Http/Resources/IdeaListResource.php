<?php
/**
 * Created by PhpStorm.
 * User: autoDump
 * Year: 2022-02-26
 */

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
class IdeaListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $likeCount = 0;
        $dislikeCount = 0;
        foreach ($this->likes as $key => $like) {
            if ($like->status == 0) $dislikeCount += 1;
            else if ($like->status == 1) $likeCount += 1;
        }
        return [
                "id" => $this->id,
                "contents" => $this->contents,
                "owner" => $this->owner,
                "category_id" => $this->category_id,
                "created_at" => $this->created_at,
                "updated_at" => $this->created_at,
                "likes_count" => $likeCount,
                "dislike_count" => $dislikeCount,
                "comments" => $this->comments,
                "likes" => $this->likes,
                "user" => $this->user
        ];
    }
}
