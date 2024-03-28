<?php

use Illuminate\Support\Facades\Route;

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
    return view('home');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');    
Route::get('/netwatch', [App\Http\Controllers\NetwatchController::class, 'netwatch'])->name('netwatch');
Route::post('/connect', [App\Http\Controllers\NetwatchController::class, 'connect']);
Route::get('/disconnect', [App\Http\Controllers\NetwatchController::class, 'disconnect']);
