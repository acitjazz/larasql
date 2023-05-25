<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use App\Models\AdminPassword;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class PasswordExpiredMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $administrator = Admin::find(auth()->guard('admin')->user()->id);
        // $start = Carbon::now()->subMinutes(env('PASSWORD_EXPIRED',60*24*30*3));
        // $lastPass =  AdminPassword::where('admin_id',$administrator->id)->latest('created_at')->first();
        // if(is_null($lastPass)){
        //  return Inertia::location(route('administrator.change.password'));
        // }
        // if($lastPass->created_at < $start){
        //     return Inertia::location(route('administrator.change.password'));
        // }
        return $next($request);
    }
}
