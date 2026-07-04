<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pedido') }} #{{ $pedido->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <p class="text-sm text-gray-500">Status</p>
                        <p class="font-semibold text-gray-900 capitalize">{{ $pedido->status }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Realizado em</p>
                        <p class="font-semibold text-gray-900">{{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <h3 class="text-lg font-semibold text-gray-900 mb-3">Itens</h3>
                <div class="divide-y border rounded-md mb-6">
                    @foreach ($pedido->itens as $item)
                        <div class="flex justify-between px-4 py-2 text-sm">
                            <span>{{ $item->quantidade }}x {{ $item->nome_produto }}</span>
                            <span>R$ {{ number_format($item->total, 2, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="space-y-1 text-sm text-gray-700">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span>R$ {{ number_format($pedido->subtotal, 2, ',', '.') }}</span>
                    </div>
                    @if ($pedido->desconto > 0)
                        <div class="flex justify-between text-green-600">
                            <span>Desconto</span>
                            <span>- R$ {{ number_format($pedido->desconto, 2, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <span>Frete</span>
                        <span>R$ {{ number_format($pedido->frete, 2, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between font-bold text-gray-900 text-base border-t pt-2 mt-2">
                        <span>Total</span>
                        <span>R$ {{ number_format($pedido->total, 2, ',', '.') }}</span>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('produtos.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                        &larr; Continuar comprando
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
