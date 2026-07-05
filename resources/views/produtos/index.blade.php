<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-semibold text-2xl text-gray-900">
            {{ __('Produtos') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="px-4 sm:px-0 space-y-5 mb-8">
                <form method="GET" action="{{ route('produtos.index') }}" class="flex gap-3">
                    @if (request('categoria'))
                        <input type="hidden" name="categoria" value="{{ request('categoria') }}">
                    @endif
                    <div class="relative flex-1">
                        <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.34-4.34M19 11a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z" />
                        </svg>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar produtos..."
                            class="w-full pl-10 border-gray-300 rounded-lg shadow-sm focus:ring-violet-500 focus:border-violet-500">
                    </div>
                    <x-primary-button type="submit">Buscar</x-primary-button>
                </form>

                @if ($categorias->isNotEmpty())
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('produtos.index', array_filter(['q' => request('q')])) }}"
                           class="inline-flex items-center rounded-full px-4 py-1.5 text-sm font-medium transition
                                  {{ request('categoria') ? 'border border-gray-200 bg-white text-gray-600 hover:border-violet-300 hover:text-violet-700' : 'bg-violet-600 text-white' }}">
                            Todas
                        </a>
                        @foreach ($categorias as $categoria)
                            <a href="{{ route('produtos.index', array_filter(['categoria' => $categoria->slug, 'q' => request('q')])) }}"
                               class="inline-flex items-center rounded-full px-4 py-1.5 text-sm font-medium transition
                                      {{ request('categoria') === $categoria->slug ? 'bg-violet-600 text-white' : 'border border-gray-200 bg-white text-gray-600 hover:border-violet-300 hover:text-violet-700' }}">
                                {{ $categoria->nome }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            @if ($produtos->isEmpty())
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-10 text-center mx-4 sm:mx-0">
                    <p class="text-gray-700 font-medium">Nenhum produto encontrado.</p>
                    <p class="text-gray-500 text-sm mt-1">Tente buscar por outro termo ou remover os filtros aplicados.</p>
                </div>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5 px-4 sm:px-0">
                    @foreach ($produtos as $produto)
                        <x-product-card :produto="$produto" />
                    @endforeach
                </div>

                <div class="mt-8 px-4 sm:px-0">
                    {{ $produtos->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
