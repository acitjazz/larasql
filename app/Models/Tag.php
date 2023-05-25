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

class Tag extends Model
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
        'meta',
    ];

    protected $table = 'tags';
    protected $dates = ['deleted_at','published_at'];

    protected $fillable = [
        'title',
        'slug',
        'type',
        'summary',
        'description',
        'meta',
        'images',
        'views',
        'bg_color',
        'text_color',
        'featured',
        'deleted_at',
        'published_at',
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


    public function posts(): MorphToMany
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }


    public static function paginateWithFilters($limit)
    {
        return app(Pipeline::class)
            ->send(Tag::query())
            ->through([
                \App\QueryFilters\SortBy::class,
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
            ->send(Tag::query())
            ->through([
                \App\QueryFilters\SortBy::class,
                \App\QueryFilters\Featured::class,
                \App\QueryFilters\Published::class,
                \App\QueryFilters\SearchDesc::class,
            ])
            ->thenReturn()
            ->get();
    }

}
