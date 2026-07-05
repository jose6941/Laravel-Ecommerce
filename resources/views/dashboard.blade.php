<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-semibold text-2xl text-gray-900">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-8">
                <p class="text-gray-700">
                    {{ __('Olá, :nome! Você está autenticado.', ['nome' => Auth::user()->name]) }}
                </p>
                <div class="mt-4 flex flex-wrap gap-3">
                    <a href="{{ route('produtos.index') }}">
                        <x-secondary-button>Ver produtos</x-secondary-button>
                    </a>
                    <a href="{{ route('carrinho.index') }}">
                        <x-secondary-button>Meu carrinho</x-secondary-button>
                    </a>
                    <a href="{{ route('profile.edit') }}">
                        <x-secondary-button>Meu perfil</x-secondary-button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
