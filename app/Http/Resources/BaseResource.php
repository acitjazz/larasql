<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class BaseResource extends JsonResource
{
   public function only(...$attributes){
    
      return Arr::only($this->resolve(),$attributes);
   
    }

   
}
