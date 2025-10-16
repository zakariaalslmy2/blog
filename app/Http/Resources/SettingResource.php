<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */




    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'logo'=>asset(path: $this->logo),
            'favicon'=>asset($this->favicon),
            "facebook"=>$this->facebook,
            'instagram'=>$this->instagram,
            'phone'=>$this->phone,
            'email'=>$this->email,
            'created_at'=>$this->created_at->format('y-m-d'),
            'title'=>$this->title,
            'content'=>$this->content,
            'address'=>$this->address

            ];
    }
}
