<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-semibold text-2xl text-gray-900">
            {{ __('Meus Pedidos') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-3xl border border-gray-100">
                <div class="p-8 sm:p-10">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 font-display">Histórico de Compras</h3>
                            <p class="text-sm text-gray-500 mt-1">Acompanhe e gerencie todos os seus pedidos realizados.</p>
                        </div>
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-xs font-bold tracking-[0.15em] uppercase text-gray-600 bg-gray-100 hover:bg-gray-200 hover:text-gray-900 transition-all duration-300 rounded-full">
                            Voltar ao Painel
                        </a>
                    </div>

                    @if($pedidos->isEmpty())
                        <div class="text-center py-12 bg-gray-50 rounded-2xl">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900">Nenhum pedido encontrado</h3>
                            <p class="mt-1 text-sm text-gray-500">Você ainda não realizou nenhuma compra.</p>
                            <div class="mt-6">
                                <a href="{{ route('produtos.index') }}" class="inline-flex items-center gap-2.5 bg-[#1a1a1a] text-white rounded-full px-7 py-3 font-bold text-sm tracking-wider uppercase hover:bg-gray-800 transition-all duration-300 shadow-lg hover:shadow-xl">
                                    Explorar Produtos
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-xl">
                                            Nº do Pedido
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                            Data
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                            Total
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-xl">
                                            Ações
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach($pedidos as $pedido)
                                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                #{{ substr($pedido->uuid, 0, 8) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $pedido->created_at->format('d/m/Y H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $pedido->status === 'concluido' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $pedido->status === 'pendente' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                    {{ $pedido->status === 'cancelado' ? 'bg-red-100 text-red-800' : '' }}
                                                    {{ !in_array($pedido->status, ['concluido', 'pendente', 'cancelado']) ? 'bg-blue-100 text-blue-800' : '' }}">
                                                    {{ ucfirst($pedido->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                                R$ {{ number_format($pedido->total, 2, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('pedidos.show', $pedido) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold inline-flex items-center gap-1">
                                                    Detalhes
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
