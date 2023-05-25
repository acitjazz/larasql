<?php

namespace App\Http\Repositories;

use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class TagRepository
{
    const CACHE_KEY = 'TAG';

    public function pluck($name, $id)
    {
        $key = "pluck.{$name}.{$id}";
        $cacheKey = $this->getCacheKey($key);
        return Cache::tags(['tags'])->remember($cacheKey, Carbon::now()->addMonths(6), function () use ($name, $id) {
            return Tag::pluck($name, $id);
        });
    }
    public function all()
    {
        $keys = $this->requestValue();
        $key = "all.{$keys}}";
        $cacheKey = $this->getCacheKey($key);
        return Cache::tags(['tags'])->remember($cacheKey, Carbon::now()->addMonths(6), function () {
            return Tag::allWithFilters();
        });
    }
    public function findBySlug($slug)
    {
        $key = "findBySlug.{$slug}";
        $cacheKey = $this->getCacheKey($key);
        return Cache::tags(['tags'])->remember($cacheKey, Carbon::now()->addMonths(6), function () use ($slug) {
            return Tag::findBySlug($slug);
        });
    }

    public function paginate($number)
    {
        $keys = $this->requestValue();
        $key = "paginate.{$number}.{$keys}";
        $cacheKey = $this->getCacheKey($key);

        return Cache::tags(['tags'])->remember($cacheKey, Carbon::now()->addMonths(6), function () use ($number) {
            return Tag::paginateWithFilters($number);
        });
    }

    public function paginateTrash($number)
    {
		request()->merge(['trash' => '1']);
        $keys = $this->requestValue();
        $key = "paginateTrash.{$number}.{$keys}";
        $cacheKey = $this->getCacheKey($key);
        return Cache::tags(['tags'])->remember($cacheKey, Carbon::now()->addMonths(6), function () use ($number) {
            return Tag::paginateWithFilters($number);
        });
    }

    public function countTrash()
    {
        $key = "countTrash";
        $cacheKey = $this->getCacheKey($key);
        return Cache::tags(['tags'])->remember($cacheKey, Carbon::now()->addMonths(6), function (){
            return Tag::onlyTrashed()->count();
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
