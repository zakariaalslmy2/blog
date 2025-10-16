<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CatgoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'id'=>$this->id,
            'image'=>asset($this->image),
            'parent'=>$this->parent,
            'created_at'=>$this->created_at->format('y-m-d'),
            'title'=>$this->title,
            'content'=>$this->content,
            // 'children'=>CatgoryResource::collection($this->children),
            'children'=>CatgoryCollection::make($this->whenLoaded("children")),
            'post'=> PostResource::collection($this->whenLoaded('latestTwoPosts')),



        ];
    }
}
