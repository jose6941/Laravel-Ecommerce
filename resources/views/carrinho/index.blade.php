<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meu carrinho') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                @if (! $carrinho || $carrinho->itens->isEmpty())
                    <p class="text-gray-500">Seu carrinho está vazio.</p>
                    <a href="{{ route('produtos.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium mt-4 inline-block">
                        Continuar comprando &rarr;
                    </a>
                @else
                    <div class="divide-y">
                        @foreach ($carrinho->itens as $item)
                            <div class="py-4 flex items-center justify-between gap-4">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900">{{ $item->produto->nome }}</p>
                                    <p class="text-sm text-gray-500">R$ {{ number_format($item->preco_unitario, 2, ',', '.') }} cada</p>
                                </div>

                                <form method="POST" action="{{ route('carrinho.update', $item) }}" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <x-text-input type="number" name="quantidade" min="1" value="{{ $item->quantidade }}" class="w-20" />
                                    <x-secondary-button type="submit">Atualizar</x-secondary-button>
                                </form>

                                <p class="w-28 text-right font-semibold text-gray-900">
                                    R$ {{ number_format($item->preco_unitario * $item->quantidade, 2, ',', '.') }}
                                </p>

                                <form method="POST" action="{{ route('carrinho.destroy', $item) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm">Remover</button>
                                </form>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t mt-4 pt-4 flex items-center justify-between">
                        <span class="text-lg font-semibold text-gray-900">Total</span>
                        <span class="text-lg font-bold text-indigo-600">
                            R$ {{ number_format($carrinho->itens->sum(fn ($i) => $i->preco_unitario * $i->quantidade), 2, ',', '.') }}
                        </span>
                    </div>

                    <div class="mt-6 text-right">
                        @auth
                            <a href="{{ route('checkout.index') }}">
                                <x-primary-button>Finalizar compra</x-primary-button>
                            </a>
                        @else
                            <a href="{{ route('login') }}">
                                <x-primary-button>Entrar para finalizar a compra</x-primary-button>
                            </a>
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
