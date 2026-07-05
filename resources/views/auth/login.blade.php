<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-text-input id="email" class="block w-full rounded-2xl border-gray-200 bg-gray-50 py-3.5 px-4 text-sm font-medium focus:border-black focus:ring-black placeholder-gray-400" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Email Address" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
        </div>

        <!-- Password -->
        <div>
            <x-text-input id="password" class="block w-full rounded-2xl border-gray-200 bg-gray-50 py-3.5 px-4 text-sm font-medium focus:border-black focus:ring-black placeholder-gray-400"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="Password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
        </div>

        <div class="flex items-center justify-between mt-2">
            <!-- Remember Me -->
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-black shadow-sm focus:ring-black" name="remember">
                <span class="ms-2 text-xs font-medium text-gray-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-xs font-semibold text-gray-600 hover:text-black" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="pt-4">
            <button class="w-full bg-black text-white rounded-full py-4 font-semibold text-sm hover:bg-gray-800 transition shadow-lg shadow-gray-400/20">
                {{ __('Log in') }}
            </button>
        </div>

        <p class="text-center text-xs text-gray-500 font-medium mt-6">
            Don't have an account? <a href="{{ route('register') }}" class="text-black font-bold hover:underline">Register</a>
        </p>
    </form>
</x-guest-layout>
