<?php

namespace App\Traits;
use Illuminate\Database\Eloquent\Casts\Attribute;


trait GetSet
{

    function setImagesAttribute($images)
    {
        return $this->attributes['images'] = json_encode($images);
    }

    function getImageAttribute()
    {
        return getImage($this->images);
    }
}
