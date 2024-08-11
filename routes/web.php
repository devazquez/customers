<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ImportController;

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

/*Route::get('/', function () {
    return view('welcome');
});*/


// mapa para identificar el CCL dado el sector, subsector, rama y subrama
//Route::get('/localiza-tu-ccl-info', [CostumerController::class, 'localizaTuCCLInfo'])->name('localizatucclinfopublic');

Route::resource('customers', CustomerController::class);
Route::get('/costumers-import', [ImportController::class, 'show'])->name('customers.import');
Route::post('/import-csv', [ImportController::class, 'store'])->name('store.csv');
Route::get('/customers-data/delete-all', [CustomerController::class, 'deleteAll'])->name('customers.delete-all');
Route::delete('/customers/{customer}', [App\Http\Controllers\CustomerController::class, 'destroy'])->name('customers.destroy');
Route::get('/customers/{customer}/edit', [App\Http\Controllers\CustomerController::class, 'edit'])->name('customers.edit');
Route::put('/customers/{customer}', [App\Http\Controllers\CustomerController::class, 'update'])->name('customers.update');  

Route::get('/customers/{customer}', [App\Http\Controllers\CustomerController::class, 'show'])->name('customers.show');
Route::get('/customers/create', [App\Http\Controllers\CustomerController::class, 'create'])->name('customers.create');
Route::post('/customers', [App\Http\Controllers\CustomerController::class, 'store'])->name('customers.store');  

