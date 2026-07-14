@props(['produto'])

@php
    $mediaEstrelas = $produto->avaliacoesAprovadas->avg('nota') ?? 0;
    $totalAvaliacoes = $produto->avaliacoesAprovadas->count();
    $descontoPercentual = $produto->preco_promocional && $produto->preco > 0
        ? round((1 - $produto->preco_promocional / $produto->preco) * 100)
        : 0;
    $temDesconto = $produto->preco_promocional && $descontoPercentual > 0;
    $temEstoqueBaixo = $produto->estoque > 0 && $produto->estoque <= 5;
    $temBadgeDireita = $temDesconto || $temEstoqueBaixo;
@endphp

<div class="group h-full flex flex-col w-full bg-white rounded-2xl transition-all duration-500 ease-out shadow-sm hover:shadow-xl hover:-translate-y-1 relative overflow-hidden border border-gray-100/50">
    
    <!-- Badges (fora do <a> para empilhamento consistente) -->
    <div class="absolute inset-0 pointer-events-none z-20">
        @if ($temDesconto)
            <div class="absolute top-3 left-3 bg-rose-500 text-white text-[10px] font-bold px-2.5 py-1 tracking-widest uppercase shadow-md rounded-full pointer-events-auto">
                -{{ $descontoPercentual }}%
            </div>
        @endif

        @if ($produto->created_at->diffInDays(now()) < 30)
            <div class="absolute top-3 right-3 bg-brand text-white text-[10px] font-bold px-2.5 py-1 tracking-widest uppercase shadow-md rounded-full pointer-events-auto">
                NOVO
            </div>
        @endif

        @if ($temEstoqueBaixo)
            <div class="absolute {{ $produto->created_at->diffInDays(now()) < 30 ? 'top-10' : 'top-3' }} right-3 bg-amber-500 text-white text-[9px] font-bold px-2 py-0.5 rounded-full pointer-events-auto">
                Últimas unidades
            </div>
        @endif
    </div>

    <!-- Imagem clicável → link para o produto -->
    <a href="{{ route('produtos.show', $produto) }}" class="relative block w-full overflow-hidden bg-gray-50 shrink-0 aspect-square">
        @if ($produto->imagemPrincipal)
            <x-img-skeleton src="{{ $produto->imagemPrincipal->url }}" alt="{{ $produto->nome }}"
                 class="w-full h-full object-cover transition-transform duration-[800ms] ease-[cubic-bezier(0.25,1,0.5,1)] group-hover:scale-105" />
        @else
            <div class="h-full w-full flex items-center justify-center text-gray-300 text-sm font-medium">
                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z" /></svg>
            </div>
        @endif

        @if ($produto->estoque <= 0)
            <div class="absolute inset-0 bg-white/60 backdrop-blur-sm flex items-center justify-center z-20">
                <span class="text-[11px] font-bold text-dark bg-white/90 px-5 py-2 rounded-full shadow-lg tracking-widest uppercase">Esgotado</span>
            </div>
        @endif

        <!-- Overlay sutil no hover + ícone de visualizar -->
        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/[0.04] transition-all duration-500"></div>
        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-400">
            <span class="bg-white/90 backdrop-blur-sm text-dark text-[10px] font-bold px-4 py-2 rounded-full shadow-lg flex items-center gap-1.5 translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m3-3h-6" /></svg>
                Ver detalhes
            </span>
        </div>
    </a>

    <!-- Conteúdo textual do card → estrutura de altura uniforme -->
    <div class="p-4 sm:p-5 flex-1 flex flex-col">
        
        <!-- Seção superior (expansível) -->
        <div class="flex-1 flex flex-col gap-1.5">
            <!-- Categoria -->
            <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-[0.15em]">
                {{ $produto->categoria->nome ?? 'Exclusivo' }}
            </p>

            <!-- Nome do produto -->
            <h3 class="font-display font-semibold text-sm sm:text-base leading-snug text-dark">
                <a href="{{ route('produtos.show', $produto) }}" class="hover:text-brand transition-colors duration-200 line-clamp-2">
                    {{ $produto->nome }}
                </a>
            </h3>

            <!-- Descrição curta (placeholder invisível se vazio para manter altura) -->
            @if ($produto->descricao)
                <p class="text-xs text-gray-500 leading-relaxed line-clamp-2 min-h-[2.6em]">
                    {{ Str::limit(strip_tags($produto->descricao), 80) }}
                </p>
            @else
                <div class="h-[2.6em]"></div>
            @endif

            <!-- Avaliações (estrelas) → sempre ocupa espaço -->
            <div class="flex items-center gap-1.5 {{ $totalAvaliacoes > 0 ? '' : 'invisible' }}">
                <div class="flex gap-[1px]">
                    @for ($i = 1; $i <= 5; $i++)
                        <svg class="w-3 h-3 {{ $totalAvaliacoes > 0 && $i <= round($mediaEstrelas) ? 'text-brand' : ($totalAvaliacoes > 0 ? 'text-gray-200' : 'text-gray-100') }}" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    @endfor
                </div>
                <span class="text-[10px] text-gray-400 font-medium">{{ $totalAvaliacoes > 0 ? '(' . $totalAvaliacoes . ')' : '(0)' }}</span>
            </div>
        </div>

        <!-- Seção inferior (sempre no final) -->
        <div class="mt-auto pt-3 flex items-center justify-between gap-2 border-t border-gray-100">
            <!-- Preço -->
            <div class="flex flex-col">
                @if ($produto->preco_promocional)
                    <span class="text-[11px] text-gray-400 line-through">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>
                    <span class="font-bold text-base text-rose-600">R$ {{ number_format($produto->preco_promocional, 2, ',', '.') }}</span>
                @else
                    <span class="font-bold text-base text-dark">R$ {{ number_format($produto->preco_final, 2, ',', '.') }}</span>
                @endif
            </div>

            <!-- Botão Adicionar ao Carrinho -->
            @if ($produto->estoque > 0)
                @auth
                    <form method="POST" action="{{ route('carrinho.store') }}">
                        @csrf
                        <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                        <input type="hidden" name="quantidade" value="1">
                        <button type="submit"
                                class="w-10 h-10 bg-brand text-white rounded-full flex items-center justify-center hover:bg-brand-dark hover:scale-105 active:scale-95 transition-all duration-300 shadow-md hover:shadow-lg shrink-0"
                                title="Adicionar ao carrinho">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.836l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 1.994-4.694 2.608-7.164.075-.3-.155-.586-.464-.586H5.106M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                            </svg>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="w-10 h-10 bg-brand text-white rounded-full flex items-center justify-center hover:bg-brand-dark hover:scale-105 active:scale-95 transition-all duration-300 shadow-md hover:shadow-lg shrink-0"
                       title="Faça login para comprar">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                    </a>
                @endauth
            @else
                <div class="w-10 h-10 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center cursor-not-allowed shrink-0" title="Produto esgotado">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>
                </div>
            @endif
        </div>
    </div>
</div>
