<x-guest-layout :heading="'Criar Conta'" :subheading="'Preencha os dados para se cadastrar'">
    <form method="POST" action="{{ route('register') }}" class="space-y-3">
        @csrf

        <!-- Name -->
        <div>
            <label for="nome" class="block text-[10px] font-bold text-gray-500 tracking-[0.15em] uppercase mb-1.5">Nome completo</label>
            <input id="nome"
                   type="text"
                   name="nome"
                   value="{{ old('nome') }}"
                   required autofocus autocomplete="name"
                   placeholder="Seu nome"
                   class="block w-full border-2 border-gray-100 bg-white rounded-xl py-2.5 px-4 text-sm font-medium text-[#1a1a1a] placeholder-gray-400 focus:border-[#1a1a1a] focus:ring-0 focus:outline-none transition-all duration-300 shadow-sm hover:border-gray-200">
            <x-input-error :messages="$errors->get('nome')" class="mt-1.5" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-[10px] font-bold text-gray-500 tracking-[0.15em] uppercase mb-1.5">Email</label>
            <input id="email"
                   type="email"
                   name="email"
                   value="{{ old('email') }}"
                   required autocomplete="username"
                   placeholder="seu@email.com"
                   class="block w-full border-2 border-gray-100 bg-white rounded-xl py-2.5 px-4 text-sm font-medium text-[#1a1a1a] placeholder-gray-400 focus:border-[#1a1a1a] focus:ring-0 focus:outline-none transition-all duration-300 shadow-sm hover:border-gray-200">
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <!-- Telefone -->
        <div>
            <label for="telefone" class="block text-[10px] font-bold text-gray-500 tracking-[0.15em] uppercase mb-1.5">Telefone</label>
            <input id="telefone"
                   type="text"
                   name="telefone"
                   value="{{ old('telefone') }}"
                   required
                   placeholder="(11) 99999-9999"
                   class="block w-full border-2 border-gray-100 bg-white rounded-xl py-2.5 px-4 text-sm font-medium text-[#1a1a1a] placeholder-gray-400 focus:border-[#1a1a1a] focus:ring-0 focus:outline-none transition-all duration-300 shadow-sm hover:border-gray-200">
            <x-input-error :messages="$errors->get('telefone')" class="mt-1.5" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-[10px] font-bold text-gray-500 tracking-[0.15em] uppercase mb-1.5">Senha</label>
            <input id="password"
                   type="password"
                   name="password"
                   required autocomplete="new-password"
                   placeholder="Mínimo 8 caracteres"
                   class="block w-full border-2 border-gray-100 bg-white rounded-xl py-2.5 px-4 text-sm font-medium text-[#1a1a1a] placeholder-gray-400 focus:border-[#1a1a1a] focus:ring-0 focus:outline-none transition-all duration-300 shadow-sm hover:border-gray-200">
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-[10px] font-bold text-gray-500 tracking-[0.15em] uppercase mb-1.5">Confirmar senha</label>
            <input id="password_confirmation"
                   type="password"
                   name="password_confirmation"
                   required autocomplete="new-password"
                   placeholder="Repita a senha"
                   class="block w-full border-2 border-gray-100 bg-white rounded-xl py-2.5 px-4 text-sm font-medium text-[#1a1a1a] placeholder-gray-400 focus:border-[#1a1a1a] focus:ring-0 focus:outline-none transition-all duration-300 shadow-sm hover:border-gray-200">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
        </div>

        <!-- Submit -->
        <div class="pt-1">
            <button type="submit"
                    class="w-full bg-[#1a1a1a] text-white rounded-full py-3 font-bold text-xs tracking-wider uppercase hover:bg-gray-800 active:bg-gray-900 transition-all duration-300 shadow-md hover:shadow-lg flex items-center justify-center gap-2 group">
                Criar Conta
                <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </div>

        <!-- Login link -->
        <p class="text-center text-[11px] text-gray-500 font-medium pt-2.5 border-t border-gray-50">
            Já tem conta?
            <a href="{{ route('login') }}" class="text-[#1a1a1a] font-bold hover:underline ml-1">Fazer login</a>
        </p>
    </form>
</x-guest-layout>
