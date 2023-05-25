<?php

namespace App\QueryFilters;

use Closure;

class SearchType extends Filter
{
   protected function applyFilter($builder)
   {
    if(request($this->filterName())){

       return $builder->where('type', 'LIKE', '%' . request($this->filterName()) . '%');
    }
    return $builder;
   }
}
