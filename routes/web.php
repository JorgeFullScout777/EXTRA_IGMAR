<?php

use App\Http\Controllers\ChannelController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard',[ChannelController::class, 'index'])->name('dashboard');

    Route::prefix('post')->group(function () {
        Route::get('/show/{id}', [PostController::class, 'show'])->name('post.show');
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




    Route::get('/canal',[ChannelController::class, 'index'])->name('mipublicacion');

    Route::get('/mispublicaciones',function(){
        return Inertia::render('Mispublicaciones');
    })->name('mispublicaciones');
    Route::get('/Canales',function(){
        return Inertia::render('Canales');
    })->name('canales');
});

require __DIR__.'/auth.php';
