<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MasterItemsController;
use App\Http\Controllers\KategoriItemsController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/', [HomeController::class, 'index'])->name('home');

// Master Items
Route::get('/master-items', [MasterItemsController::class, 'index'])->name('masterItems');
Route::get('/master-items/search', [MasterItemsController::class, 'search']);
Route::get('/master-items/form/{method}/{id?}', [MasterItemsController::class, 'formView']);
Route::post('/master-items/form/{method}/{id?}', [MasterItemsController::class, 'formSubmit']);
Route::get('/master-items/view/{kode}', [MasterItemsController::class, 'singleView']);
Route::get('/master-items/delete/{id}', [MasterItemsController::class, 'delete']);
Route::get('/master-items/export-excel', [MasterItemsController::class, 'exportExcel']);
Route::get('/master-items/update-random-data', [MasterItemsController::class, 'updateRandomData']);

// Kategori Items
Route::get('/kategori-items', [KategoriItemsController::class, 'index'])->name('kategoriItems');
Route::get('/kategori-items/search', [KategoriItemsController::class, 'search']);
Route::get('/kategori-items/form/{method}/{id?}', [KategoriItemsController::class, 'formView']);
Route::post('/kategori-items/form/{method}/{id?}', [KategoriItemsController::class, 'formSubmit']);
Route::get('/kategori-items/view/{kode}', [KategoriItemsController::class, 'singleView']);
Route::get('/kategori-items/delete/{id}', [KategoriItemsController::class, 'delete']);
Route::get('/kategori-items/{id}/export-pdf', [KategoriItemsController::class, 'exportPDF'])->name('reportKategori');
