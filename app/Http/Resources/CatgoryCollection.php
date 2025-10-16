<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CatgoryCollection extends ResourceCollection
{

    public function toArray(Request $request)
    {

           return CatgoryResource::collection($this->collection);
    }
}
