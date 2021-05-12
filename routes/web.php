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

Route::get('/settings',[IntervalController::class,'index'])->name('interval');
Route::post('/settings/set-interval',[IntervalController::class,'setInterval'])->name('setInterval');
Route::post('/settings/sync', [IntervalController::class,'sync'])->name('sync');
Route::post('/settings/alarm-mode', [IntervalController::class,'alarmMode'])->name('alarmMode');

Route::get('/historic',[HistoricController::class,'index'])->name('historic');
Route::post('/historic/refresh', [HistoricController::class, 'index'])->name('refresh');
