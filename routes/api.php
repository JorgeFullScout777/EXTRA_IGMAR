<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChannelController;

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

Route::prefix('channel')->group(function () {
    Route::get('/index', [ChannelController::class, 'index'])->name('channel.index');
    Route::patch('/store', [ChannelController::class, 'store'])->name('channel.store');
    Route::delete('/update', [ChannelController::class, 'update'])->name('channel.update');
    Route::delete('/delete', [ChannelController::class, 'delete'])->name('channel.delete');
});
