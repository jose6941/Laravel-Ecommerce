@props(['produto'])

@php
    $mediaEstrelas = $produto->avaliacoesAprovadas->avg('nota') ?? 0;
    $totalAvaliacoes = $produto->avaliacoesAprovadas->count();
@endphp

<a href="{{ route('produtos.show', $produto) }}"
   class="group flex flex-col w-full bg-white rounded-2xl transition-all duration-500 shadow-md hover:shadow-2xl hover:-translate-y-2 relative overflow-hidden border border-gray-100">
    
    @if ($produto->created_at->diffInDays(now()) < 30)
        <!-- Badge NOVIDADE (estilo mais vibrante) -->
        <div class="absolute top-3 left-3 z-10 bg-brand text-white text-[8px] font-bold px-3 py-1.5 tracking-[0.12em] uppercase shadow-lg rounded-full">
            NOVIDADE
        </div>
    @endif

    @if ($produto->preco_promocional)
        <div class="absolute top-3 right-3 z-10 bg-rose-500 text-white text-[8px] font-bold px-3 py-1.5 tracking-[0.12em] uppercase shadow-lg rounded-full">
            -{{ round((1 - $produto->preco_promocional / $produto->preco) * 100) }}%
        </div>
    @endif        <div class="relative aspect-square w-full overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100">
            @if ($produto->imagemPrincipal)
                <x-img-skeleton src="{{ $produto->imagemPrincipal->url }}" alt="{{ $produto->nome }}"
                     class="w-full h-full object-cover group-hover:scale-110 transition-all duration-700 ease-out group-hover:rotate-[2deg]" />
            @else
                <div class="h-full w-full flex items-center justify-center text-gray-300 text-sm font-medium">Sem imagem</div>
            @endif

        @if ($produto->estoque <= 0)
            <div class="absolute inset-0 bg-white/80 backdrop-blur-[2px] flex items-center justify-center">
                <span class="text-[10px] font-bold text-white bg-dark px-4 py-1.5 rounded-full shadow-lg tracking-wider uppercase">
                    Esgotado
                </span>
            </div>
        @endif

        <!-- Quick add button aparece no hover -->
        <div class="absolute bottom-3 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-400 ease-out w-[calc(100%-24px)]">
            <div class="bg-dark/90 backdrop-blur-sm text-white text-[10px] font-bold tracking-wider uppercase rounded-full py-2.5 px-4 text-center shadow-xl hover:bg-dark transition-colors duration-300 flex items-center justify-center gap-2">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14" /></svg>
                Adicionar
            </div>
        </div>
    </div>

    <div class="flex flex-col flex-1 relative p-3 sm:p-4">
        <!-- Categoria -->
        <p class="text-[9px] text-gray-400 font-semibold uppercase tracking-[0.15em] mb-1">{{ $produto->categoria->nome ?? 'Categoria' }}</p>
        
        <!-- Nome -->
        <h3 class="font-display font-bold text-sm sm:text-base text-dark leading-tight mb-1.5 line-clamp-2">{{ $produto->nome }}</h3>
        
        <!-- Avaliações (estrelas) -->
        @if ($totalAvaliacoes > 0)
            <div class="flex items-center gap-1.5 mb-2">
                <div class="flex text-brand">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= round($mediaEstrelas))
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        @else
                            <svg class="w-3 h-3 text-gray-200" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        @endif
                    @endfor
                </div>
                <span class="text-[10px] text-gray-400 font-medium">({{ $totalAvaliacoes }})</span>
            </div>
        @endif
        
        <div class="mt-auto flex items-end justify-between gap-2">
            <div class="flex flex-col">
                @if ($produto->preco_promocional)
                    <span class="text-[10px] text-gray-400 line-through leading-tight">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>
                    <span class="font-bold text-sm sm:text-base text-rose-600 leading-tight">
                        R$ {{ number_format($produto->preco_promocional, 2, ',', '.') }}
                    </span>
                @else
                    <span class="font-bold text-sm sm:text-base text-dark leading-tight">
                        R$ {{ number_format($produto->preco_final, 2, ',', '.') }}
                    </span>
                @endif
            </div>
            
            <div class="flex gap-1.5">
                @auth
                    <form method="POST" action="{{ route('carrinho.store') }}" class="inline">
                        @csrf
                        <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                        <input type="hidden" name="quantidade" value="1">
                        <button type="submit"
                                onclick="event.stopPropagation()"
                                class="w-9 h-9 bg-brand text-white rounded-full flex items-center justify-center hover:bg-brand-dark hover:scale-110 transition-all duration-300 shadow-md hover:shadow-lg">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14" /></svg>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       onclick="event.stopPropagation()"
                       class="w-9 h-9 bg-brand text-white rounded-full flex items-center justify-center hover:bg-brand-dark hover:scale-110 transition-all duration-300 shadow-md hover:shadow-lg">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14" /></svg>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</a>
