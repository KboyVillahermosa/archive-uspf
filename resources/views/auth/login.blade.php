<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
<div class="flex flex-vertical justify-center items-center min-h-full min-w-[50rem] w-[50rem] mx-auto border rounded-lg shadow-lg overflow-hidden md:flex-row">
    <div class="min-h-full w-full md:w-1/2 justify-center items-center px-6 py-4 bg-white overflow-hidden flex flex-vertical justify-center">
        <form method="POST" action="{{ route('login') }}" class="w-full md:w-4/5 mx-auto">
            @csrf
            <div>
                <img src="{{ asset('/images/logo.png') }}" alt="Logo" class="w-20 h-20 fill-current text-gray-500 mx-auto">
                <h1 class="text-center text-2xl font-bold text-gray-900  mb-2 mt-2">Welcome to USPF Research Archive</h1>
            </div>

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email Address')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            

            <!-- Remember Me -->
            <div class="block flex items-center justify-between mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#1677FF] shadow-sm focus:ring-[#1677FF]" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
                <x-primary-button class="ms-3 bg-[#1677FF] hover:bg-[#4096FF] text-white font-semibold py-2 px-6 rounded-md transition duration-200 ease-in-out">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
            
            <div class="flex items-center justify-center mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-[#1677FF] rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>
        </form>
    </div>
    <div class="w-full md:w-1/2 bg-[#1034A6]">
        <img src="{{ asset('/images/isometric.png') }}" alt="Login" class="w-full h-full object-cover">
    </div>
</div>
    
</x-guest-layout>
