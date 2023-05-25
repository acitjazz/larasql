<?php

namespace App\QueryFilters;

use Closure;

class SortBy extends Filter
{
   protected function applyFilter($builder)
   {
    return $builder->orderBy(request($this->filterName()), request('sort') ?? 'desc');
   }
}
