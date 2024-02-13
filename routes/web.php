<?php

use App\Http\Controllers\DaftarMobilController;
use App\Http\Controllers\Master\MerekController;
use App\Http\Controllers\Master\MobilController;
use App\Http\Controllers\Master\ModelController;
use App\Http\Controllers\SewaMobilController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'master-merek'], function () {
    Route::get('/', [MerekController::class, 'index'])->name('master-merek.index');
    Route::get('/create', [MerekController::class, 'create'])->name('master-merek.create');
    Route::post('/store', [MerekController::class, 'store'])->name('master-merek.store');
    Route::get('/edit/{id}', [MerekController::class, 'edit'])->name('master-merek.edit');
    Route::post('/update/{id}', [MerekController::class, 'update'])->name('master-merek.update');
    Route::delete('/delete/{id}', [MerekController::class, 'delete'])->name('master-merek.delete');
});

Route::group(['prefix' => 'master-model'], function () {
    Route::get('/', [ModelController::class, 'index'])->name('master-model.index');
    Route::get('/create', [ModelController::class, 'create'])->name('master-model.create');
    Route::post('/store', [ModelController::class, 'store'])->name('master-model.store');
    Route::get('/edit/{id}', [ModelController::class, 'edit'])->name('master-model.edit');
    Route::post('/update/{id}', [ModelController::class, 'update'])->name('master-model.update');
    Route::delete('/delete/{id}', [ModelController::class, 'delete'])->name('master-model.delete');
});

Route::group(['prefix' => 'master-mobil'], function () {
    Route::get('/', [MobilController::class, 'index'])->name('master-mobil.index');
    Route::get('/create', [MobilController::class, 'create'])->name('master-mobil.create');
    Route::post('/store', [MobilController::class, 'store'])->name('master-mobil.store');
    Route::get('/edit/{id}', [MobilController::class, 'edit'])->name('master-mobil.edit');
    Route::post('/update/{id}', [MobilController::class, 'update'])->name('master-mobil.update');
    Route::delete('/delete/{id}', [MobilController::class, 'delete'])->name('master-mobil.delete');
});

Route::group(['prefix' => 'daftar-mobil'], function () {
    Route::get('/', [DaftarMobilController::class, 'index'])->name('daftar-mobil.index');
    Route::get('/sewa/{id}', [DaftarMobilController::class, 'sewa'])->name('daftar-mobil.sewa');
    Route::post('/store/{id}', [DaftarMobilController::class, 'store'])->name('daftar-mobil.store');
});

Route::group(['prefix' => 'sewa-mobil'], function () {
    Route::get('/', [SewaMobilController::class, 'index'])->name('sewa-mobil.index');
    Route::post('/pengembalian/{id}', [SewaMobilController::class, 'pengembalian'])->name('sewa-mobil.update');
});
