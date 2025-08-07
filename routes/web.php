<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\IncomingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoiceController;


Route::get('/', function () {
    return Inertia::render('Home');
});

Route::get('/barang', [IncomingController::class, 'index'])->name('incomings.index');
Route::post('/barang', [IncomingController::class, 'store'])->name('incomings.store');
Route::put('/barang/{id}', [IncomingController::class, 'update'])->name('incomings.update');
Route::delete('/barang', [IncomingController::class, 'destroy'])->name('incomings.destroy');

Route::get('/produksi', [ProductController::class, 'index'])->name('products.index');
Route::post('/produksi', [ProductController::class, 'store'])->name('products.store');
Route::put('/produksi/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/produksi', [ProductController::class, 'destroy'])->name('products.destroy');

Route::get('invoice', [InvoiceController::class, 'index'])->name('invoice.index');
Route::post('/invoice', [InvoiceController::class, 'store'])->name('invoice.store');
Route::get('/invoice/total', [InvoiceController::class, 'total']);

// Route::get('/', function () {
//     return Inertia::render('Welcome');
// })->name('home');

// Route::get('dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// require __DIR__.'/settings.php';
// require __DIR__.'/auth.php';
