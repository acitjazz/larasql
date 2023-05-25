<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Facades\App\Http\Repositories\TagRepository;
use App\Http\Requests\Tag\TagRequest;
use App\Http\Resources\Backend\TagResource;
use App\Models\Tag;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class TagController extends Controller
{
    public function index()
    {
        $tags = TagRepository::paginate(20);
        return Inertia::render('Views/'.vueFormExist('index-'.type(),'tag','index'), [
            'tags' => TagResource::collection($tags),
            'type' => type(),
            'locale' => app()->getLocale(),
            'title' => request('trash') ? 'Trash' : 'Tag '. toTitle(type()),
            'trash' => request('trash') ? true : false,
            'breadcumb' => [
                [
                    'text' => 'Dashboard',
                    'url' => route('dashboard.index'),
                ],
                [
                    'text' => 'Tag '. toTitle(type()),
                    'url' => route('tag.index',['type'=> type(),'locale'=> app()->getLocale()])
                ],
            ],
        ]);
    }

    /**
    * create view
    */
    public function create()
    {
        $tag = new Tag;
        $tag->type = type();
        $tag = TagResource::make($tag)->resolve();
        return Inertia::render('Views/'.vueFormExist(type(),'tag','form'), [
            'tag' => $tag,
            'type' => type(),
            'locale' => app()->getLocale(),
            'method' => 'store',
            'title' => 'Create Tag ' . toTitle(type()) ,
            'breadcumb' => [
                [
                    'text' => 'Dashboard',
                    'url' => route('dashboard.index'),
                ],
                [
                    'text' => 'Tag '.toTitle(type()),
                    'url' => route('tag.index',['type'=> type(),'locale'=> app()->getLocale()])
                ]
            ],
        ]);
    }

    /**
    * store data
    */
    public function store(TagRequest $request, Tag $tag)
    {
        $tag = Tag::create($request->all());

        Cache::tags(['tags'])->flush();
        return redirect()->route('tag.index',['type'=>type()])->with('message', toTitle($tag->title) . ' has been created');
    }

    /**
    * Edit view
    */
    public function edit(Tag $tag)
    {
        $tag = TagResource::make($tag)->resolve();
        return Inertia::render('Views/'.vueFormExist(type(),'tag','form'), [
            'tag' => $tag,
            'type' => type(),
            'locale' => app()->getLocale(),
            'method' => 'update',
            'title' => 'Edit Tag ' . toTitle(type()),
            'breadcumb' => [
                [
                    'text' => 'Dashboard',
                    'url' => route('dashboard.index'),
                ],
                [
                    'text' => 'Tag '.toTitle(type()),
                    'url' => route('tag.index',['type'=> type(),'locale'=> app()->getLocale()])
                ],
            ],
        ]);
    }

    /**
    * Update Data
    */
    public function update(TagRequest $request, Tag $tag)
    {
        $tag->update($request->all());
        Cache::tags(['tags'])->flush();
        return redirect()->back()->with('message', toTitle($tag->title) . ' has been updated');
    }

    /**
    * Remove the specified resource from storage temporary.
    */
    public function delete($tag)
    {
        $tag = Tag::find($tag);
        if(!$tag){
            return abort(404);
        }
        $tag->delete();

        Cache::tags(['tags'])->flush();
        return redirect()->back()->with('message', toTitle($tag->title . ' hase been deleted'));
    }

    /**
     * Remove data permanently
     */
    public function destroy($tag)
    {
        $tag = Tag::withTrashed()->find($tag);
        if(!$tag){
            return abort(404);
        }
        $tag->forceDelete();

        Cache::tags(['tags'])->flush();
        return redirect()->back()->with('message', toTitle($tag->title . ' hase been destroyed'));
    }

    public function destroyAll()
    {
       $ids = explode(',',request('selected'));
       $tags = Tag::whereIn('_id',$ids)->withTrashed()->get();
       foreach ($tags as $tag) {
          $tag->forceDelete();
       }
       Cache::tags(['tags'])->flush();
       return redirect()->back()->with('message', toTitle($tag->title) . ' has been destroyed');
    }

    /**
     * Restore Data from trash
     */
    public function restore($tag)
    {
       $tag = Tag::withTrashed()->find($tag);
       if(!$tag){
           return abort(404);
       }
       $tag->restore();
       Cache::tags(['tags'])->flush();
       return redirect()->back()->with('message', toTitle($tag->title) . ' has been restored');
    }
}
