<section>
    <header class="mb-7">
        <h2 class="font-display font-bold text-lg text-[#1a1a1a]">Alterar Senha</h2>
        <p class="text-sm text-gray-400 font-medium mt-1.5">
            Mantenha sua conta segura com uma senha forte e única.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div>
            <x-input-label for="update_password_current_password" value="Senha atual" />
            <input id="update_password_current_password"
                   name="current_password"
                   type="password"
                   required autocomplete="current-password"
                   placeholder="••••••••"
                   class="mt-2 block w-full border-2 border-gray-100 bg-white rounded-xl py-3 px-4 text-sm font-medium text-[#1a1a1a] placeholder-gray-300 focus:border-[#1a1a1a] focus:ring-0 focus:outline-none transition-all duration-300 shadow-sm hover:border-gray-200">
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <!-- New Password -->
        <div>
            <x-input-label for="update_password_password" value="Nova senha" />
            <input id="update_password_password"
                   name="password"
                   type="password"
                   required autocomplete="new-password"
                   placeholder="Mínimo 8 caracteres"
                   class="mt-2 block w-full border-2 border-gray-100 bg-white rounded-xl py-3 px-4 text-sm font-medium text-[#1a1a1a] placeholder-gray-300 focus:border-[#1a1a1a] focus:ring-0 focus:outline-none transition-all duration-300 shadow-sm hover:border-gray-200">
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="update_password_password_confirmation" value="Confirmar nova senha" />
            <input id="update_password_password_confirmation"
                   name="password_confirmation"
                   type="password"
                   required autocomplete="new-password"
                   placeholder="Repita a senha"
                   class="mt-2 block w-full border-2 border-gray-100 bg-white rounded-xl py-3 px-4 text-sm font-medium text-[#1a1a1a] placeholder-gray-300 focus:border-[#1a1a1a] focus:ring-0 focus:outline-none transition-all duration-300 shadow-sm hover:border-gray-200">
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
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

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }"
                   x-show="show"
                   x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm font-medium text-emerald-600 flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Senha atualizada!
                </p>
            @endif
        </div>
    </form>
</section>
