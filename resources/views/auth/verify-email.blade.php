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
                    <h1 class="text-5xl font-bold mb-4">Verify Your Email 📧</h1>
                    
                    <!-- Tagline -->
                    <p class="text-xl opacity-90 leading-relaxed max-w-md">
                        We've sent a verification link to your email address. Please check your inbox and click the link to verify your account.
                    </p>
                </div>
                
                <!-- Copyright -->
                <div class="text-sm opacity-75">
                    © {{ date('Y') }} USPF Research Archive. All rights reserved.
                </div>
            </div>
        </div>
        
        <!-- Right Panel (Verification Content) -->
        <div class="flex-1 flex flex-col justify-center p-8 lg:p-16 bg-white overflow-y-auto">
            <div class="w-full max-w-md mx-auto">
                <!-- Brand Name -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-[#26225C] mb-1">USPF Research Archive</h2>
                </div>
                
                <!-- Main Content -->
                <div class="space-y-6">
                    <!-- Icon -->
                    <div class="flex justify-center mb-6">
                        <div class="h-20 w-20 bg-[#26225C] rounded-full flex items-center justify-center">
                            <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Title -->
                    <h1 class="text-3xl font-bold text-gray-900 mb-4 text-center">Check Your Email</h1>
                    
                    <!-- Message -->
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg mb-6">
                        <p class="text-sm text-gray-700 leading-relaxed">
                            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                        </p>
                    </div>

                    <!-- Success Message -->
                    @if (session('status') == 'verification-link-sent')
                        <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg mb-6">
                            <p class="text-sm text-green-700 font-medium">
                                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                            </p>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="space-y-4">
                        <!-- Resend Verification Email -->
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="w-full bg-[#26225C] hover:bg-[#3a3770] text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                                {{ __('Resend Verification Email') }}
                            </button>
                        </form>

                        <!-- Log Out -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-6 rounded-lg transition-colors duration-200">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>

                    <!-- Help Text -->
                    <div class="mt-8 text-center">
                        <p class="text-sm text-gray-500">
                            Didn't receive the email? Check your spam folder or 
                            <button type="submit" form="resend-form" class="text-[#26225C] hover:text-[#3a3770] font-medium underline">
                                click here to resend
                            </button>
                        </p>
                    </div>

                    <!-- Hidden form for resend link -->
                    <form id="resend-form" method="POST" action="{{ route('verification.send') }}" class="hidden">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
