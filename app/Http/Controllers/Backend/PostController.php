<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Facades\App\Http\Repositories\PostRepository;
use App\Http\Requests\Post\PostRequest;
use App\Http\Resources\Backend\PostResource;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        $posts = PostRepository::paginate(20);
        return Inertia::render('Views/'.vueFormExist('index-'.type(),'post','index'), [
            'posts' => PostResource::collection($posts),
            'type' => type(),
            'title' => request('trash') ? 'Trash' : toTitle(type()),
            'locale' => app()->getLocale(),
            'trash' => request('trash') ? true : false,
            'breadcumb' => [
                [
                    'text' => 'Dashboard',
                    'url' => route('dashboard.index'),
                ],
                [
                    'text' => toTitle(type()),
                    'url' => route('post.index',['type'=> type(),'locale'=> app()->getLocale()])
                ],
            ],
        ]);
    }

    /**
    * create view
    */
    public function create()
    {
        $post = new Post;
        $post = PostResource::make($post)->resolve();
        return Inertia::render('Views/'.vueFormExist(type(),'post','form'), [
            'post' => $post,
            'type' => type(),
            'method' => 'store',
            'title' => 'Create ' . toTitle(type()) ,
            'locale' => app()->getLocale(),
            'breadcumb' => [
                [
                    'text' => 'Dashboard',
                    'url' => route('dashboard.index'),
                ],
                [
                    'text' => toTitle(type()),
                    'url' => route('post.index',['type'=> type(),'locale'=> app()->getLocale()])
                ],
            ],
        ]);
    }

    /**
    * store data
    */
    public function store(PostRequest $request, Post $post)
    {
        $post = Post::create($request->all());

        Cache::tags(['posts'])->flush();
        return redirect()->route('post.index',['type'=>type()])->with('message', toTitle($post->title) . ' has been created');
    }

    /**
    * Edit view
    */
    public function edit(Post $post)
    {
        return Inertia::render('Views/'.vueFormExist(type(),'post','form'), [
            'post' => $post,
            'type' => type(),
            'method' => 'update',
            'title' => 'Edit ' . toTitle(type()),
            'locale' => app()->getLocale(),
            'breadcumb' => [
                [
                    'text' => 'Dashboard',
                    'url' => route('dashboard.index'),
                ],
                [
                    'text' => toTitle(type()),
                    'url' => route('post.index',['type'=> type(),'locale'=> app()->getLocale()])
                ],
            ],
        ]);
    }

    /**
    * Update Data
    */
    public function update(PostRequest $request, Post $post)
    {
        $post->update($request->all());
        Cache::tags(['posts'])->flush();
        return redirect()->back()->with('message', toTitle($post->title) . ' has been updated');
    }

    /**
    * Remove the specified resource from storage temporary.
    */
    public function delete($post)
    {
        $post = Post::find($post);
        if(!$post){
            return abort(404);
        }
        $post->delete();

        Cache::tags(['posts'])->flush();
        return redirect()->back()->with('message', toTitle($post->title . ' hase been deleted'));
    }

    /**
     * Remove data permanently
     */
    public function destroy($post)
    {
        $post = Post::withTrashed()->find($post);
        if(!$post){
            return abort(404);
        }
        $post->forceDelete();

        Cache::tags(['posts'])->flush();
        return redirect()->back()->with('message', toTitle($post->title . ' hase been destroyed'));
    }

    public function destroyAll()
    {
       $ids = explode(',',request('selected'));
       $posts = Post::whereIn('_id',$ids)->withTrashed()->get();
       foreach ($posts as $post) {
          $post->forceDelete();
       }
       Cache::tags(['posts'])->flush();
       return redirect()->back()->with('message', toTitle($post->title) . ' has been destroyed');
    }

    /**
     * Restore Data from trash
     */
    public function restore($post)
    {
       $post = Post::withTrashed()->find($post);
       if(!$post){
           return abort(404);
       }
       $post->restore();
       Cache::tags(['posts'])->flush();
       return redirect()->back()->with('message', toTitle($post->title) . ' has been restored');
    }
}
