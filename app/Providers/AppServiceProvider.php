<?php

namespace App\Providers;

use App\Models\Carrinho;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::component('layouts.app', 'app-layout');
        Blade::component('layouts.guest', 'guest-layout');

        // Disponibiliza a quantidade de itens no carrinho para o menu,
        // sem precisar repetir essa consulta em cada controller.
        View::composer('layouts.navigation', function ($view) {
            $carrinho = Auth::check()
                ? Carrinho::where('usuario_id', Auth::id())->first()
                : Carrinho::where('sessao_id', session()->getId())->first();

            $view->with('quantidadeCarrinho', $carrinho?->itens()->sum('quantidade') ?? 0);
        });
    }
}
