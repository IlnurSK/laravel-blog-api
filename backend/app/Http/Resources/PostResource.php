<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'body'         => $this->body,
            'is_published' => $this->is_published,
            'created_at'   => $this->created_at,
            'updated_at'   => $this->updated_at,

            // Отношения
            'user'         => [
                'id'   => $this->user->id,
                'name' => $this->user->name,
            ],

            'category' => new CategoryResource($this->whenLoaded('category')),

            'tags' => TagResource::collection($this->whenLoaded('tags')),
        ];
    }
}
