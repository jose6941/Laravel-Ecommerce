<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Finalizar compra') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if ($enderecos->isEmpty())
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Cadastrar endereço de entrega</h3>
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

            <form method="POST" action="{{ route('checkout.store') }}" class="bg-white shadow-sm rounded-lg p-6 space-y-6">
                @csrf

                {{-- Resumo do pedido --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Resumo do pedido</h3>
                    <div class="divide-y border rounded-md">
                        @foreach ($carrinho->itens as $item)
                            <div class="flex justify-between px-4 py-2 text-sm">
                                <span>{{ $item->quantidade }}x {{ $item->produto->nome }}</span>
                                <span>R$ {{ number_format($item->preco_unitario * $item->quantidade, 2, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex justify-between mt-2 font-semibold text-gray-900">
                        <span>Total</span>
                        <span>R$ {{ number_format($carrinho->itens->sum(fn ($i) => $i->preco_unitario * $i->quantidade), 2, ',', '.') }}</span>
                    </div>
                </div>

                {{-- Endereço --}}
                <div>
                    <x-input-label for="endereco_id" value="Endereço de entrega" />

                    @if ($enderecos->isEmpty())
                        <p class="text-sm text-gray-500 mt-2 mb-4">
                            Você ainda não tem um endereço cadastrado. Cadastre um abaixo para continuar.
                        </p>
                    @else
                        <select id="endereco_id" name="endereco_id" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
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
                    <x-input-label for="metodo_pagamento" value="Método de pagamento" />
                    <select id="metodo_pagamento" name="metodo_pagamento" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="pix">Pix</option>
                        <option value="cartao">Cartão de crédito</option>
                        <option value="boleto">Boleto</option>
                    </select>
                    <x-input-error :messages="$errors->get('metodo_pagamento')" class="mt-2" />
                </div>

                {{-- Cupom --}}
                <div>
                    <x-input-label for="codigo_cupom" value="Cupom de desconto (opcional)" />
                    <x-text-input id="codigo_cupom" name="codigo_cupom" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('codigo_cupom')" class="mt-2" />
                </div>

                <x-primary-button :disabled="$enderecos->isEmpty()">
                    Confirmar pedido
                </x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>
