<?php

namespace App\QueryFilters;

use Closure;

class IsParent extends Filter
{
   protected function applyFilter($builder)
   {

      if(request($this->filterName())){
         return $builder->whereNull('parent_id');
      }
      return $builder;
   }
}
