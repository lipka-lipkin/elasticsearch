<?php

namespace App\Http\Resources;

use App\Http\Resources\Api\FileResource;
use App\Http\Resources\Api\UsersResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'body' => $this->body,
            'tags' => $this->title,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'user' => UsersResource::make($this->whenLoaded('user')),
            'files' => FileResource::collection($this->whenLoaded('files')),
        ];
    }
}
