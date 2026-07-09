<x-guest-layout :heading="'Recuperar Senha'" :subheading="'Enviaremos um link de redefinição para seu email'">
    <div class="mb-4 text-sm text-gray-500">
        Esqueceu sua senha? Informe seu email e enviaremos um link para redefini-la.
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-3" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-3">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-[10px] font-bold text-gray-500 tracking-[0.15em] uppercase mb-1.5">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   placeholder="seu@email.com"
                   class="block w-full border-2 border-gray-100 bg-white rounded-xl py-2.5 px-4 text-sm font-medium text-[#1a1a1a] placeholder-gray-400 focus:border-[#1a1a1a] focus:ring-0 focus:outline-none transition-all duration-300 shadow-sm hover:border-gray-200">
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div class="pt-1">
            <button type="submit"
                    class="w-full bg-[#1a1a1a] text-white rounded-full py-3 font-bold text-xs tracking-wider uppercase hover:bg-gray-800 active:bg-gray-900 transition-all duration-300 shadow-md hover:shadow-lg flex items-center justify-center gap-2 group">
                Enviar Link
                <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </div>
    </form>
</x-guest-layout>
