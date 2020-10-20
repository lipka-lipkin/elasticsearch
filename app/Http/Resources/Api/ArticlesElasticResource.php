<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticlesElasticResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $content = (object) $this->resource->getContent();
//        dd($this);
        return [
            'id' => $this->resource->getId(),
            'title' => $content->title,
            'description' => $content->description,
            'body' => $content->body,
            'created_at' => $content->created_at,
            'updated_at' => $content->updated_at,
            'user_id' => $content->user_id,
//            'user' => UsersResource::make($this->whenLoaded('user'))
        ];
    }
}
