<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Frontend\RfqController;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Page


Route::group(['middleware' => ['web']], function () {
    Route::get('/', [App\Http\Controllers\Frontend\HomeController::class, 'index'])->name('home');
});

