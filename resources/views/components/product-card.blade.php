@props(['produto'])

<a href="{{ route('produtos.show', $produto) }}"
   class="group flex flex-col overflow-hidden w-full">
    <div class="relative aspect-[4/5] bg-[#F5F5F5] rounded-2xl overflow-hidden mb-3">
        @if ($produto->imagemPrincipal)
            <img src="{{ $produto->imagemPrincipal->url }}" alt="{{ $produto->nome }}"
                 class="h-full w-full object-cover mix-blend-multiply group-hover:scale-105 transition duration-300">
        @else
            <div class="h-full w-full flex items-center justify-center text-gray-400 text-sm">Sem imagem</div>
        @endif

        <!-- Heart Icon (Favorite placeholder) -->
        <button class="absolute top-3 right-3 h-8 w-8 rounded-full bg-white flex items-center justify-center shadow-sm text-gray-400 hover:text-red-500">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
        </button>

        @if ($produto->estoque <= 0)
            <div class="absolute inset-0 bg-white/70 flex items-center justify-center">
                <span class="text-xs font-semibold text-gray-700 bg-white px-3 py-1 rounded-full shadow-sm">
                    Esgotado
                </span>
            </div>
        @endif
    </div>

    <div class="flex flex-col px-1">
        <h3 class="font-medium text-gray-900 leading-snug truncate">{{ $produto->nome }}</h3>
        
        <div class="mt-1 flex items-center gap-1.5 text-[11px] text-gray-500 font-medium">
            <svg class="w-3.5 h-3.5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <span>4.5 (80)</span>
            <span class="mx-0.5">&bull;</span>
            <span>200 Vendidos</span>
        </div>

        <div class="mt-2 flex items-baseline gap-2">
            <span class="font-bold text-base text-gray-900">
                R$ {{ number_format($produto->preco_final, 2, ',', '.') }}
            </span>
            @if ($produto->preco_promocional)
                <span class="text-xs text-gray-400 line-through">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>
            @endif
        </div>
    </div>
</a>
