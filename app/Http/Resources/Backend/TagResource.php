<?php

namespace App\Http\Resources\Backend;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class TagResource extends JsonResource
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
            'meta'=> translate($this,'meta'),

            'type' => $this->type,
            'bg_color' => $this->bg_color,
            'text_color' => $this->text_color,
            'images' => $this->images ? json_decode($this->images) : [],
            'image' => $this->image,
            'featured' => boolval( $this->featured),
            'published_at' => $this->published_at ? Carbon::parse($this->published_at)->format('m/d/Y') : null,
            'created_at' => $this->created_at ? Carbon::parse($this->created_at)->format('m/d/Y H:i:s') : null,
            'updated_at' => $this->updated_at ? Carbon::parse($this->updated_at)->format('m/d/Y H:i:s') : null,
            'deleted_at' => $this->deleted_at ? Carbon::parse($this->deleted_at)->format('m/d/Y H:i:s') : null,
        ];
    }
}
