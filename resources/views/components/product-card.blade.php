@props(['produto'])

<a href="{{ route('produtos.show', $produto) }}"
   class="group flex flex-col w-full bg-[#f4f4f5] rounded-xl p-5 transition-all duration-300 hover:shadow-xl relative overflow-hidden">
    
    <!-- Badge NOVIDADE -->
    <div class="absolute top-5 left-5 z-10 bg-white/80 backdrop-blur-sm text-[9px] font-bold px-2 py-1 tracking-widest uppercase text-dark shadow-sm">
        NOVIDADE
    </div>

    <div class="relative aspect-[4/3] bg-transparent flex items-center justify-center mb-6">
        @if ($produto->imagemPrincipal)
            <img src="{{ $produto->imagemPrincipal->url }}" alt="{{ $produto->nome }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out mix-blend-multiply">
        @else
            <div class="h-full w-full flex items-center justify-center text-gray-300 text-sm font-medium">Sem imagem</div>
        @endif

        @if ($produto->estoque <= 0)
            <div class="absolute inset-0 bg-[#f4f4f5]/80 backdrop-blur-sm flex items-center justify-center">
                <span class="text-xs font-bold text-white bg-dark px-4 py-1.5 rounded-full shadow-sm tracking-wide uppercase">
                    Esgotado
                </span>
            </div>
        @endif
    </div>

    <div class="flex flex-col flex-1 relative">
        <h3 class="font-display font-bold text-sm text-dark leading-tight uppercase tracking-wider mb-0.5 truncate">{{ $produto->nome }}</h3>
        <p class="text-[10px] text-gray-500 mb-4">{{ $produto->categoria->nome ?? 'Categoria' }}</p>
        
        <div class="mt-auto flex items-end justify-between">
            <span class="font-bold text-sm text-dark">
                R$ {{ number_format($produto->preco_final, 2, ',', '.') }}
            </span>
            
            <button class="w-8 h-8 bg-dark text-white rounded-full flex items-center justify-center hover:bg-gray-800 transition">
                <svg class="w-3.5 h-3.5 transform rotate-[-45deg]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
            </button>
        </div>
    </div>
</a>
