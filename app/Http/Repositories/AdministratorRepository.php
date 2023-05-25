<?php

namespace App\Http\Repositories;

use App\Models\Admin;
use App\Models\Banner;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class AdministratorRepository
{
    const CACHE_KEY = 'ADMINISTRATOR';

    public function pluck($name, $id)
    {
        $key = "pluck.{$name}.{$id}";
        $cacheKey = $this->getCacheKey($key);
        return Cache::tags(['administrator'])->remember($cacheKey, Carbon::now()->addMonths(6), function () use ($name, $id) {
            return Admin::pluck($name, $id);
        });
    }
    public function all()
    {
        $keys = $this->requestValue();
        $key = "all.{$keys}}";
        $cacheKey = $this->getCacheKey($key);
        return Cache::tags(['administrator'])->remember($cacheKey, Carbon::now()->addMonths(6), function () {
            return Admin::allWithFilters();
        });
    }
    public function getBannerLogin($row)
    {
        $keys = $this->requestValue();
        $key = "all.{$keys}}";
        $cacheKey = $this->getCacheKey($key);
        return Cache::tags(['administrator'])->remember($cacheKey, Carbon::now()->addMonths(6), function () use ($row) {
            return Admin::limit($row)->orderBy('position','ASC')->get();
        });
    }

    public function paginate($number)
    {
        $keys = $this->requestValue();
        $key = "paginate.{$number}.{$keys}";
        $cacheKey = $this->getCacheKey($key);

        return Cache::tags(['administrator'])->remember($cacheKey, Carbon::now()->addMonths(6), function () use ($number) {
            return Admin::paginateWithFilters($number);
        });
    }

    public function paginateTrash($number)
    {
		request()->merge(['trash' => '1']);
        $keys = $this->requestValue();
        $key = "paginateTrash.{$number}.{$keys}";
        $cacheKey = $this->getCacheKey($key);
        return Cache::tags(['administrator'])->remember($cacheKey, Carbon::now()->addMonths(6), function () use ($number) {
            return Admin::paginateWithFilters($number);
        });
    }

    public function countTrash()
    {
        $key = "countTrash";
        $cacheKey = $this->getCacheKey($key);
        return Cache::tags(['administrator'])->remember($cacheKey, Carbon::now()->addMonths(6), function (){
            return Admin::onlyTrashed()->count();
        });
    }
    public function getCacheKey($key)
    {
        $key = strtoupper($key);
        return Self::CACHE_KEY . ".$key";
    }

    private function requestValue()
    {
        return http_build_query(request()->all(),'','.');
    }
}
