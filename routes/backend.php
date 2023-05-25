<?php

use Illuminate\Support\Facades\Route;


// Inbox Controller
Route::group( ['prefix' => 'backend/media'],function(){
        Route::post('/upload/attachment',[App\Http\Controllers\Api\UploadController::class ,'attachment'])->name('media.attachment');
        Route::post('/upload/banner',[App\Http\Controllers\Api\UploadController::class ,'banner'])->name('media.banner');
        Route::post('/upload',[App\Http\Controllers\Api\UploadController::class ,'upload'])->name('media.upload');
        Route::post('/destroy',[App\Http\Controllers\Api\UploadController::class ,'destroy'])->name('media.destroy');
    }
);
Route::group(['prefix' => 'backend', 'middleware' => ['auth.admin:web']], function() {
    Route::group([ 'middleware' => ['password.expired']], function() {
        Route::get('/', [App\Http\Controllers\Backend\DashboardController::class, 'index'])->name('backend');
        Route::get('/dashboard', [App\Http\Controllers\Backend\DashboardController::class, 'index'])->name('dashboard.index');

        //Post
        Route::get('/post/trash', [App\Http\Controllers\Backend\PostController::class, 'trash'])->name('post.trash');
        Route::get('/post/trash/count', [App\Http\Controllers\Backend\PostController::class, 'countTrash'])->name('post.countTrash');
        Route::post('/post/destroy-all', [App\Http\Controllers\Backend\PostController::class, 'destroyAll'])->name('post.destroy-all');
        Route::post('/post/{post}/delete', [App\Http\Controllers\Backend\PostController::class, 'delete'])->name('post.delete');
        Route::post('/post/{post}/destroy', [App\Http\Controllers\Backend\PostController::class, 'destroy'])->name('post.forceDelete');
        Route::post('/post/{post}/restore', [App\Http\Controllers\Backend\PostController::class, 'restore'])->name('post.restore');
        Route::resource('/post', App\Http\Controllers\Backend\PostController::class);

        //Page
        Route::get('/page/trash', [App\Http\Controllers\Backend\PageController::class, 'trash'])->name('page.trash');
        Route::get('/page/trash/count', [App\Http\Controllers\Backend\PageController::class, 'countTrash'])->name('page.countTrash');
        Route::post('/page/destroy-all', [App\Http\Controllers\Backend\PageController::class, 'destroyAll'])->name('page.destroy-all');
        Route::post('/page/{page}/delete', [App\Http\Controllers\Backend\PageController::class, 'delete'])->name('page.delete');
        Route::post('/page/{page}/destroy', [App\Http\Controllers\Backend\PageController::class, 'destroy'])->name('page.forceDelete');
        Route::post('/page/{page}/restore', [App\Http\Controllers\Backend\PageController::class, 'restore'])->name('page.restore');
        Route::resource('/page', App\Http\Controllers\Backend\PageController::class);

        //Tag
        Route::get('/tag/trash', [App\Http\Controllers\Backend\TagController::class, 'trash'])->name('tag.trash');
        Route::get('/tag/trash/count', [App\Http\Controllers\Backend\TagController::class, 'countTrash'])->name('tag.countTrash');
        Route::post('/tag/destroy-all', [App\Http\Controllers\Backend\TagController::class, 'destroyAll'])->name('tag.destroy-all');
        Route::post('/tag/{tag}/delete', [App\Http\Controllers\Backend\TagController::class, 'delete'])->name('tag.delete');
        Route::post('/tag/{tag}/destroy', [App\Http\Controllers\Backend\TagController::class, 'destroy'])->name('tag.forceDelete');
        Route::post('/tag/{tag}/restore', [App\Http\Controllers\Backend\TagController::class, 'restore'])->name('tag.restore');
        Route::resource('/tag', App\Http\Controllers\Backend\TagController::class);


        //Media
        Route::get('/media/trash', [App\Http\Controllers\Backend\MediaController::class, 'trash'])->name('media.trash');
        Route::get('/media/trash/count', [App\Http\Controllers\Backend\MediaController::class, 'countTrash'])->name('media.countTrash');
        Route::post('/media/destroy-all', [App\Http\Controllers\Backend\MediaController::class, 'destroyAll'])->name('media.destroy-all');
        Route::post('/media/{media}/delete', [App\Http\Controllers\Backend\MediaController::class, 'delete'])->name('media.delete');
        Route::post('/media/{media}/destroy', [App\Http\Controllers\Backend\MediaController::class, 'destroy'])->name('media.forceDelete');
        Route::post('/media/{media}/restore', [App\Http\Controllers\Backend\MediaController::class, 'restore'])->name('media.restore');
        Route::apiResource('/media', App\Http\Controllers\Backend\MediaController::class);
    });
    Route::get('/change-password',[App\Http\Controllers\Backend\AdminstratorController::class,'changePassword'])->name('administrator.change.password');
    Route::post('/update-password',[App\Http\Controllers\Backend\AdminstratorController::class,'updatePassword'])->name('administrator.update.password');
    Route::resource('/administrator', App\Http\Controllers\Backend\AdminstratorController::class);

});

Route::group(['prefix' => 'backend'], function() {
    Route::get('/login', [App\Http\Controllers\AuthAdmin\AuthAdminController::class, 'create'])->name('admin.login.create');
    Route::post('/login', [App\Http\Controllers\AuthAdmin\AuthAdminController::class, 'login'])->name('admin.login');
    Route::post('logout', [App\Http\Controllers\AuthAdmin\AuthAdminController::class, 'destroy'])->name('admin.logout');
});
