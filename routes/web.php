<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class,'showpublishedposts'])->name('welcome');

Route::get('/posts',[PostController::class,'showmyposts'])->middleware(['auth', 'verified'])->name('posts');
Route::get('/comments', [PostController::class,'showmycomments'])->middleware(['auth', 'verified'])->name('comments');


Route::get('/new-post', function () {
    return view('form-post',["opname"=>"New post creation","text"=>"","imagename"=>Null,"post_id"=>0]);
})->middleware(['auth', 'verified'])->name('new-post');

Route::get('/edit-post',[PostController::class,'openedit'])->middleware(['auth', 'verified'])->name('get-edit-post');

Route::post('/edit-post', [PostController::class,'edit'])->middleware(['auth', 'verified'])->name('edit-post');

Route::post('/new-post',[PostController::class,'store'])->middleware(['auth', 'verified'])->name('new-post-post');
Route::get('/post/{id}', [PostController::class,'showpostwithcomments'])->middleware(['auth', 'verified'])->name('get-post');
Route::post('/publish',[PostController::class,'publish'])->middleware(['auth', 'verified'])->name('publish-post');
Route::post('/unpublish',[PostController::class,'unpublish'])->middleware(['auth', 'verified'])->name('unpublish-post');
Route::post('/delete-post',[PostController::class,'delete'])->middleware(['auth', 'verified'])->name('delete-post');
Route::post('/postcomment',[PostController::class,'postcomment'])->middleware(['auth', 'verified'])->name('post-comment');
Route::post('/deletecomment',[PostController::class,'deletecomment'])->middleware(['auth', 'verified'])->name('delete-comment');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
