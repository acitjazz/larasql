<?php

namespace App\QueryFilters;

use Closure;
use Illuminate\Support\Carbon;

class Except extends Filter
{
   protected function applyFilter($builder)
   {
      return $builder->whereNotIn('_id',explode(',',request($this->filterName())));
   }
}
