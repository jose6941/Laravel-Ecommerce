<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-semibold text-2xl text-gray-900">
            {{ __('Finalizar compra') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if ($enderecos->isEmpty())
                <div class="bg-white border border-gray-200 shadow-sm rounded-2xl p-6">
                    <h3 class="font-display font-semibold text-gray-900 mb-4">
                        <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-violet-600 text-white text-xs mr-2">1</span>
                        Cadastrar endereço de entrega
                    </h3>
                    <form method="POST" action="{{ route('enderecos.store') }}" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @csrf
                        <div class="sm:col-span-2">
                            <x-input-label for="rotulo" value="Rótulo (opcional)" />
                            <x-text-input id="rotulo" name="rotulo" class="mt-1 block w-full" placeholder="Ex: Casa, Trabalho" />
                        </div>
                        <div>
                            <x-input-label for="cep" value="CEP" />
                            <x-text-input id="cep" name="cep" required class="mt-1 block w-full" />
                        </div>
                        <div>
                            <x-input-label for="estado" value="Estado (UF)" />
                            <x-text-input id="estado" name="estado" required maxlength="2" class="mt-1 block w-full" />
                        </div>
                        <div class="sm:col-span-2">
                            <x-input-label for="rua" value="Rua" />
                            <x-text-input id="rua" name="rua" required class="mt-1 block w-full" />
                        </div>
                        <div>
                            <x-input-label for="numero" value="Número" />
                            <x-text-input id="numero" name="numero" required class="mt-1 block w-full" />
                        </div>
                        <div>
                            <x-input-label for="complemento" value="Complemento (opcional)" />
                            <x-text-input id="complemento" name="complemento" class="mt-1 block w-full" />
                        </div>
                        <div>
                            <x-input-label for="bairro" value="Bairro" />
                            <x-text-input id="bairro" name="bairro" required class="mt-1 block w-full" />
                        </div>
                        <div>
                            <x-input-label for="cidade" value="Cidade" />
                            <x-text-input id="cidade" name="cidade" required class="mt-1 block w-full" />
                        </div>
                        <div class="sm:col-span-2">
                            <x-primary-button>Salvar endereço</x-primary-button>
                        </div>
                    </form>
                </div>
            @endif

            <form method="POST" action="{{ route('checkout.store') }}" class="bg-white border border-gray-200 shadow-sm rounded-2xl p-6 space-y-8">
                @csrf

                {{-- Resumo do pedido --}}
                <div>
                    <h3 class="font-display font-semibold text-gray-900 mb-3">
                        <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-violet-600 text-white text-xs mr-2">2</span>
                        Resumo do pedido
                    </h3>
                    <div class="divide-y divide-gray-100 border border-gray-100 rounded-xl overflow-hidden">
                        @foreach ($carrinho->itens as $item)
                            <div class="flex justify-between px-4 py-2.5 text-sm">
                                <span class="text-gray-700">{{ $item->quantidade }}x {{ $item->produto->nome }}</span>
                                <span class="font-medium text-gray-900">R$ {{ number_format($item->preco_unitario * $item->quantidade, 2, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex justify-between mt-3 font-semibold text-gray-900">
                        <span>Total</span>
                        <span>R$ {{ number_format($carrinho->itens->sum(fn ($i) => $i->preco_unitario * $i->quantidade), 2, ',', '.') }}</span>
                    </div>
                </div>

                {{-- Endereço --}}
                <div>
                    <h3 class="font-display font-semibold text-gray-900 mb-3">
                        <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-violet-600 text-white text-xs mr-2">3</span>
                        Endereço de entrega
                    </h3>

                    @if ($enderecos->isEmpty())
                        <p class="text-sm text-gray-500">
                            Você ainda não tem um endereço cadastrado. Cadastre um acima para continuar.
                        </p>
                    @else
                        <select id="endereco_id" name="endereco_id" required
                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-violet-500 focus:border-violet-500">
                            @foreach ($enderecos as $endereco)
                                <option value="{{ $endereco->id }}">
                                    {{ $endereco->rua }}, {{ $endereco->numero }} - {{ $endereco->bairro }}, {{ $endereco->cidade }}/{{ $endereco->estado }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                    <x-input-error :messages="$errors->get('endereco_id')" class="mt-2" />
                </div>

                {{-- Pagamento --}}
                <div>
                    <h3 class="font-display font-semibold text-gray-900 mb-3">
                        <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-violet-600 text-white text-xs mr-2">4</span>
                        Pagamento
                    </h3>
                    <select id="metodo_pagamento" name="metodo_pagamento" required
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-violet-500 focus:border-violet-500">
                        <option value="pix">Pix</option>
                        <option value="cartao">Cartão de crédito</option>
                        <option value="boleto">Boleto</option>
                    </select>
                    <x-input-error :messages="$errors->get('metodo_pagamento')" class="mt-2" />
                </div>

                {{-- Cupom --}}
                <div>
                    <x-input-label for="codigo_cupom" value="Cupom de desconto (opcional)" />
                    <x-text-input id="codigo_cupom" name="codigo_cupom" class="mt-1 block w-full" placeholder="Ex: BEMVINDO10" />
                    <x-input-error :messages="$errors->get('codigo_cupom')" class="mt-2" />
                </div>

                <x-primary-button class="w-full justify-center py-3" :disabled="$enderecos->isEmpty()">
                    Confirmar pedido
                </x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>
