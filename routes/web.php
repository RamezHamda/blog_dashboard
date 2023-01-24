<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\AdminController;



Route::prefix('admin')->name('admin.')->middleware('auth')->group(function(){
    Route::get('/',[AdminController::class,"index"])->name('index');

    Route::get('posts/trash',[PostController::class,'trash'])->name('posts.trash');
    Route::get('posts/{post}/restore',[PostController::class,'restore'])->name('posts.restore')->withTrashed();
    Route::get('posts/{post}/forcedelete',[PostController::class,'forcedelete'])->name('posts.forcedelete')->withTrashed();

    Route::resource("posts" , PostController::class);

});

Route::view('/','welcome');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
