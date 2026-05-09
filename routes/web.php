<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('categories', CategoryController::class);
    Route::resource('menu-items', MenuItemController::class);
    Route::resource('variants', \App\Http\Controllers\VariantController::class);

    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');

    Route::get('/pos', [POSController::class, 'index'])->name('pos.index');
    Route::post('/pos/cart/add', [POSController::class, 'addToCart'])->name('pos.cart.add');
    Route::post('/pos/cart/remove', [POSController::class, 'removeFromCart'])->name('pos.cart.remove');
    Route::post('/pos/cart/clear', [POSController::class, 'clearCart'])->name('pos.cart.clear');

    Route::get('/pos/checkout', [CheckoutController::class, 'checkout'])->name('pos.checkout');
    Route::post('/pos/checkout/process', [CheckoutController::class, 'process'])->name('pos.checkout.process');
    Route::get('/pos/receipt/{transaction}', [CheckoutController::class, 'receipt'])->name('pos.receipt');

    Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
    Route::get('/stock/restock', [StockController::class, 'restock'])->name('stock.restock');
    Route::post('/stock/restock', [StockController::class, 'store'])->name('stock.store');
    Route::get('/stock/adjust', [StockController::class, 'adjust'])->name('stock.adjust');
    Route::post('/stock/adjust', [StockController::class, 'storeAdjust'])->name('stock.adjust.store');

    Route::get('/laporan', [ReportController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/{transaction}', [ReportController::class, 'detail'])->name('laporan.detail');
});

require __DIR__.'/auth.php';
