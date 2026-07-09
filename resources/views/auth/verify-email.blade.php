<x-guest-layout :heading="'Verificar Email'" :subheading="'Confirme seu endereço de email para ativar sua conta'">
    <div class="mb-4 text-sm text-gray-500 leading-relaxed">
        Obrigado por se cadastrar! Antes de começar, verifique seu email clicando no link que enviamos. 
        Se não recebeu, enviaremos outro abaixo.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 p-3 bg-emerald-50 border border-emerald-100 rounded-xl text-sm font-medium text-emerald-700">
            Um novo link de verificação foi enviado para o email informado.
        </div>
    @endif

    <div class="flex flex-col gap-3 pt-1">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit"
                    class="w-full bg-[#1a1a1a] text-white rounded-full py-3 font-bold text-xs tracking-wider uppercase hover:bg-gray-800 active:bg-gray-900 transition-all duration-300 shadow-md hover:shadow-lg flex items-center justify-center gap-2 group">
                Reenviar Verificação
                <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full bg-white text-[#1a1a1a] border-2 border-gray-200 rounded-full py-3 font-bold text-xs tracking-wider uppercase hover:bg-gray-50 hover:border-gray-300 transition-all duration-300 shadow-sm flex items-center justify-center gap-2">
                Sair
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                </svg>
            </button>
        </form>
    </div>
</x-guest-layout>
