<section class="space-y-6">
    <header class="mb-7">
        <h2 class="font-display font-bold text-lg text-rose-600">Excluir Conta</h2>
        <p class="text-sm text-gray-400 font-medium mt-1.5">
            Após excluir, todos os dados serão permanentemente removidos. Esta ação não pode ser desfeita.
        </p>
    </header>

    <button type="button"
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="inline-flex items-center justify-center gap-2 bg-white text-rose-600 border-2 border-rose-200 rounded-full px-8 py-3 font-bold text-sm hover:bg-rose-600 hover:text-white hover:border-rose-600 transition-all duration-300 shadow-sm hover:shadow-lg">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.158-3.21c-1.33-.21-2.67-.39-4.01-.54m-4.01.54c-1.34.15-2.68.33-4.01.54m0 0C7.13 5.37 6.5 5.56 5.88 5.77m10.15-1.5a2.25 2.25 0 00-4.05 0" />
        </svg>
        Excluir Conta
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <div class="flex items-center justify-center w-14 h-14 rounded-2xl bg-rose-50 text-rose-600 mb-5 mx-auto">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                </svg>
            </div>

            <h2 class="text-lg font-bold text-[#1a1a1a] text-center mb-2">
                Excluir conta?
            </h2>
            <p class="text-sm text-gray-500 text-center mb-6 leading-relaxed">
                Digite sua senha para confirmar que deseja excluir permanentemente sua conta e todos os dados associados.
            </p>

            <div>
                <input id="password"
                       name="password"
                       type="password"
                       required
                       placeholder="Sua senha"
                       class="block w-full border-2 border-gray-100 bg-white rounded-xl py-3 px-4 text-sm font-medium text-[#1a1a1a] placeholder-gray-300 focus:border-rose-400 focus:ring-0 focus:outline-none transition-all duration-300 shadow-sm hover:border-gray-200">
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-8 flex items-center justify-center gap-3">
                <button type="button"
                        x-on:click="$dispatch('close')"
                        class="inline-flex items-center justify-center px-6 py-3 bg-white border-2 border-gray-200 rounded-full font-semibold text-sm text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition-all duration-200">
                    Cancelar
                </button>
                <button type="submit"
                        class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-rose-600 border-2 border-rose-600 rounded-full font-bold text-sm text-white hover:bg-rose-700 transition-all duration-200 shadow-md">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.158-3.21c-1.33-.21-2.67-.39-4.01-.54m-4.01.54c-1.34.15-2.68.33-4.01.54m0 0C7.13 5.37 6.5 5.56 5.88 5.77m10.15-1.5a2.25 2.25 0 00-4.05 0" />
                    </svg>
                    Excluir
                </button>
            </div>
        </form>
    </x-modal>
</section>
