<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MessageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth')->group(function () {


});

// Los datos de las rutas put/update se tienen que enviar con el Content-Type: application/json

Route::prefix('channel')->group(function () {

    Route::get('/index', [ChannelController::class, 'index'])->name('channel.index');
    Route::post('/store', [ChannelController::class, 'store'])->name('channel.store');
    Route::put('/update/{id}', [ChannelController::class, 'update'])->name('channel.update');
    Route::delete('/delete/{id}', [ChannelController::class, 'delete'])->name('channel.delete');
    Route::get('/channels/user/{id}', [ChannelController::class, 'channelsUser'])->name('channel.channelsUser');
});

Route::prefix('post')->group(function () {
    Route::get('/index', [PostController::class, 'index'])->name('post.index');
    Route::post('/store', [PostController::class, 'store'])->name('post.store');
    Route::put('/update/{id}', [PostController::class, 'update'])->name('post.update');
    Route::delete('/delete/{id}', [PostController::class, 'delete'])->name('post.delete');
    Route::get('/posts/{id}', [PostController::class, 'posts'])->name('post.posts');
    Route::get('/posts/user/{id}', [PostController::class, 'postsUser'])->name('post.postsUser');
});

Route::prefix('comment')->group(function () {
    Route::get('/index', [CommentController::class, 'index'])->name('comment.index');
    Route::post('/store', [CommentController::class, 'store'])->name('comment.store');
    Route::put('/update/{id}', [CommentController::class, 'update'])->name('comment.update');
    Route::delete('/delete/{id}', [CommentController::class, 'delete'])->name('comment.delete');
    Route::get('/comments/{id}', [CommentController::class, 'comments'])->name('comment.comments');
});

Route::prefix('message')->group(function () {
    Route::get('/index', [MessageController::class, 'index'])->name('message.index');
    Route::post('/store', [MessageController::class, 'store'])->name('message.store');
    Route::put('/update/{id}', [MessageController::class, 'update'])->name('message.update');
    Route::delete('/delete/{id}', [MessageController::class, 'delete'])->name('message.delete');
    Route::get('/messages/{id}', [MessageController::class, 'messages'])->name('message.messages');
});