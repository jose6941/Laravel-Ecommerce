<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produtos', [ProductController::class, 'index'])->name('products.index');
Route::get('/produtos/{product}', [ProductController::class, 'show'])->name('products.show');

Route::middleware('guest')->group(function () {
    Route::get('registrar', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('registrar', [RegisteredUserController::class, 'store']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::prefix('carrinho')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/{product:slug}', [CartController::class, 'store'])->name('store');
    Route::patch('/item/{item}', [CartController::class, 'update'])->name('update');
    Route::delete('/item/{item}', [CartController::class, 'destroy'])->name('destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('meus-pedidos', [OrderController::class, 'index'])->name('orders.index');
    Route::get('meus-pedidos/{order:uuid}', [OrderController::class, 'show'])->name('orders.show');
});