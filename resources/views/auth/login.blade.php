<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="min-h-screen flex items-center justify-center py-2 px-2 sm:px-4 lg:px-4">
        <div class="max-w-6xl w-full">
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
                <div class="flex flex-col lg:flex-row min-h-[600px]">
                    
                    <!-- Left Panel (Form) -->
                    <div class="flex-1 flex flex-col justify-center px-8 py-12 lg:px-12">
                        <div class="w-full max-w-md mx-auto">
                            <!-- Logo & Title -->
                            <div class="text-center mb-8">
                                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-[#26225C] to-[#3a3770] rounded-2xl mb-4">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <h1 class="text-3xl font-bold text-[#26225C] mb-2">Welcome Back</h1>
                                <p class="text-gray-600 text-lg">Sign in to your USPF Research Archive account</p>
                            </div>

                            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                                @csrf

                                <!-- Email Address -->
                                <div>
                                    <x-input-label for="email" :value="__('Email Address')" class="text-sm font-semibold text-gray-700 mb-2" />
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                            </svg>
                                        </div>
                                        <x-text-input 
                                            id="email" 
                                            type="email" 
                                            name="email" 
                                            :value="old('email')" 
                                            required 
                                            autofocus 
                                            autocomplete="username"
                                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#26225C] focus:border-[#26225C] transition-colors duration-200"
                                            placeholder="Enter your email address"
                                        />
                                    </div>
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <!-- Password -->
                                <div>
                                    <x-input-label for="password" :value="__('Password')" class="text-sm font-semibold text-gray-700 mb-2" />
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                        </div>
                                        <x-text-input 
                                            id="password" 
                                            type="password" 
                                            name="password" 
                                            required 
                                            autocomplete="current-password"
                                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#26225C] focus:border-[#26225C] transition-colors duration-200"
                                            placeholder="Enter your password"
                                        />
                                    </div>
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <!-- Remember Me & Forgot Password -->
                                <div class="flex items-center justify-between">
                                    <label for="remember_me" class="flex items-center">
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
                                <div>
                                    <x-primary-button class="w-full bg-gradient-to-r from-[#26225C] to-[#3a3770] hover:from-[#1a1840] hover:to-[#2a2550] text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-[1.02] hover:shadow-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                        </svg>
                                        {{ __('Sign In') }}
                                    </x-primary-button>
                                </div>

                                <!-- Register Link -->
                                @if (Route::has('register'))
                                    <div class="text-center">
                                        <p class="text-sm text-gray-600">
                                            Don't have an account? 
                                            <a href="{{ route('register') }}" class="font-semibold text-[#26225C] hover:text-[#3a3770] transition-colors duration-200">
                                                Create one here
                                            </a>
                                        </p>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                    
                    <!-- Right Panel (Visual) -->
                    <div class="hidden lg:flex lg:flex-1 bg-gradient-to-br from-[#26225C] via-[#3a3770] to-[#4a4a8a] relative overflow-hidden">
                        <!-- Background Pattern -->
                        <div class="absolute inset-0 opacity-10">
                            <div class="absolute top-0 left-0 w-full h-full" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.1"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                        </div>
                        
                        <!-- Content -->
                        <div class="relative z-10 flex flex-col justify-center items-center text-center p-12 text-white">
                            <!-- Icon -->
                            <div class="w-24 h-24 bg-white/20 rounded-3xl flex items-center justify-center mb-8 backdrop-blur-sm">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            
                            <!-- Title -->
                            <h2 class="text-3xl font-bold mb-4">USPF Research Archive</h2>
                            <p class="text-xl opacity-90 mb-8 leading-relaxed">
                                Access thousands of research papers, theses, and dissertations from our academic community
                            </p>
                            
                            <!-- Features -->
                            <div class="space-y-4 w-full max-w-sm">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm opacity-90">Browse by department</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm opacity-90">Advanced search filters</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm opacity-90">Citation tracking</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm opacity-90">Research collaboration</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Decorative Elements -->
                        <div class="absolute top-10 right-10 w-20 h-20 bg-white/10 rounded-full"></div>
                        <div class="absolute bottom-10 left-10 w-16 h-16 bg-white/10 rounded-full"></div>
                        <div class="absolute top-1/2 right-20 w-12 h-12 bg-white/10 rounded-full"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>