<?php

use App\Http\Controllers\PerfilController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PainelController;
use App\Http\Controllers\EnderecoController;
use App\Http\Controllers\AvaliacaoController;
use App\Http\Controllers\AdminProdutoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [InicioController::class, 'index'])->name('home');
Route::resource('produtos', ProdutoController::class)->only(['index', 'show']);
Route::resource('produtos.avaliacoes', AvaliacaoController::class)->only(['store'])
    ->middleware('auth');

Route::resource('carrinho', CarrinhoController::class)->only(['index', 'store', 'update', 'destroy']);

Route::middleware('auth')->group(function () {
    Route::get('dashboard', function () {
        return Auth::user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : view('dashboard');
    })->name('dashboard');

    Route::resource('checkout', CheckoutController::class)->only(['index', 'store']);

    Route::resource('pedidos', PedidoController::class)->only(['index', 'show']);

    Route::resource('enderecos', EnderecoController::class)->only(['store', 'destroy']);

    Route::get('/perfil', [PerfilController::class, 'edit'])->name('profile.edit');
    Route::patch('/perfil', [PerfilController::class, 'update'])->name('profile.update');
    Route::delete('/perfil', [PerfilController::class, 'destroy'])->name('profile.destroy');

    Route::middleware([\App\Http\Middleware\IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [PainelController::class, 'index'])->name('dashboard');
        Route::resource('produtos', AdminProdutoController::class)->only(['index', 'edit', 'update', 'destroy']);
    });
});

require __DIR__.'/auth.php';
