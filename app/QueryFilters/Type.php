<?php

namespace App\QueryFilters;

use Closure;

class Type extends Filter
{
   protected function applyFilter($builder)
   {
      return $builder->where('type', request($this->filterName()));
   }
}
