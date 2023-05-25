<?php

namespace App\QueryFilters;

use Closure;

class TagId extends Filter
{
   protected function applyFilter($builder)
   {

     return $builder->where('tag_id',request($this->filterName()));
   }
}
