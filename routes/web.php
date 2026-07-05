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
Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index');
Route::get('/produtos/{produto:slug}', [ProdutoController::class, 'show'])->name('produtos.show');
Route::post('/produtos/{produto:slug}/avaliacoes', [AvaliacaoController::class, 'store'])
    ->middleware('auth')
    ->name('avaliacoes.store');

Route::prefix('carrinho')->name('carrinho.')->group(function () {
    Route::get('/', [CarrinhoController::class, 'index'])->name('index');
    Route::post('/{produto:slug}', [CarrinhoController::class, 'store'])->name('store');
    Route::patch('/item/{item}', [CarrinhoController::class, 'update'])->name('update');
    Route::delete('/item/{item}', [CarrinhoController::class, 'destroy'])->name('destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', function () {
        return Auth::user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : view('dashboard');
    })->name('dashboard');

    Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/pedidos/{pedido:uuid}', [PedidoController::class, 'show'])->name('pedidos.show');

    Route::post('/enderecos', [EnderecoController::class, 'store'])->name('enderecos.store');
    Route::delete('/enderecos/{endereco}', [EnderecoController::class, 'destroy'])->name('enderecos.destroy');

    Route::get('/perfil', [PerfilController::class, 'edit'])->name('profile.edit');
    Route::patch('/perfil', [PerfilController::class, 'update'])->name('profile.update');
    Route::delete('/perfil', [PerfilController::class, 'destroy'])->name('profile.destroy');

    Route::middleware([\App\Http\Middleware\IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [PainelController::class, 'index'])->name('dashboard');
        Route::resource('produtos', AdminProdutoController::class)->except(['show']);
    });
});

require __DIR__.'/auth.php';