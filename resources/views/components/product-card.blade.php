@props(['produto'])

<a href="{{ route('produtos.show', $produto) }}"
   class="group flex flex-col w-full bg-white rounded-xl transition-all duration-300 shadow-sm hover:shadow-2xl hover:-translate-y-1 relative overflow-hidden border border-gray-100/50">
    
    <!-- Badge NOVIDADE -->
    <div class="absolute top-4 left-4 z-10 bg-white/90 backdrop-blur-sm text-[9px] font-bold px-2.5 py-1 tracking-[0.15em] uppercase text-dark shadow-sm rounded-full">
        NOVIDADE
    </div>

    <div class="relative aspect-[5/4] w-full overflow-hidden bg-gray-50">
        @if ($produto->imagemPrincipal)
            <img src="{{ $produto->imagemPrincipal->url }}" alt="{{ $produto->nome }}"
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
        @else
            <div class="h-full w-full flex items-center justify-center text-gray-300 text-sm font-medium">Sem imagem</div>
        @endif

        @if ($produto->estoque <= 0)
            <div class="absolute inset-0 bg-white/70 backdrop-blur-sm flex items-center justify-center">
                <span class="text-xs font-bold text-white bg-dark px-4 py-1.5 rounded-full shadow-sm tracking-wide uppercase">
                    Esgotado
                </span>
            </div>
        @endif
    </div>

    <div class="flex flex-col flex-1 relative p-4 sm:p-5">
        <h3 class="font-display font-bold text-sm sm:text-base text-dark leading-tight uppercase tracking-wider mb-0.5 truncate">{{ $produto->nome }}</h3>
        <p class="text-[10px] text-gray-400 font-medium mb-3 sm:mb-4">{{ $produto->categoria->nome ?? 'Categoria' }}</p>
        
        <div class="mt-auto flex items-end justify-between">
            <div class="flex flex-col">
                @if ($produto->preco_original && $produto->preco_original > $produto->preco_final)
                    <span class="text-[10px] text-gray-400 line-through">R$ {{ number_format($produto->preco_original, 2, ',', '.') }}</span>
                @endif
                <span class="font-bold text-sm sm:text-base text-dark">
                    R$ {{ number_format($produto->preco_final, 2, ',', '.') }}
                </span>
            </div>
            
            <button class="w-9 h-9 bg-dark text-white rounded-full flex items-center justify-center hover:bg-gray-800 transition-transform duration-300 hover:scale-110 shadow-md">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14" /></svg>
            </button>
        </div>
    </div>
</a>
