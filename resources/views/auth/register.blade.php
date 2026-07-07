<x-guest-layout :heading="'Criar Conta'" :subheading="'Preencha os dados para se cadastrar'">
    <form method="POST" action="{{ route('register') }}" class="space-y-3.5">
        @csrf

        <!-- Name -->
        <div>
            <label for="nome" class="block text-xs font-bold text-gray-600 tracking-wider uppercase mb-1.5">Nome completo</label>
            <x-text-input id="nome" class="block w-full rounded-xl border-gray-200 bg-gray-50 py-3 px-4 text-sm font-medium focus:border-[#1a1a1a] focus:ring-[#1a1a1a] placeholder-gray-400" type="text" name="nome" :value="old('nome')" required autofocus autocomplete="name" placeholder="Seu nome" />
            <x-input-error :messages="$errors->get('nome')" class="mt-1.5" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold text-gray-600 tracking-wider uppercase mb-1.5">Email</label>
            <x-text-input id="email" class="block w-full rounded-xl border-gray-200 bg-gray-50 py-3 px-4 text-sm font-medium focus:border-[#1a1a1a] focus:ring-[#1a1a1a] placeholder-gray-400" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="seu@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>
        
        <!-- Telefone -->
        <div>
            <label for="telefone" class="block text-xs font-bold text-gray-600 tracking-wider uppercase mb-1.5">Telefone</label>
            <x-text-input id="telefone" class="block w-full rounded-xl border-gray-200 bg-gray-50 py-3 px-4 text-sm font-medium focus:border-[#1a1a1a] focus:ring-[#1a1a1a] placeholder-gray-400" type="text" name="telefone" :value="old('telefone')" required placeholder="(11) 99999-9999" />
            <x-input-error :messages="$errors->get('telefone')" class="mt-1.5" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-bold text-gray-600 tracking-wider uppercase mb-1.5">Senha</label>
            <x-text-input id="password" class="block w-full rounded-xl border-gray-200 bg-gray-50 py-3 px-4 text-sm font-medium focus:border-[#1a1a1a] focus:ring-[#1a1a1a] placeholder-gray-400"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="Mínimo 8 caracteres" />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-xs font-bold text-gray-600 tracking-wider uppercase mb-1.5">Confirmar senha</label>
            <x-text-input id="password_confirmation" class="block w-full rounded-xl border-gray-200 bg-gray-50 py-3 px-4 text-sm font-medium focus:border-[#1a1a1a] focus:ring-[#1a1a1a] placeholder-gray-400"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="Repita a senha" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
        </div>

        <div class="pt-2">
            <button class="w-full bg-[#1a1a1a] text-white rounded-full py-3.5 font-bold text-sm tracking-wider uppercase hover:bg-gray-800 transition-all duration-300 shadow-lg hover:shadow-xl">
                Criar Conta
            </button>
        </div>
        
        <p class="text-center text-xs text-gray-500 font-medium mt-4">
            Já tem conta? <a href="{{ route('login') }}" class="text-[#1a1a1a] font-bold hover:underline">Fazer login</a>
        </p>
    </form>
</x-guest-layout>
