<?php

use App\Http\Controllers\ChannelController;
use App\Http\Controllers\ProfileController;
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
    Route::get('/dashboard',[ChannelController::class, 'index'])->name('dashboard');





    Route::get('/canal',[ChannelController::class, 'index'])->name('mipublicacion');

    Route::get('/mispublicaciones',function(){
        return Inertia::render('Mispublicaciones');
    })->name('mispublicaciones');

    Route::get('/Canales',function(){
        return Inertia::render('Canales');
    })->name('canales');
});

require __DIR__.'/auth.php';
