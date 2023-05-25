<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use Sluggable;
    use SoftDeletes;

    protected $table = 'medias';
    protected $dates = ['deleted_at'];
    protected $fillable = ['name',
                           'slug',
                           'thumbnail',
                           'extension',
                           'filename',
                           'size',
                           'path',
                           'url'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate' => true,
            ]
        ];
    }
}
