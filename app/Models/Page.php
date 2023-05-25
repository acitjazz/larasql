<?php

namespace App\Models;

use App\Traits\GetSet;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use Sluggable;
    use SluggableScopeHelpers;
    use SoftDeletes;
    use HasTranslations;
    use GetSet;

    public $translatable = [
        'title',
        'subtitle',
        'slug',
        'summary',
        'description',
        'banners',
        'options',
        'contents',
        'buttons',
        'sections',
        'meta',
    ];

    protected $table = 'pages';
    protected $dates = ['deleted_at','published_at','expired_at'];

    protected $fillable = [
        'title',
        'subtitle',
        'slug',
        'type',
        'url',
        'summary',
        'description',
        'position',
        'images',
        'banners',
        'options',
        'contents',
        'buttons',
        'sections',
        'meta',
        'views',
        'featured',
        'published_at',
        'expired_at',
        'deleted_at',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'slug',
                'onUpdate' => true
            ]
        ];
    }


    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }


    public static function paginateWithFilters($limit)
    {
        return app(Pipeline::class)
            ->send(Page::query())
            ->through([
                \App\QueryFilters\SortBy::class,
                \App\QueryFilters\Type::class,
                \App\QueryFilters\Trash::class,
                \App\QueryFilters\Except::class,
                \App\QueryFilters\Featured::class,
                \App\QueryFilters\Published::class,
                \App\QueryFilters\SearchTitle::class,
            ])
            ->thenReturn()
            ->paginate($limit);
    }

    public static function allWithFilters()
    {
        return app(Pipeline::class)
            ->send(Page::query())
            ->through([
                \App\QueryFilters\SortBy::class,
                \App\QueryFilters\Type::class,
                \App\QueryFilters\Trash::class,
                \App\QueryFilters\Except::class,
                \App\QueryFilters\Featured::class,
                \App\QueryFilters\Published::class,
                \App\QueryFilters\SearchTitle::class,
            ])
            ->thenReturn()
            ->get();
    }

}
