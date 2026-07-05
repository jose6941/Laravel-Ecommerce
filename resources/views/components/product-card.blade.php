@props(['produto'])

<a href="{{ route('produtos.show', $produto) }}"
   class="group flex flex-col overflow-hidden rounded-2xl bg-white border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition duration-200">
    <div class="relative aspect-square bg-gray-100 overflow-hidden">
        @if ($produto->imagemPrincipal)
            <img src="{{ $produto->imagemPrincipal->url }}" alt="{{ $produto->nome }}"
                 class="h-full w-full object-cover group-hover:scale-105 transition duration-300">
        @else
            <div class="h-full w-full flex items-center justify-center text-gray-400 text-sm">Sem imagem</div>
        @endif

        <div class="absolute top-3 left-3 flex flex-col gap-1.5">
            @if ($produto->destaque)
                <span class="inline-flex items-center rounded-full bg-violet-600 px-2.5 py-1 text-[11px] font-semibold text-white shadow-sm">
                    Destaque
                </span>
            @endif
            @if ($produto->preco_promocional)
                <span class="inline-flex items-center rounded-full bg-rose-600 px-2.5 py-1 text-[11px] font-semibold text-white shadow-sm">
                    -{{ round((1 - $produto->preco_promocional / $produto->preco) * 100) }}%
                </span>
            @endif
        </div>

        @if ($produto->estoque <= 0)
            <div class="absolute inset-0 bg-white/70 flex items-center justify-center">
                <span class="text-xs font-semibold text-gray-700 bg-white px-3 py-1 rounded-full shadow-sm">
                    Fora de estoque
                </span>
            </div>
        @endif
    </div>

    <div class="p-4 flex-1 flex flex-col">
        <span class="text-xs font-medium text-violet-600 uppercase tracking-wide">{{ $produto->categoria?->nome }}</span>
        <span class="mt-1 font-medium text-gray-900 leading-snug line-clamp-2">{{ $produto->nome }}</span>

        <div class="mt-auto pt-3 flex items-baseline gap-2">
            @if ($produto->preco_promocional)
                <span class="text-sm text-gray-400 line-through">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>
            @endif
            <span class="font-display font-semibold text-lg text-gray-900">
                R$ {{ number_format($produto->preco_final, 2, ',', '.') }}
            </span>
        </div>
    </div>
</a>
