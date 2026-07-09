<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-display font-semibold text-2xl text-gray-900">
                {{ __('Painel Administrativo') }}
            </h2>
            <a href="{{ route('admin.produtos.index') }}"
               class="inline-flex items-center gap-2 bg-[#1a1a1a] text-white rounded-full px-5 py-2.5 text-xs font-bold tracking-wider uppercase hover:bg-gray-800 transition-all duration-300 shadow-lg hover:shadow-xl">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Gerenciar Produtos
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <!-- Receita -->
                <div class="bg-white rounded-3xl shadow-[0_0_0_1px_rgba(0,0,0,0.08),0_8px_24px_-4px_rgba(0,0,0,0.10)] p-6 sm:p-8 hover:shadow-lg transition-all duration-300">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-4-4.5c0 1.38 1.79 2.5 4 2.5s4-1.12 4-2.5-1.79-2.5-4-2.5-4-1.12-4-2.5S9.79 6 12 6s4 1.12 4 2.5" />
                            </svg>
                        </div>
                        <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 rounded-full px-2.5 py-1 tracking-wider uppercase">Faturado</span>
                    </div>
                    <p class="text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-1">Receita Total</p>
                    <p class="text-3xl font-display font-bold text-[#1a1a1a]">
                        R$ {{ number_format($metricas['receita_total'], 2, ',', '.') }}
                    </p>
                </div>

                <!-- Pedidos -->
                <div class="bg-white rounded-3xl shadow-[0_0_0_1px_rgba(0,0,0,0.08),0_8px_24px_-4px_rgba(0,0,0,0.10)] p-6 sm:p-8 hover:shadow-lg transition-all duration-300">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-violet-50 text-violet-600 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.836l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 1.994-4.694 2.608-7.164.075-.3-.155-.586-.464-.586H5.106M7.5 14.25 5.106 5.272" />
                            </svg>
                        </div>
                        <span class="text-[10px] font-bold text-violet-600 bg-violet-50 rounded-full px-2.5 py-1 tracking-wider uppercase">{{ $metricas['total_pedidos'] }} pedidos</span>
                    </div>
                    <p class="text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-1">Total de Pedidos</p>
                    <p class="text-3xl font-display font-bold text-[#1a1a1a]">{{ $metricas['total_pedidos'] }}</p>
                </div>

                <!-- Estoque Baixo -->
                <div class="bg-white rounded-3xl shadow-[0_0_0_1px_rgba(0,0,0,0.08),0_8px_24px_-4px_rgba(0,0,0,0.10)] p-6 sm:p-8 hover:shadow-lg transition-all duration-300">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                            </svg>
                        </div>
                        @if($metricas['produtos_estoque_baixo'] > 0)
                            <span class="text-[10px] font-bold text-amber-600 bg-amber-50 rounded-full px-2.5 py-1 tracking-wider uppercase">Atenção</span>
                        @else
                            <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 rounded-full px-2.5 py-1 tracking-wider uppercase">Ok</span>
                        @endif
                    </div>
                    <p class="text-[11px] font-bold text-gray-400 tracking-wider uppercase mb-1">Estoque Baixo</p>
                    <p class="text-3xl font-display font-bold {{ $metricas['produtos_estoque_baixo'] > 0 ? 'text-amber-600' : 'text-[#1a1a1a]' }}">
                        {{ $metricas['produtos_estoque_baixo'] }} {{ $metricas['produtos_estoque_baixo'] === 1 ? 'produto' : 'produtos' }}
                    </p>
                    @if($metricas['produtos_estoque_baixo'] > 0)
                        <a href="{{ route('admin.produtos.index') }}"
                           class="mt-4 inline-flex items-center gap-1 text-xs font-semibold text-amber-600 hover:text-amber-700 transition-colors">
                            Ver produtos
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-3xl shadow-[0_0_0_1px_rgba(0,0,0,0.08),0_8px_24px_-4px_rgba(0,0,0,0.10)] p-6 sm:p-8">
                <h3 class="font-display font-bold text-lg text-[#1a1a1a] mb-1">Ações Rápidas</h3>
                <p class="text-sm text-gray-400 font-medium mb-6">Gerencie sua loja com as ferramentas abaixo.</p>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.produtos.index') }}"
                       class="inline-flex items-center gap-2.5 bg-[#1a1a1a] text-white rounded-full px-7 py-3 font-bold text-sm tracking-wider uppercase hover:bg-gray-800 transition-all duration-300 shadow-lg hover:shadow-xl">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                        Produtos
                    </a>
                    <a href="{{ route('home') }}"
                       class="inline-flex items-center gap-2.5 bg-white text-[#1a1a1a] border-2 border-gray-200 rounded-full px-7 py-3 font-bold text-sm tracking-wider uppercase hover:bg-gray-50 hover:border-gray-300 transition-all duration-300 shadow-sm hover:shadow-lg">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.126 1.126 0 011.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        Ver Loja
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
