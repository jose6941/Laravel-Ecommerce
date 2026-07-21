<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-display font-semibold text-2xl text-gray-900">
                {{ __('Gerenciar Produtos') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}"
               class="inline-flex items-center gap-2 bg-white text-[#1a1a1a] border-2 border-gray-200 rounded-full px-5 py-2.5 text-xs font-bold tracking-wider uppercase hover:bg-gray-50 hover:border-gray-300 transition-all duration-300 shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Voltar
            </a>
        </div>
    </x-slot>

    <div class="py-10 pb-24">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-[0_0_0_1px_rgba(0,0,0,0.08),0_8px_24px_-4px_rgba(0,0,0,0.10)] overflow-hidden">


                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-50">
                                <th scope="col" class="px-6 py-5 text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider">Produto</th>
                                <th scope="col" class="px-6 py-5 text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider">Categoria</th>
                                <th scope="col" class="px-6 py-5 text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider">Preço</th>
                                <th scope="col" class="px-6 py-5 text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider">Estoque</th>
                                <th scope="col" class="px-6 py-5 text-left text-[11px] font-bold text-gray-400 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-5 text-right text-[11px] font-bold text-gray-400 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach ($produtos as $produto)
                                <tr class="hover:bg-gray-50/50 transition-colors duration-150">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            @if($produto->imagemPrincipal)
                                                <div class="w-10 h-10 rounded-xl bg-gray-50 overflow-hidden shrink-0">
                                                    <img src="{{ $produto->imagemPrincipal->url }}" alt="{{ $produto->nome }}" class="w-full h-full object-contain p-1">
                                                </div>
                                            @else
                                                <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center shrink-0">
                                                    <svg class="w-5 h-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z" />
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="min-w-0">
                                                <p class="font-semibold text-[#1a1a1a] truncate max-w-[200px]">{{ $produto->nome }}</p>
                                                <p class="text-[11px] text-gray-400 font-mono mt-0.5">{{ $produto->sku }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-xs font-medium text-gray-500">{{ $produto->categoria->nome }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            @if ($produto->preco_promocional)
                                                <span class="font-bold text-[#1a1a1a]">R$ {{ number_format($produto->preco_promocional, 2, ',', '.') }}</span>
                                                <span class="text-xs text-gray-400 line-through">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>
                                            @else
                                                <span class="font-bold text-[#1a1a1a]">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold
                                            {{ $produto->estoque > 10 ? 'text-emerald-600' : ($produto->estoque > 0 ? 'text-amber-600' : 'text-rose-600') }}">
                                            <span class="w-1.5 h-1.5 rounded-full inline-block
                                                {{ $produto->estoque > 10 ? 'bg-emerald-500' : ($produto->estoque > 0 ? 'bg-amber-500' : 'bg-rose-500') }}"></span>
                                            {{ $produto->estoque }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($produto->ativo)
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full text-xs font-semibold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Ativo
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-50 text-gray-500 rounded-full text-xs font-semibold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                                Inativo
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.produtos.edit', $produto->slug) }}"
                                               class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#1a1a1a] text-white rounded-full text-xs font-bold hover:bg-gray-800 transition-all duration-200 shadow-sm hover:shadow-md">
                                                Editar
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.produtos.destroy', $produto->slug) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este produto?');" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-red-50 text-red-600 rounded-full text-xs font-bold hover:bg-red-100 transition-all duration-200 shadow-sm hover:shadow-md">
                                                    Excluir
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($produtos->hasPages())
                    <div class="px-6 py-5 border-t border-gray-50">
                        {{ $produtos->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
