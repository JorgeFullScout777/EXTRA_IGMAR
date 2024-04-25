<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ExpulsionController;
use App\Http\Controllers\UserController;

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



/*
Route::prefix('message')->group(function () {
    Route::get('/index', [MessageController::class, 'index'])->name('message.index');
    Route::post('/store', [MessageController::class, 'store'])->name('message.store');
    Route::put('/update/{id}', [MessageController::class, 'update'])->name('message.update');
    Route::delete('/delete/{id}', [MessageController::class, 'delete'])->name('message.delete');
    Route::get('/messages/{id}', [MessageController::class, 'messages'])->name('message.messages');
});

Route::prefix('expulsion')->group(function () {
    Route::get('/index/{id}', [ExpulsionController::class, 'index'])->name('expulsion.index');
    Route::post('/store', [ExpulsionController::class, 'store'])->name('expulsion.store');
    Route::put('/update/{id}', [ExpulsionController::class, 'update'])->name('expulsion.update');
    Route::delete('/delete/{id}', [ExpulsionController::class, 'delete'])->name('expulsion.delete');
    Route::get('/expulsions/{id}', [ExpulsionController::class, 'expulsions'])->name('expulsion.expulsions');
});
*/
