@props(['produto'])

@php
    $mediaEstrelas = $produto->avaliacoesAprovadas->avg('nota') ?? 0;
    $totalAvaliacoes = $produto->avaliacoesAprovadas->count();
@endphp

<a href="{{ route('produtos.show', $produto) }}"
   class="group flex flex-col w-full bg-white rounded-2xl transition-all duration-500 ease-out shadow-sm hover:shadow-xl hover:-translate-y-1 relative overflow-hidden border border-gray-100/50">
    
    @if ($produto->created_at->diffInDays(now()) < 30)
        <!-- Badge NOVIDADE (estilo refinado Sênior) -->
        <div class="absolute top-4 left-4 z-10 bg-brand text-white text-xs font-bold px-3 py-1 tracking-widest uppercase shadow-md rounded-full">
            NOVO
        </div>
    @endif

    @if ($produto->preco_promocional)
        <div class="absolute top-4 right-4 z-10 bg-rose-500 text-white text-xs font-bold px-3 py-1 tracking-widest uppercase shadow-md rounded-full">
            -{{ round((1 - $produto->preco_promocional / $produto->preco) * 100) }}%
        </div>
    @endif

    <!-- Container da Imagem com Aspect Ratio perfeito -->
    <div class="relative aspect-square w-full overflow-hidden bg-gray-50 flex items-center justify-center">
        @if ($produto->imagemPrincipal)
            <x-img-skeleton src="{{ $produto->imagemPrincipal->url }}" alt="{{ $produto->nome }}"
                 class="w-full h-full object-cover transition-transform duration-[800ms] ease-[cubic-bezier(0.25,1,0.5,1)] group-hover:scale-105" />
        @else
            <div class="h-full w-full flex items-center justify-center text-gray-400 text-sm font-medium">S/ Imagem</div>
        @endif

        @if ($produto->estoque <= 0)
            <div class="absolute inset-0 bg-white/60 backdrop-blur-sm flex items-center justify-center z-20 transition-all duration-300">
                <span class="text-xs font-bold text-dark bg-white/90 px-5 py-2 rounded-full shadow-lg tracking-widest uppercase">
                    Esgotado
                </span>
            </div>
        @endif

        <!-- Quick add button (Hover Sólido) -->
        <div class="absolute bottom-4 inset-x-4 opacity-0 translate-y-2 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 ease-out z-20">
            <div class="bg-dark text-white text-xs font-bold tracking-widest uppercase rounded-full py-3 px-4 text-center shadow-lg hover:bg-dark/80 transition-colors flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14" /></svg>
                Comprar
            </div>
        </div>
    </div>

    <!-- Informações do Produto -->
    <div class="flex flex-col flex-1 p-4 sm:p-5 relative z-10 bg-white">
        <!-- Categoria -->
        <p class="text-xs text-gray-500 font-medium uppercase tracking-wider mb-2">
            {{ $produto->categoria->nome ?? 'Exclusivo' }}
        </p>
        
        <!-- Nome -->
        <h3 class="font-display font-semibold text-sm sm:text-base text-dark leading-snug mb-2">
            {{ $produto->nome }}
        </h3>
        
        <!-- Avaliações (estrelas) -->
        @if ($totalAvaliacoes > 0)
            <div class="flex items-center gap-1.5 mb-4">
                <div class="flex text-brand">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= round($mediaEstrelas))
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        @else
                            <svg class="w-3.5 h-3.5 text-gray-200" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        @endif
                    @endfor
                </div>
                <span class="text-xs text-gray-400 font-medium tracking-wide">({{ $totalAvaliacoes }})</span>
            </div>
        @else
            <div class="mb-4"></div>
        @endif
        
        <!-- Preços e Botão -->
        <div class="mt-auto flex items-end justify-between gap-3 pt-2">
            <div class="flex flex-col">
                @if ($produto->preco_promocional)
                    <span class="text-xs text-gray-400 line-through mb-0.5">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>
                    <span class="font-bold text-base text-rose-600 leading-none">
                        R$ {{ number_format($produto->preco_promocional, 2, ',', '.') }}
                    </span>
                @else
                    <span class="font-bold text-base text-dark leading-none">
                        R$ {{ number_format($produto->preco_final, 2, ',', '.') }}
                    </span>
                @endif
            </div>
            
            <!-- Carrinho Rápido (Desktop Hover / Mobile Visible) -->
            <div class="flex shrink-0 relative z-30">
                @auth
                    <form method="POST" action="{{ route('carrinho.store') }}">
                        @csrf
                        <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                        <input type="hidden" name="quantidade" value="1">
                        <button type="submit"
                                onclick="event.stopPropagation()"
                                class="w-10 h-10 bg-brand text-white rounded-full flex items-center justify-center hover:bg-brand-dark transition-all duration-300 shadow hover:shadow-md active:scale-95"
                                aria-label="Adicionar ao carrinho">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14" /></svg>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       onclick="event.stopPropagation()"
                       class="w-10 h-10 bg-brand text-white rounded-full flex items-center justify-center hover:bg-brand-dark transition-all duration-300 shadow hover:shadow-md active:scale-95"
                       aria-label="Login para comprar">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14" /></svg>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</a>
