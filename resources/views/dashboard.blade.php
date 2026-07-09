<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-semibold text-2xl text-gray-900">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Welcome Card -->
            <div class="bg-white rounded-3xl shadow-[0_0_0_1px_rgba(0,0,0,0.08),0_8px_24px_-4px_rgba(0,0,0,0.10)] p-8 sm:p-10">
                <div class="flex items-start gap-5">
                    <!-- Avatar / Icon -->
                    <div class="hidden sm:flex w-14 h-14 rounded-2xl bg-[#1a1a1a] text-white items-center justify-center shrink-0 shadow-lg">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </div>

                    <div class="flex-1 min-w-0">
                        <h1 class="font-display font-bold text-2xl text-[#1a1a1a] mb-1">
                            Olá, {{ Auth::user()->name }}!
                        </h1>
                        <p class="text-gray-400 font-medium text-sm">
                            Bem-vindo à sua área do cliente. Aqui você pode gerenciar seus pedidos, carrinho e perfil.
                        </p>

                        <div class="mt-6 flex flex-wrap gap-3">
                            <a href="{{ route('produtos.index') }}"
                               class="inline-flex items-center gap-2.5 bg-[#1a1a1a] text-white rounded-full px-7 py-3 font-bold text-sm tracking-wider uppercase hover:bg-gray-800 transition-all duration-300 shadow-lg hover:shadow-xl">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 11.625l2.25-2.25M12 11.625l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                </svg>
                                Ver Produtos
                            </a>
                            <a href="{{ route('carrinho.index') }}"
                               class="inline-flex items-center gap-2.5 bg-white text-[#1a1a1a] border-2 border-gray-200 rounded-full px-7 py-3 font-bold text-sm tracking-wider uppercase hover:bg-gray-50 hover:border-gray-300 transition-all duration-300 shadow-sm hover:shadow-lg">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.836l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 1.994-4.694 2.608-7.164.075-.3-.155-.586-.464-.586H5.106M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                </svg>
                                Meu Carrinho
                            </a>
                            <a href="{{ route('profile.edit') }}"
                               class="inline-flex items-center gap-2.5 bg-white text-[#1a1a1a] border-2 border-gray-200 rounded-full px-7 py-3 font-bold text-sm tracking-wider uppercase hover:bg-gray-50 hover:border-gray-300 transition-all duration-300 shadow-sm hover:shadow-lg">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                                Meu Perfil
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Info Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.836l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 1.994-4.694 2.608-7.164.075-.3-.155-.586-.464-.586H5.106M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[11px] font-bold text-gray-400 tracking-wider uppercase">Compras</p>
                            <p class="font-bold text-lg text-[#1a1a1a]">{{ App\Models\Pedido::where('usuario_id', Auth::id())->count() }}</p>
                        </div>
                    </div>
                    <a href="{{ route('produtos.index') }}" class="text-xs font-semibold text-[#1a1a1a] hover:underline flex items-center gap-1">
                        Explorar produtos
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>

                <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                            </svg>
                        </div>
                        <div class="min-w-0 overflow-hidden">
                            <p class="text-[11px] font-bold text-gray-400 tracking-wider uppercase">Conta</p>
                            <p class="font-bold text-lg text-[#1a1a1a] truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="text-xs font-semibold text-[#1a1a1a] hover:underline flex items-center gap-1">
                        Gerenciar perfil
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>

                <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[11px] font-bold text-gray-400 tracking-wider uppercase">Loja</p>
                            <p class="font-bold text-lg text-[#1a1a1a]">{{ App\Models\Produto::count() }} produtos</p>
                        </div>
                    </div>
                    <a href="{{ route('produtos.index') }}" class="text-xs font-semibold text-[#1a1a1a] hover:underline flex items-center gap-1">
                        Ver catálogo
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
