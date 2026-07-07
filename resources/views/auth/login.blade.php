<x-guest-layout :heading="'Acessar Conta'" :subheading="'Entre com seu email e senha'">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold text-gray-600 tracking-wider uppercase mb-1.5">Email</label>
            <x-text-input id="email" class="block w-full rounded-xl border-gray-200 bg-gray-50 py-3 px-4 text-sm font-medium focus:border-[#1a1a1a] focus:ring-[#1a1a1a] placeholder-gray-400" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="seu@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-bold text-gray-600 tracking-wider uppercase mb-1.5">Senha</label>
            <x-text-input id="password" class="block w-full rounded-xl border-gray-200 bg-gray-50 py-3 px-4 text-sm font-medium focus:border-[#1a1a1a] focus:ring-[#1a1a1a] placeholder-gray-400"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div class="flex items-center justify-between mt-1">
            <!-- Remember Me -->
            <label for="remember_me" class="inline-flex items-center gap-2">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#1a1a1a] shadow-sm focus:ring-[#1a1a1a]" name="remember">
                <span class="text-xs font-medium text-gray-500">Lembrar-me</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-xs font-semibold text-gray-500 hover:text-[#1a1a1a] transition" href="{{ route('password.request') }}">
                    Esqueceu a senha?
                </a>
            @endif
        </div>

        <div class="pt-2">
            <button class="w-full bg-[#1a1a1a] text-white rounded-full py-3.5 font-bold text-sm tracking-wider uppercase hover:bg-gray-800 transition-all duration-300 shadow-lg hover:shadow-xl">
                Entrar
            </button>
        </div>

        <p class="text-center text-xs text-gray-500 font-medium mt-4">
            Não tem conta? <a href="{{ route('register') }}" class="text-[#1a1a1a] font-bold hover:underline">Cadastre-se</a>
        </p>
    </form>
</x-guest-layout>
