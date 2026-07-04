<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Painel administrativo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <p class="text-sm text-gray-500">Receita total</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">
                        R$ {{ number_format($metricas['receita_total'], 2, ',', '.') }}
                    </p>
                </div>

                <div class="bg-white shadow-sm rounded-lg p-6">
                    <p class="text-sm text-gray-500">Total de pedidos</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $metricas['total_pedidos'] }}</p>
                </div>

                <div class="bg-white shadow-sm rounded-lg p-6">
                    <p class="text-sm text-gray-500">Produtos com estoque baixo</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $metricas['produtos_estoque_baixo'] }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
