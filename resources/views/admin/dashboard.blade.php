<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-semibold text-2xl text-gray-900">
            {{ __('Painel administrativo') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-4-4.5c0 1.38 1.79 2.5 4 2.5s4-1.12 4-2.5-1.79-2.5-4-2.5-4-1.12-4-2.5S9.79 6 12 6s4 1.12 4 2.5" />
                            </svg>
                        </span>
                        <p class="text-sm text-gray-500">Receita total</p>
                    </div>
                    <p class="text-2xl font-display font-semibold text-gray-900 mt-3">
                        R$ {{ number_format($metricas['receita_total'], 2, ',', '.') }}
                    </p>
                </div>

                <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-50 text-violet-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.836l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 1.994-4.694 2.608-7.164.075-.3-.155-.586-.464-.586H5.106M7.5 14.25 5.106 5.272" />
                            </svg>
                        </span>
                        <p class="text-sm text-gray-500">Total de pedidos</p>
                    </div>
                    <p class="text-2xl font-display font-semibold text-gray-900 mt-3">{{ $metricas['total_pedidos'] }}</p>
                </div>

                <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                            </svg>
                        </span>
                        <p class="text-sm text-gray-500">Produtos com estoque baixo</p>
                    </div>
                    <p class="text-2xl font-display font-semibold text-gray-900 mt-3">{{ $metricas['produtos_estoque_baixo'] }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
