<?php

namespace App\QueryFilters;

use Closure;

class SearchName extends Filter
{
   protected function applyFilter($builder)
   {
    if(request($this->filterName())){

       return $builder->where('name', 'LIKE', '%' . request($this->filterName()) . '%');
    }
    return $builder;
   }
}
