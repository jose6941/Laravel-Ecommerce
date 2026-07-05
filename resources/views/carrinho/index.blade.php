<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-semibold text-2xl text-gray-900">
            {{ __('Meu carrinho') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (! $carrinho || $carrinho->itens->isEmpty())
                <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-12 text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-violet-50 text-violet-500">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.836l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 1.994-4.694 2.608-7.164.075-.3-.155-.586-.464-.586H5.106M7.5 14.25 5.106 5.272M10.5 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm7.5 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                    </div>
                    <p class="mt-4 text-gray-700 font-medium">Seu carrinho está vazio.</p>
                    <a href="{{ route('produtos.index') }}" class="mt-4 inline-block">
                        <x-primary-button>Continuar comprando</x-primary-button>
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                    <div class="lg:col-span-2 bg-white border border-gray-100 shadow-sm rounded-2xl divide-y divide-gray-100">
                        @foreach ($carrinho->itens as $item)
                            <div class="p-5 flex items-center gap-4">
                                <div class="h-16 w-16 shrink-0 rounded-lg bg-gray-100 overflow-hidden">
                                    @if ($item->produto?->imagemPrincipal)
                                        <img src="{{ $item->produto->imagemPrincipal->url }}" alt="{{ $item->produto->nome }}" class="h-full w-full object-cover">
                                    @endif
                                </div>

                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-900 truncate">{{ $item->produto->nome }}</p>
                                    <p class="text-sm text-gray-500">R$ {{ number_format($item->preco_unitario, 2, ',', '.') }} cada</p>

                                    <form method="POST" action="{{ route('carrinho.update', $item) }}" class="mt-2 flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <x-text-input type="number" name="quantidade" min="1" value="{{ $item->quantidade }}" class="w-20 py-1 text-sm" />
                                        <button type="submit" class="text-sm font-medium text-violet-600 hover:text-violet-800">Atualizar</button>
                                        <span class="text-gray-300">&middot;</span>
                                    </form>
                                </div>

                                <div class="text-right shrink-0">
                                    <p class="font-semibold text-gray-900">
                                        R$ {{ number_format($item->preco_unitario * $item->quantidade, 2, ',', '.') }}
                                    </p>
                                    <form method="POST" action="{{ route('carrinho.destroy', $item) }}" class="mt-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-rose-500 hover:text-rose-700">Remover</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6 lg:sticky lg:top-24">
                        <h3 class="font-display font-semibold text-gray-900 mb-4">Resumo</h3>
                        <div class="flex items-center justify-between text-gray-600 text-sm mb-2">
                            <span>Subtotal</span>
                            <span>R$ {{ number_format($carrinho->itens->sum(fn ($i) => $i->preco_unitario * $i->quantidade), 2, ',', '.') }}</span>
                        </div>
                        <div class="border-t border-gray-100 mt-3 pt-3 flex items-center justify-between">
                            <span class="font-semibold text-gray-900">Total</span>
                            <span class="font-display font-semibold text-xl text-gray-900">
                                R$ {{ number_format($carrinho->itens->sum(fn ($i) => $i->preco_unitario * $i->quantidade), 2, ',', '.') }}
                            </span>
                        </div>

                        <div class="mt-6">
                            @auth
                                <a href="{{ route('checkout.index') }}" class="block">
                                    <x-primary-button class="w-full justify-center">Finalizar compra</x-primary-button>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="block">
                                    <x-primary-button class="w-full justify-center">Entrar para finalizar</x-primary-button>
                                </a>
                            @endauth
                            <a href="{{ route('produtos.index') }}" class="block text-center text-sm text-gray-500 hover:text-violet-600 mt-3">
                                Continuar comprando
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
