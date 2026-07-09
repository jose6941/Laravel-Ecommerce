<section>
    <header class="mb-7">
        <h2 class="font-display font-bold text-lg text-[#1a1a1a]">Informações do Perfil</h2>
        <p class="text-sm text-gray-400 font-medium mt-1.5">
            Atualize suas informações pessoais e endereço de email.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <!-- Name -->
        <div>
            <x-input-label for="name" value="Nome completo" />
            <input id="name"
                   name="name"
                   type="text"
                   value="{{ old('name', $user->name) }}"
                   required autofocus autocomplete="name"
                   placeholder="Seu nome"
                   class="mt-2 block w-full border-2 border-gray-100 bg-white rounded-xl py-3 px-4 text-sm font-medium text-[#1a1a1a] placeholder-gray-300 focus:border-[#1a1a1a] focus:ring-0 focus:outline-none transition-all duration-300 shadow-sm hover:border-gray-200">
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" value="Email" />
            <input id="email"
                   name="email"
                   type="email"
                   value="{{ old('email', $user->email) }}"
                   required autocomplete="username"
                   placeholder="seu@email.com"
                   class="mt-2 block w-full border-2 border-gray-100 bg-white rounded-xl py-3 px-4 text-sm font-medium text-[#1a1a1a] placeholder-gray-300 focus:border-[#1a1a1a] focus:ring-0 focus:outline-none transition-all duration-300 shadow-sm hover:border-gray-200">
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4 p-4 bg-amber-50 border border-amber-100 rounded-xl">
                    <p class="text-sm text-amber-700">
                        Seu email ainda não foi verificado.

                        <button form="send-verification"
                                class="font-semibold text-amber-700 hover:text-amber-800 underline ml-1">
                            Reenviar verificação
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm font-medium text-emerald-600">
                            Um novo link de verificação foi enviado para seu email.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-4 pt-2">
            <button type="submit"
                    class="inline-flex items-center justify-center gap-2 bg-[#1a1a1a] text-white rounded-full px-8 py-3 font-bold text-sm tracking-wider uppercase hover:bg-gray-800 active:bg-gray-900 transition-all duration-300 shadow-lg hover:shadow-xl">
                Salvar
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }"
                   x-show="show"
                   x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm font-medium text-emerald-600 flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Salvo!
                </p>
            @endif
        </div>
    </form>
</section>
