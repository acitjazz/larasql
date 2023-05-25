<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Facades\App\Http\Repositories\PageRepository;
use App\Http\Requests\Page\PageRequest;
use App\Http\Resources\Backend\PageResource;
use App\Models\Page;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class PageController extends Controller
{
    public function index()
    {
        if(type() == 'static'){
           $pages = PageRepository::paginate(20);
           return Inertia::render('Views/'.vueFormExist('index-'.type(),'page','index'), [
              'pages' => PageResource::collection($pages),
              'title' =>  request('trash') ? 'Trash' : 'Static Pages',
              'locale' => app()->getLocale(),
              'trash' => request('trash') ?  true : false,
              'breadcumb' => [
                [
                    'text' => 'Dashboard',
                    'url' => route('dashboard.index'),
                ],
                [
                    'text' => toTitle(type()),
                    'url' => route('page.index',['type'=> type(),'locale'=> app()->getLocale()])
                ],
              ],
            ]);
        }

        $page = Page::where('type', type())->first();
        if (!$page) {
           $page = new Page;
           $page->type = type();
           $page->save();
        }
        return Inertia::render('Views/page/'.$page->type, [
              'page' => PageResource::make($page),
              'title' => toTitle($page->type),
              'locale' => app()->getLocale(),
              'type' => type(),
              'method' => 'update',
              'breadcumb' => [
                [
                    'text' => 'Dashboard',
                    'url' => route('dashboard.index'),
                ],
                [
                    'text' => toTitle(type()),
                    'url' => route('page.index',['type'=> $page->type])
                ],
              ],
        ]);
    }

    /**
    * create view
    */
    public function create()
    {
        $page = new Page;
        $page = PageResource::make($page)->resolve();
        return Inertia::render('Views/'.vueFormExist(type(),'page','form'), [
            'page' => $page,
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
                    'url' => route('page.index',['type'=> type(),'locale'=> app()->getLocale()])
                ],
            ],
        ]);
    }

    /**
    * store data
    */
    public function store(PageRequest $request, Page $page)
    {
        $page = Page::create($request->all());

        Cache::tags(['pages'])->flush();
        return redirect()->route('page.index',['type'=>type()])->with('message', toTitle($page->title) . ' has been created');
    }

    /**
    * Edit view
    */
    public function edit(Page $page)
    {
        return Inertia::render('Views/'.vueFormExist(type(),'page','form'), [
            'page' => $page,
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
                    'url' => route('page.index',['type'=> type(),'locale'=> app()->getLocale()])
                ],
            ],
        ]);
    }

    /**
    * Update Data
    */
    public function update(PageRequest $request, Page $page)
    {
        $page->update($request->all());
        Cache::tags(['pages'])->flush();
        return redirect()->back()->with('message', toTitle($page->title) . ' has been updated');
    }

    /**
    * Remove the specified resource from storage temporary.
    */
    public function delete($page)
    {
        $page = Page::find($page);
        if(!$page){
            return abort(404);
        }
        $page->delete();

        Cache::tags(['pages'])->flush();
        return redirect()->back()->with('message', toTitle($page->title . ' hase been deleted'));
    }

    /**
     * Remove data permanently
     */
    public function destroy($page)
    {
        $page = Page::withTrashed()->find($page);
        if(!$page){
            return abort(404);
        }
        $page->forceDelete();

        Cache::tags(['pages'])->flush();
        return redirect()->back()->with('message', toTitle($page->title . ' hase been destroyed'));
    }

    public function destroyAll()
    {
       $ids = explode(',',request('selected'));
       $pages = Page::whereIn('_id',$ids)->withTrashed()->get();
       foreach ($pages as $page) {
          $page->forceDelete();
       }
       Cache::tags(['pages'])->flush();
       return redirect()->back()->with('message', toTitle($page->title) . ' has been destroyed');
    }

    /**
     * Restore Data from trash
     */
    public function restore($page)
    {
       $page = Page::withTrashed()->find($page);
       if(!$page){
           return abort(404);
       }
       $page->restore();
       Cache::tags(['pages'])->flush();
       return redirect()->back()->with('message', toTitle($page->title) . ' has been restored');
    }
}
