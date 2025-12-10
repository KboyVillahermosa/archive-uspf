<x-guest-layout>
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        .min-h-screen {
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
    </style>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="h-screen w-screen flex overflow-hidden m-0 p-0 fixed inset-0">
        <!-- Left Panel (Promotional) -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-[#26225C] via-[#3a3770] to-[#4a4a8a] relative overflow-hidden">
            <!-- Background Pattern with Curved Lines -->
            <div class="absolute inset-0">
                <!-- Curved line from top right -->
                <svg class="absolute top-0 right-0 w-96 h-96 opacity-20" viewBox="0 0 200 200" fill="none">
                    <path d="M200 0 Q150 50 100 100 T0 200" stroke="#FFC72C" stroke-width="2" fill="none"/>
                </svg>
                <!-- Curved line from bottom left -->
                <svg class="absolute bottom-0 left-0 w-96 h-96 opacity-20" viewBox="0 0 200 200" fill="none">
                    <path d="M0 200 Q50 150 100 100 T200 0" stroke="#FFC72C" stroke-width="2" fill="none"/>
                </svg>
            </div>
            
            <!-- Content -->
            <div class="relative z-10 flex flex-col justify-between p-16 text-white">
                <div>
                    <!-- Logo -->
                    <div class="mb-12">
                        <img src="{{ asset('images/logo.png') }}" alt="USPF Logo" class="h-16 w-auto" />
                    </div>
                    
                    <!-- Greeting -->
                    <h1 class="text-5xl font-bold mb-4">Hello USPF! 👋</h1>
                    
                    <!-- Tagline -->
                    <p class="text-xl opacity-90 leading-relaxed max-w-md">
                        Discover, access, and share research papers, theses, and dissertations. Build your academic portfolio and collaborate with researchers worldwide.
                    </p>
                </div>
                
                <!-- Copyright -->
                <div class="text-sm opacity-75">
                    © {{ date('Y') }} USPF Research Archive. All rights reserved.
                </div>
            </div>
        </div>
        
        <!-- Right Panel (Login Form) -->
        <div class="flex-1 flex flex-col justify-center p-16 bg-white overflow-y-auto">
            <div class="w-full max-w-md">
                <!-- Brand Name -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-[#26225C] mb-1">USPF Research Archive</h2>
                </div>
                
                <!-- Welcome Message -->
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome Back!</h1>
                
                <!-- Register Prompt -->
                @if (Route::has('register'))
                <p class="text-gray-600 mb-8">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="text-[#26225C] font-semibold underline hover:text-[#3a3770] transition-colors">
                        Create a new account now
                    </a>
                    , it's FREE! Takes less than a minute.
                </p>
                @endif
                
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-text-input 
                            id="email" 
                            type="email" 
                            name="email" 
                            :value="old('email')" 
                            required 
                            autofocus 
                            autocomplete="username"
                            class="block w-full px-0 py-3 border-0 border-b-2 border-gray-300 focus:border-[#26225C] focus:ring-0 bg-transparent rounded-none transition-colors duration-200 placeholder-gray-400"
                            placeholder="Email Address"
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-text-input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required 
                            autocomplete="current-password"
                            class="block w-full px-0 py-3 border-0 border-b-2 border-gray-300 focus:border-[#26225C] focus:ring-0 bg-transparent rounded-none transition-colors duration-200 placeholder-gray-400"
                            placeholder="Password"
                        />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Login Button -->
                    <div>
                        <x-primary-button class="w-full bg-[#26225C] hover:bg-[#1a1840] text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200">
                            {{ __('Login Now') }}
                        </x-primary-button>
                    </div>

                    <!-- Forgot Password -->
                    @if (Route::has('password.request'))
                    <div class="text-center">
                        <p class="text-sm text-gray-600">
                            Forget password 
                            <a href="{{ route('password.request') }}" class="text-[#26225C] font-semibold underline hover:text-[#3a3770] transition-colors">
                                Click here
                            </a>
                        </p>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
