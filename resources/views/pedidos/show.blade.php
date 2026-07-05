<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-semibold text-2xl text-gray-900">
            {{ __('Pedido') }} #{{ $pedido->id }}
        </h2>
    </x-slot>

    @php
        $statusEstilos = [
            'pendente' => 'bg-amber-50 text-amber-700',
            'pago' => 'bg-blue-50 text-blue-700',
            'enviado' => 'bg-violet-50 text-violet-700',
            'entregue' => 'bg-emerald-50 text-emerald-700',
            'cancelado' => 'bg-rose-50 text-rose-700',
        ];
        $statusClasse = $statusEstilos[$pedido->status] ?? 'bg-gray-100 text-gray-700';
    @endphp

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6 sm:p-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <p class="text-sm text-gray-500">Status</p>
                        <span class="inline-flex items-center mt-1 rounded-full px-3 py-1 text-sm font-semibold capitalize {{ $statusClasse }}">
                            {{ $pedido->status }}
                        </span>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Realizado em</p>
                        <p class="font-semibold text-gray-900">{{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <h3 class="font-display text-lg font-semibold text-gray-900 mb-3">Itens</h3>
                <div class="divide-y divide-gray-100 border border-gray-100 rounded-xl overflow-hidden mb-6">
                    @foreach ($pedido->itens as $item)
                        <div class="flex justify-between px-4 py-2.5 text-sm">
                            <span class="text-gray-700">{{ $item->quantidade }}x {{ $item->nome_produto }}</span>
                            <span class="font-medium text-gray-900">R$ {{ number_format($item->total, 2, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="space-y-1.5 text-sm text-gray-700">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span>R$ {{ number_format($pedido->subtotal, 2, ',', '.') }}</span>
                    </div>
                    @if ($pedido->desconto > 0)
                        <div class="flex justify-between text-emerald-600">
                            <span>Desconto</span>
                            <span>- R$ {{ number_format($pedido->desconto, 2, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <span>Frete</span>
                        <span>R$ {{ number_format($pedido->frete, 2, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between font-display font-semibold text-gray-900 text-base border-t border-gray-100 pt-3 mt-3">
                        <span>Total</span>
                        <span>R$ {{ number_format($pedido->total, 2, ',', '.') }}</span>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('produtos.index') }}" class="text-violet-600 hover:text-violet-800 font-medium text-sm">
                        &larr; Continuar comprando
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
