<?php

namespace App\Http\Repositories;

use App\Models\Media;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class MediaRepository
{
    const CACHE_KEY = 'MEDIA';

    public function pluck($name, $id)
    {
        $key = "pluck.{$name}.{$id}";
        $cacheKey = $this->getCacheKey($key);
        return Cache::tags(['medias'])->remember($cacheKey, Carbon::now()->addMonths(6), function () use ($name, $id) {
            return Media::pluck($name, $id);
        });
    }
    public function all()
    {
        $keys = $this->requestValue();
        $key = "all.{$keys}}";
        $cacheKey = $this->getCacheKey($key);
        return Cache::tags(['medias'])->remember($cacheKey, Carbon::now()->addMonths(6), function () {
            return Media::allWithFilters();
        });
    }
    public function findBySlug($slug)
    {
        $key = "findBySlug.{$slug}";
        $cacheKey = $this->getCacheKey($key);
        return Cache::tags(['medias'])->remember($cacheKey, Carbon::now()->addMonths(6), function () use ($slug) {
            return Media::findBySlug($slug);
        });
    }
    public function findByType($type)
    {
        $key = "findByType.{$type}";
        $cacheKey = $this->getCacheKey($key);
        return Cache::tags(['medias'])->remember($cacheKey, Carbon::now()->addMonths(6), function () use ($type) {
            return Media::where('type',$type)->first();
        });
    }

    public function whereInType($type)
    {
        $key = "whereInType.{$type}";
        $cacheKey = $this->getCacheKey($key);
        return Cache::tags(['medias'])->remember($cacheKey, Carbon::now()->addMonths(6), function () use ($type) {
            return Media::whereIn('type',explode(',',$type))->get();
        });
    }

    public function paginate($number)
    {
        $keys = $this->requestValue();
        $key = "paginate.{$number}.{$keys}";
        $cacheKey = $this->getCacheKey($key);

        return Cache::tags(['medias'])->remember($cacheKey, Carbon::now()->addMonths(6), function () use ($number) {
            return Media::paginateWithFilters($number);
        });
    }

    public function paginateTrash($number)
    {
		request()->merge(['trash' => '1']);
        $keys = $this->requestValue();
        $key = "paginateTrash.{$number}.{$keys}";
        $cacheKey = $this->getCacheKey($key);
        return Cache::tags(['medias'])->remember($cacheKey, Carbon::now()->addMonths(6), function () use ($number) {
            return Media::paginateWithFilters($number);
        });
    }

    public function countTrash()
    {
        $key = "countTrash";
        $cacheKey = $this->getCacheKey($key);
        return Cache::tags(['medias'])->remember($cacheKey, Carbon::now()->addMonths(6), function (){
            return Media::onlyTrashed()->count();
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
