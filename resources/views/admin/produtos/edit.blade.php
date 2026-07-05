<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-display font-semibold text-2xl text-gray-900">
                {{ __('Editar Produto') }}: {{ $produto->nome }}
            </h2>
            <a href="{{ route('admin.produtos.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">
                Voltar
            </a>
        </div>
    </x-slot>

    <div class="py-10 pb-24">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100 p-6">
                
                @if ($errors->any())
                    <div class="mb-4 text-rose-600 text-sm">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.produtos.update', $produto->slug) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="nome" value="Nome do Produto" />
                        <x-text-input id="nome" name="nome" type="text" class="mt-1 block w-full" :value="old('nome', $produto->nome)" required />
                    </div>

                    <div>
                        <x-input-label for="categoria_id" value="Categoria" />
                        <select name="categoria_id" id="categoria_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            @foreach($categorias as $cat)
                                <option value="{{ $cat->id }}" {{ (old('categoria_id', $produto->categoria_id) == $cat->id) ? 'selected' : '' }}>
                                    {{ $cat->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="descricao" value="Descrição" />
                        <textarea id="descricao" name="descricao" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('descricao', $produto->descricao) }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="preco" value="Preço Base (R$)" />
                            <x-text-input id="preco" name="preco" type="number" step="0.01" class="mt-1 block w-full" :value="old('preco', $produto->preco)" required />
                        </div>
                        <div>
                            <x-input-label for="preco_promocional" value="Preço Promocional (R$ - Opcional)" />
                            <x-text-input id="preco_promocional" name="preco_promocional" type="number" step="0.01" class="mt-1 block w-full" :value="old('preco_promocional', $produto->preco_promocional)" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="estoque" value="Estoque Atual" />
                        <x-text-input id="estoque" name="estoque" type="number" class="mt-1 block w-full" :value="old('estoque', $produto->estoque)" required />
                    </div>

                    <div class="flex items-center gap-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="ativo" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('ativo', $produto->ativo) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-600">Ativo (Visível na loja)</span>
                        </label>

                        <label class="flex items-center">
                            <input type="checkbox" name="destaque" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('destaque', $produto->destaque) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-600">Destaque</span>
                        </label>
                    </div>

                    <div>
                        <x-input-label for="imagem" value="Nova Imagem (Substitui a principal)" />
                        <input type="file" name="imagem" id="imagem" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept="image/*">
                        @if($produto->imagemPrincipal)
                            <div class="mt-2">
                                <p class="text-xs text-gray-500 mb-1">Imagem atual:</p>
                                <img src="{{ asset('storage/' . $produto->imagemPrincipal->caminho) }}" alt="Imagem" class="h-20 w-20 object-cover rounded-md border border-gray-200">
                            </div>
                        @endif
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-100">
                        <x-primary-button>
                            {{ __('Salvar Alterações') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
