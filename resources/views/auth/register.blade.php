<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <x-text-input id="nome" class="block w-full rounded-2xl border-gray-200 bg-gray-50 py-3.5 px-4 text-sm font-medium focus:border-black focus:ring-black placeholder-gray-400" type="text" name="nome" :value="old('nome')" required autofocus autocomplete="name" placeholder="Full Name" />
            <x-input-error :messages="$errors->get('nome')" class="mt-2 text-red-500" />
        </div>

        <!-- Email Address -->
        <div>
            <x-text-input id="email" class="block w-full rounded-2xl border-gray-200 bg-gray-50 py-3.5 px-4 text-sm font-medium focus:border-black focus:ring-black placeholder-gray-400" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Email Address" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
        </div>
        
        <!-- Telefone -->
        <div>
            <x-text-input id="telefone" class="block w-full rounded-2xl border-gray-200 bg-gray-50 py-3.5 px-4 text-sm font-medium focus:border-black focus:ring-black placeholder-gray-400" type="text" name="telefone" :value="old('telefone')" required placeholder="Phone Number" />
            <x-input-error :messages="$errors->get('telefone')" class="mt-2 text-red-500" />
        </div>

        <!-- Password -->
        <div>
            <x-text-input id="password" class="block w-full rounded-2xl border-gray-200 bg-gray-50 py-3.5 px-4 text-sm font-medium focus:border-black focus:ring-black placeholder-gray-400"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="Password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-text-input id="password_confirmation" class="block w-full rounded-2xl border-gray-200 bg-gray-50 py-3.5 px-4 text-sm font-medium focus:border-black focus:ring-black placeholder-gray-400"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500" />
        </div>

        <div class="pt-4">
            <button class="w-full bg-black text-white rounded-full py-4 font-semibold text-sm hover:bg-gray-800 transition shadow-lg shadow-gray-400/20">
                {{ __('Register') }}
            </button>
        </div>
        
        <p class="text-center text-xs text-gray-500 font-medium mt-6">
            Already have an account? <a href="{{ route('login') }}" class="text-black font-bold hover:underline">Log in</a>
        </p>
    </form>
</x-guest-layout>
