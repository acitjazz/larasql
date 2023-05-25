<?php

namespace App\Http\Resources\Backend;

use App\Http\Resources\BaseResource;

class PageResource extends BaseResource
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
         'parent_id' => $this->parent_id,

         'title' => translate($this,'title'),
         'slug' => translate($this,'slug'),
         'summary' => translate($this,'summary'),
         'description' => translate($this,'description'),
         'banners'=> translate($this,'banners'),
         'buttons'=> translate($this,'buttons'),
         'contents'=> translate($this,'contents'),
         'options'=> translate($this,'options'),
         'sections'=> translate($this,'sections'),
         'meta'=> translate($this,'meta'),

         'images' => $this->images ? json_decode($this->images) : [],
         'type' => $this->type,
         'position' => $this->position,
         'template' => $this->template,
         'featured'=> $this->featured ,
         'created_at'=> $this->created_at ? $this->created_at->format('d/m/Y H:i:s') : null ,
         'updated_at'=> $this->updated_at ? $this->updated_at->format('d/m/Y H:i:s') : null,
         'published_at'=> $this->published_at ? $this->published_at->format('d/m/Y H:i:s') : null,
      ];
   }
}
