<?php

use App\Http\Controllers\ChannelController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth;

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

// NO SUPE EN QUE PARTE VERIFICAR SI EL USUARIO ESTÁ ACTIVO A LA HORA DE INICIAR SESIÓN, ASI QUE LO HICE UN MIDDLEWARE XD
Route::middleware(['auth', 'user.isactive'])->group(function () {

    // ES SOLO UNA PRUEBA PARA SABER EL ROL_ID DEL USUARIO
    Route::get('/userAdmin', function() {
        return response()->json(['role_id' => auth()->user()->role_id]);
    });
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard',[ChannelController::class, 'index'])->name('dashboard');


    // POSTS / PUBLICACIONES
    Route::prefix('post')->group(function () {

        // MIDDLEWARE PARA VERIFICAR SI EL CANAL DE LOS POSTS ESTÁ ACTIVO
        Route::middleware('canal.isactive')->group(function () {
            Route::get('/posts/{id}', [PostController::class, 'posts'])->name('post.posts');
            Route::get('/show/{id}', [PostController::class, 'show'])->name('post.show');
        });


        // RUTAS POSTS PARA CUALQUIER USUARIO, CADA UNA TIENE VALIDACIONES
        Route::put('/update/{id}', [PostController::class, 'update'])->name('post.update');
        Route::get('/posts/json/{id}', [PostController::class, 'posts_json'])->name('post.posts.json');
        Route::get('/crear/{id}', function($id) {
            return Inertia::render('CrearPost', ['channel_id' => $id]);
        })->name('post.crear');
        Route::get('/index', [PostController::class, 'index'])->name('post.index');
        Route::post('/store', [PostController::class, 'store'])->name('post.store');
        Route::delete('/delete/{id}', [PostController::class, 'delete'])->name('post.delete');
        Route::get('/posts/user/{id}', [PostController::class, 'postsUser'])->name('post.postsUser');
    });


    // COMENTARIOS
    Route::prefix('comment')->group(function () {
        Route::get('/comments/{id}', [CommentController::class, 'comments'])->name('comment.comments');
        Route::get('/index', [CommentController::class, 'index'])->name('comment.index');
        Route::post('/store', [CommentController::class, 'store'])->name('comment.store');
        Route::put('/update/{id}', [CommentController::class, 'update'])->name('comment.update');
        Route::delete('/delete/{id}', [CommentController::class, 'delete'])->name('comment.delete');
    });


    // CANALES
    Route::prefix('channel')->group(function () {

        // MIDDLEWARE PARA VERIFICAR SI EL USUARIO ES ADMIN
        Route::middleware('user.isadmin')->group(function () {
            Route::get('/admin', function() {
                return Inertia::render('CanalesAdmin');
            })->name('channel.admin');  
            Route::get('/index/json/admin', [ChannelController::class, 'index_json_admin'])->name('channel.index.json.admin');
            Route::put('/enable/{id}', [ChannelController::class, 'enable'])->name('channel.enable');
        });


        // RUTAS PARA CUALQUIER USUARIO, CADA UNA TIENE VALIDACIONES
        Route::get('/crear/{id}', function($id) {
            return Inertia::render('CrearCanal', ['user_id' => $id]);
        })->name('channel.crear');  
        Route::get('/index', [ChannelController::class, 'index'])->name('channel.index');
        Route::get('/index/json', [ChannelController::class, 'index_json'])->name('channel.index.json');
        Route::post('/store', [ChannelController::class, 'store'])->name('channel.store');
        Route::put('/update/{id}', [ChannelController::class, 'update'])->name('channel.update');
        Route::delete('/delete/{id}', [ChannelController::class, 'delete'])->name('channel.delete');
        Route::get('/user', function() {
            return Inertia::render('MyChannels');
        })->name('channel.user'); 
        Route::get('/channels/user/{id}', [ChannelController::class, 'channelsUser'])->name('channel.channels.user');
    });


    // USUARIOS
    Route::middleware('user.isadmin')->prefix('user')->group(function () {
        Route::get('/admin', function() {
            return Inertia::render('UsuariosAdmin');
        })->name('user.admin'); 
        Route::get('/index', [UserController::class, 'index'])->name('user.index');
        Route::post('/store', [UserController::class, 'store'])->name('user.store');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
        Route::put('/enable/{id}', [UserController::class, 'enable'])->name('user.enable');
    });

    
});

require __DIR__.'/auth.php';
