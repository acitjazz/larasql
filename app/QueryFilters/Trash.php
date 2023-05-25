<?php

namespace App\QueryFilters;

use Closure;

class Trash extends Filter
{
   protected function applyFilter($builder)
   {
      if(request($this->filterName()) == '1'){

         return $builder->onlyTrashed();
      }
      return $builder;

   }
}
