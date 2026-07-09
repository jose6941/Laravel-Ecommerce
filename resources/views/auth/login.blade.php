<x-guest-layout :heading="'Acessar Conta'" :subheading="'Entre com seu email e senha'">
    <!-- Session Status -->
    <x-auth-session-status class="mb-3" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-3">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-[10px] font-bold text-gray-500 tracking-[0.15em] uppercase mb-1.5">Email</label>
            <input id="email"
                   type="email"
                   name="email"
                   value="{{ old('email') }}"
                   required autofocus autocomplete="username"
                   placeholder="seu@email.com"
                   class="block w-full border-2 border-gray-100 bg-white rounded-xl py-2.5 px-4 text-sm font-medium text-[#1a1a1a] placeholder-gray-400 focus:border-[#1a1a1a] focus:ring-0 focus:outline-none transition-all duration-300 shadow-sm hover:border-gray-200">
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-[10px] font-bold text-gray-500 tracking-[0.15em] uppercase mb-1.5">Senha</label>
            <input id="password"
                   type="password"
                   name="password"
                   required autocomplete="current-password"
                   placeholder="••••••••"
                   class="block w-full border-2 border-gray-100 bg-white rounded-xl py-2.5 px-4 text-sm font-medium text-[#1a1a1a] placeholder-gray-400 focus:border-[#1a1a1a] focus:ring-0 focus:outline-none transition-all duration-300 shadow-sm hover:border-gray-200">
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <!-- Remember & Forgot -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer group">
                <input id="remember_me" type="checkbox" name="remember"
                       class="rounded border-gray-300 text-[#1a1a1a] shadow-sm focus:ring-[#1a1a1a] focus:ring-offset-0 cursor-pointer">
                <span class="text-[11px] font-medium text-gray-500 group-hover:text-gray-700 transition-colors">Lembrar-me</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-[11px] font-semibold text-gray-500 hover:text-[#1a1a1a] transition-colors" href="{{ route('password.request') }}">
                    Esqueceu a senha?
                </a>
            @endif
        </div>

        <!-- Submit -->
        <div class="pt-1">
            <button type="submit"
                    class="w-full bg-[#1a1a1a] text-white rounded-full py-3 font-bold text-xs tracking-wider uppercase hover:bg-gray-800 active:bg-gray-900 transition-all duration-300 shadow-md hover:shadow-lg flex items-center justify-center gap-2 group">
                Entrar
                <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </div>

        <!-- Register link -->
        <p class="text-center text-[11px] text-gray-500 font-medium pt-2.5 border-t border-gray-50">
            Não tem conta?
            <a href="{{ route('register') }}" class="text-[#1a1a1a] font-bold hover:underline ml-1">Cadastre-se</a>
        </p>
    </form>
</x-guest-layout>
