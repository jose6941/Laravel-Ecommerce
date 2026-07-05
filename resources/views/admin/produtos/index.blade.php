<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-display font-semibold text-2xl text-gray-900">
                {{ __('Gerenciar Produtos') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">
                Voltar
            </a>
        </div>
    </x-slot>

    <div class="py-10 pb-24">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100 p-6">
                
                @if (session('success'))
                    <div class="mb-4 text-emerald-600 font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 rounded-t-lg">
                            <tr>
                                <th scope="col" class="px-4 py-3">Produto</th>
                                <th scope="col" class="px-4 py-3">Categoria</th>
                                <th scope="col" class="px-4 py-3">Preço</th>
                                <th scope="col" class="px-4 py-3">Estoque</th>
                                <th scope="col" class="px-4 py-3">Status</th>
                                <th scope="col" class="px-4 py-3">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produtos as $produto)
                                <tr class="border-b">
                                    <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $produto->nome }}
                                        @if($produto->destaque)
                                            <span class="ml-2 px-2 py-0.5 text-xs bg-yellow-100 text-yellow-800 rounded-full">Destaque</span>
                                        @endif
                                    </th>
                                    <td class="px-4 py-3">{{ $produto->categoria->nome }}</td>
                                    <td class="px-4 py-3">R$ {{ number_format($produto->preco_final, 2, ',', '.') }}</td>
                                    <td class="px-4 py-3">{{ $produto->estoque }}</td>
                                    <td class="px-4 py-3">
                                        @if($produto->ativo)
                                            <span class="text-emerald-600 font-semibold">Ativo</span>
                                        @else
                                            <span class="text-rose-600 font-semibold">Inativo</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <a href="{{ route('admin.produtos.edit', $produto->slug) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Editar</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    {{ $produtos->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
