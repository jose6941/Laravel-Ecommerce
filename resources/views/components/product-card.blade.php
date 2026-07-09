@props(['produto'])

<a href="{{ route('produtos.show', $produto) }}"
   class="group flex flex-col w-full bg-white rounded-xl transition-all duration-300 shadow-lg hover:shadow-2xl hover:-translate-y-1 relative overflow-hidden border border-gray-200">
    
    <!-- Badge NOVIDADE -->
    <div class="absolute top-3 left-3 z-10 bg-white/90 backdrop-blur-sm text-[8px] font-bold px-2.5 py-1 tracking-[0.15em] uppercase text-dark shadow-sm rounded-full">
        NOVIDADE
    </div>

    <div class="relative aspect-[16/9] w-full overflow-hidden bg-gray-50">
        @if ($produto->imagemPrincipal)
            <img src="{{ $produto->imagemPrincipal->url }}" alt="{{ $produto->nome }}"
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
        @else
            <div class="h-full w-full flex items-center justify-center text-gray-300 text-sm font-medium">Sem imagem</div>
        @endif

        @if ($produto->estoque <= 0)
            <div class="absolute inset-0 bg-white/70 backdrop-blur-sm flex items-center justify-center">
                <span class="text-[10px] font-bold text-white bg-dark px-3 py-1 rounded-full shadow-sm tracking-wide uppercase">
                    Esgotado
                </span>
            </div>
        @endif
    </div>

    <div class="flex flex-col flex-1 relative p-2.5 sm:p-3">
        <h3 class="font-display font-bold text-xs sm:text-sm text-dark leading-tight uppercase tracking-wider truncate">{{ $produto->nome }}</h3>
        <p class="text-[9px] text-gray-400 font-medium mb-1.5 sm:mb-2">{{ $produto->categoria->nome ?? 'Categoria' }}</p>
        
        <div class="mt-auto flex items-end justify-between">
            <div class="flex flex-col">
                @if ($produto->preco_original && $produto->preco_original > $produto->preco_final)
                    <span class="text-[9px] text-gray-400 line-through leading-tight">R$ {{ number_format($produto->preco_original, 2, ',', '.') }}</span>
                @endif
                <span class="font-bold text-xs sm:text-sm text-dark leading-tight">
                    R$ {{ number_format($produto->preco_final, 2, ',', '.') }}
                </span>
            </div>
            
            <button class="w-8 h-8 bg-dark text-white rounded-full flex items-center justify-center hover:bg-gray-800 transition-transform duration-300 hover:scale-110 shadow-md" onclick="event.preventDefault(); event.stopPropagation();">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14" /></svg>
            </button>
        </div>
    </div>
</a>
