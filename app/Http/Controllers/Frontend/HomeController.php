<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;


class HomeController extends Controller
{
  /**
    * Display a listing of the resource
    */
    public function index(Request $request)
    {
        // $page = PageRepository::findByType('home');
        // $page = PageResource::make($page)->resolve();
        $page = [
            'meta' => [
                'title' => '',
                'description' => '',
                'image' => '',
            ]
            ];
        return Inertia::render('Views/Pages/home', [
           'page' => $page,
         ]);

    }
}
