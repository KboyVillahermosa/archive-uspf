<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100 flex items-center justify-center py-8 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            <!-- Card Container -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                
                <!-- Header Section -->
                <div class="bg-gradient-to-r from-[#26225C] to-[#3a3770] px-8 pt-8 pb-12">
                    <!-- Logo Icon -->
                    <div class="flex justify-center mb-6">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-2xl backdrop-blur-sm">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Title & Subtitle -->
                    <h1 class="text-2xl font-bold text-white text-center mb-2">Welcome Back</h1>
                    <p class="text-white/80 text-center text-sm">Sign in to access USPF Research Archive</p>
                </div>

                <!-- Form Section -->
                <div class="px-8 py-8">
                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" :value="__('Email Address')" class="text-sm font-semibold text-gray-700 mb-2 block" />
                            <x-text-input 
                                id="email" 
                                type="email" 
                                name="email" 
                                :value="old('email')" 
                                required 
                                autofocus 
                                autocomplete="username"
                                class="block w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#26225C] focus:border-transparent transition-all duration-200 text-sm placeholder-gray-500"
                                placeholder="fvillahermosa_ccs@uspf.edu.ph"
                            />
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm" />
                        </div>

                        <!-- Password -->
                        <div>
                            <x-input-label for="password" :value="__('Password')" class="text-sm font-semibold text-gray-700 mb-2 block" />
                            <x-text-input 
                                id="password" 
                                type="password" 
                                name="password" 
                                required 
                                autocomplete="current-password"
                                class="block w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#26225C] focus:border-transparent transition-all duration-200 text-sm placeholder-gray-500"
                                placeholder="••••••••"
                            />
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm" />
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between pt-2">
                            <label for="remember_me" class="flex items-center cursor-pointer">
                                <input 
                                    id="remember_me" 
                                    type="checkbox" 
                                    name="remember" 
                                    class="h-4 w-4 text-[#26225C] focus:ring-[#26225C] border-gray-300 rounded transition-colors duration-200"
                                >
                                <span class="ml-2 text-sm text-gray-600 font-medium">{{ __('Remember me') }}</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" 
                                   class="text-sm font-medium text-[#26225C] hover:text-[#3a3770] transition-colors duration-200">
                                    {{ __('Forgot password?') }}
                                </a>
                            @endif
                        </div>

                        <!-- Login Button -->
                        <x-primary-button class="w-full bg-gradient-to-r from-[#26225C] to-[#3a3770] hover:from-[#1a1840] hover:to-[#2a2550] text-white font-semibold py-2.5 px-6 rounded-xl transition-all duration-200 transform hover:scale-[1.01] hover:shadow-lg flex items-center justify-center mt-6">
                            {{ __('Sign In') }}
                        </x-primary-button>

                        <!-- Register Link -->
                        @if (Route::has('register'))
                            <div class="text-center pt-2">
                                <p class="text-sm text-gray-600">
                                    Don't have an account? 
                                    <a href="{{ route('register') }}" class="font-semibold text-[#26225C] hover:text-[#3a3770] transition-colors duration-200">
                                        Register here
                                    </a>
                                </p>
                            </div>
                        @endif
                    </form>
                </div>

                <!-- Footer Section -->
                <div class="bg-gray-50 px-8 py-4 border-t border-gray-100">
                    <p class="text-xs text-gray-500 text-center">
                        Secure login powered by USPF Research Archive
                    </p>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-600">
                    <a href="/" class="font-medium text-[#26225C] hover:text-[#3a3770] transition-colors duration-200">← Back to Home</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>