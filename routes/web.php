<?php

use App\Http\Controllers\PerfilController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

Route::get('/', [InicioController::class, 'index'])->name('home');
Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index');
Route::get('/produtos/{produto:slug}', [ProdutoController::class, 'show'])->name('produtos.show');

Route::prefix('carrinho')->name('carrinho.')->group(function () {
    Route::get('/', [CarrinhoController::class, 'index'])->name('index');
    Route::post('/{produto:slug}', [CarrinhoController::class, 'store'])->name('store');
    Route::patch('/item/{item}', [CarrinhoController::class, 'update'])->name('update');
    Route::delete('/item/{item}', [CarrinhoController::class, 'destroy'])->name('destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/perfil', [PerfilController::class, 'edit'])->name('profile.edit');
    Route::patch('/perfil', [PerfilController::class, 'update'])->name('profile.update');
    Route::delete('/perfil', [PerfilController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';