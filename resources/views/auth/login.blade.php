<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="flex flex-col md:flex-row justify-center items-center min-h-full w-[50rem] max-w-[50rem] mx-auto border rounded-lg shadow-lg overflow-hidden">
        
        <!-- Left Panel (Form) -->
        <div class="flex flex-col justify-center items-center h-auto md:h-[27rem] w-full md:w-1/2 px-6 py-8 bg-white">
            <form method="POST" action="{{ route('login') }}" class="w-full max-w-md mx-auto">
                @csrf

                <!-- Logo & Title -->
                <div class="text-center mb-6">
                    <img src="{{ asset('/images/logo.png') }}" alt="Logo" class="w-20 h-20 mx-auto">
                    <h1 class="text-xl md:text-2xl font-bold text-gray-900 mt-2">Welcome to USPF Research Archive</h1>
                </div>

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email Address')" />
                    <x-text-input 
                        id="email" 
                        type="email" 
                        name="email" 
                        :value="old('email')" 
                        required 
                        autofocus 
                        autocomplete="username"
                        class="block mt-1 w-full"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input 
                        id="password" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="current-password"
                        class="block mt-1 w-full"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me & Login Button -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 mt-6">
                    <label for="remember_me" class="inline-flex items-center">
                        <input 
                            id="remember_me" 
                            type="checkbox" 
                            name="remember" 
                            class="rounded border-gray-300 text-[#1677FF] shadow-sm focus:ring-[#1677FF]"
                        >
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>

                    <x-primary-button class="bg-[#1677FF] hover:bg-[#4096FF] text-white font-semibold py-2 px-6 rounded-md transition duration-200 ease-in-out w-full sm:w-auto text-center flex justify-center items-center">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>

                <!-- Forgot Password -->
                @if (Route::has('password.request'))
                    <div class="text-center mt-4">
                        <a href="{{ route('password.request') }}" 
                           class="underline text-sm text-gray-600 hover:text-[#1677FF] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Forgot your password?') }}
                        </a>
                    </div>
                @endif
            </form>
        </div>
        
        <!-- Right Panel (Image) -->
        <div class="hidden md:flex items-center justify-center w-full md:w-1/2 h-[27rem]" 
             style="background: linear-gradient(0deg, rgba(0,132,255,1) 0%, rgba(0,238,255,1) 100%)">
            <img src="{{ asset('/images/isometric.png') }}" alt="Login Illustration" class="w-full h-full object-contain">
        </div>
    </div>
</x-guest-layout>
