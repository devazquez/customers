<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapaController;

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
    return view('welcome');
});

// mapa para identificar el CCL dado el sector, subsector, rama y subrama
Route::get('/localiza-tu-ccl-info', [MapaController::class, 'localizaTuCCLInfo'])->name('localizatucclinfopublic');
Route::get('/localiza-tu-ccl', [MapaController::class, 'localizaTuCCL'])->name('localizatucclpublic');
Route::get('/tdr-mapa', [MapaController::class, 'tdrMapa'])->name('tdr-mapa');

Route::get('registrar-pasajero/{dependencia?}',  [App\Http\Controllers\Auth\RegisterUserController::class, 'showRegistrationPasajeroForm'])->name('registrarPasajero');
Route::post('registrarPasajero', [App\Http\Controllers\Auth\RegisterUserController::class, 'registerPasajero'])->name('registrarPasajeroPost');
