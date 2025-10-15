<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *

     */
    public function toArray(Request $request)
    {
        return[
           'id'=>$this->id,
            'image'=>asset($this->image),
            'created_at'=>$this->created_at->format('y-m-d'),
            'title'=>$this->title,
            'smallDesc'=>$this->smallDescrption,
            'content'=>$this->conten,
            'blog'=>$this->smallDescrption . $this->conten,
            'writer'=>$this->whenLoaded('user'),
        ];
    }
}
