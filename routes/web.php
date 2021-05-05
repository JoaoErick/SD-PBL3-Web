<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\IntervalController;
use App\Http\Controllers\HistoricController;

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

/*-------------------- Página principal --------------------------------------*/
/*Rota para acessar a página principal */
Route::get('/',[HomeController::class,'index'])->name('home');

Route::post('/',[ConnectionController::class,'verifyConnection'])->name('verifyConnection');

Route::get('/interval',[IntervalController::class,'index'])->name('interval');

Route::post('/Interval',[IntervalController::class,'setInterval'])->name('setInterval');

Route::get('/historic',[HistoricController::class,'index'])->name('historic');
Route::post('/historic/refresh', [HistoricController::class, 'refresh'])->name('refresh');
