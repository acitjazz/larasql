<?php

namespace App\Http\Resources\Backend;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,

            'title' => translate($this,'title'),
            'slug' => translate($this,'slug'),
            'summary' => translate($this,'summary'),
            'description' => translate($this,'description'),
            'images' => $this->images,
            'banners'=> translate($this,'banners'),
            'buttons'=> translate($this,'buttons'),
            'options'=> translate($this,'options'),
            'files'=> translate($this,'files'),
            'meta'=> translate($this,'meta'),

            'type' => $this->type,
            'featured'=> $this->featured ,
            'created_at'=> $this->created_at ? $this->created_at->format('d/m/Y H:i:s') : null ,
            'updated_at'=> $this->updated_at ? $this->updated_at->format('d/m/Y H:i:s') : null,
            'published_at'=> $this->published_at ? $this->published_at->format('d/m/Y H:i:s') : null,
            'expired_at'=> $this->expired_at ? $this->expired_at->format('d/m/Y H:i:s') : null,
        ];
    }
}
