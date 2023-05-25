<?php

namespace App\Http\Resources\Frontend;

use App\Http\Resources\BaseResource;
use Facades\App\Http\Repositories\BatchGamificationRepisitory;

class UserResource extends BaseResource
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
         'name' => $this->name,
         'email' => $this->email,
         'slug' => $this->slug,
      ];
   }

}
