<?php

namespace App\QueryFilters;

use Closure;
use Illuminate\Support\Carbon;

class Month extends Filter
{
   protected function applyFilter($builder)
   {

      $year = Carbon::now()->format('Y');
      $start = Carbon::create()->year($year)->month(request($this->filterName()))->startOfMonth();
      $end = Carbon::create()->year($year)->month(request($this->filterName()))->endOfMonth();
      return $builder->whereBetween('started_at', [$start,$end]);
   }
}
