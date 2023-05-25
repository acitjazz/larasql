<?php

namespace App\Http\Middleware;

use App\Http\Resources\Backend\AdministratorResource;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
   // protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */

    public function rootView(Request $request)
    {
        $prefix = $request->route()->getPrefix();
        if($prefix == '/backend' || $prefix == 'backend/'){
              return 'app-admin';
        }
        return 'app';
    }

    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
     //   dd($user);
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => auth()->guard('admin')->check() ? AdministratorResource::make(auth()->guard('admin')->user()) : [],
            ],
            'navigation' => navigation(),
            'current_path'=> request()->fullUrl(),
            'flash' => [
                'message' => fn () => $request->session()->get('message'),
                'has_flash' => $request->session()->get('message') ? true : false,
            ],
            'env'=>[
                'app_name'=> env('APP_NAME'),
                'app_url'=> env('APP_URL'),
                'api_url'=> url('/api/v1'),
                'upload_url'=> env('UPLOAD_URL'),
                'map_key'=> env('MAP_KEY'),
            ],
            'languages'=> [
                [
                    'prefix' => 'en',
                    'text' => 'english',
                    'icon' => '',
                ],
                [
                    'prefix' => 'id',
                    'text' => 'bahasa',
                    'icon' => '',
                ],
                [
                    'prefix' => 'sc',
                    'text' => 'mandarin',
                    'icon' => '',
                ],
             ],
            'csrf_token' => csrf_token(),
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'recaptcha_site_key' => config('services.google_recaptcha.site_key'),
        ]);
    }
}
