<x-app-layout>
    <div class="min-h-screen bg-[#f3f2ef]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col lg:flex-row gap-6">
                
                <!-- Left Column: Profile Card & Navigation -->
                <div class="w-full lg:w-64 flex-shrink-0 space-y-4">
                    <!-- Profile Summary Card -->
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                        <div class="h-16 bg-[#26225C] relative">
                            <div class="absolute -bottom-8 left-1/2 -translate-x-1/2">
                                <div class="w-16 h-16 bg-white rounded-full p-1 shadow-sm">
                                    <div class="w-full h-full bg-gray-100 rounded-full flex items-center justify-center border border-gray-200 overflow-hidden">
                                        <span class="text-xl font-black text-[#26225C]">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pt-10 pb-6 px-4 text-center border-b border-gray-100">
                            <h3 class="text-base font-black text-gray-900 leading-tight">{{ Auth::user()->name }}</h3>
                            <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest mt-1">{{ Auth::user()->role }}</p>
                            @if(Auth::user()->course || Auth::user()->department)
                                <p class="text-[10px] text-gray-400 mt-2 italic px-2 leading-snug">
                                    {{ Auth::user()->course ?? Auth::user()->department }}
                                </p>
                            @endif
                        </div>
                        <div class="p-3">
                            <div class="flex justify-between items-center px-2 py-1">
                                <span class="text-[10px] font-bold text-gray-500 uppercase tracking-tight">Member since</span>
                                <span class="text-[10px] font-black text-[#26225C]">{{ Auth::user()->created_at->format('M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Settings Shortcuts -->
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                        <div class="p-3 border-b border-gray-100 bg-gray-50/50">
                            <h4 class="text-[10px] font-black text-gray-900 uppercase tracking-widest">Settings Menu</h4>
                        </div>
                        <div class="py-1">
                            <a href="#personal-info" class="flex items-center px-4 py-2.5 text-[11px] font-bold text-blue-600 bg-blue-50/30 border-l-4 border-blue-600 transition-all">
                                <span>Personal Information</span>
                            </a>
                            <a href="#password-security" class="flex items-center px-4 py-2.5 text-[11px] font-bold text-gray-500 hover:text-gray-900 hover:bg-gray-50 border-l-4 border-transparent transition-all">
                                <span>Password & Security</span>
                            </a>
                            <a href="#delete-account" class="flex items-center px-4 py-2.5 text-[11px] font-bold text-red-500 hover:bg-red-50 border-l-4 border-transparent transition-all">
                                <span>Account Management</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Middle Column: Settings Forms -->
                <div class="flex-1 space-y-4">
                    <!-- Navigation Breadcrumb-style Title -->
                    <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
                        <h1 class="text-xl font-black text-gray-900">Account Settings</h1>
                        <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest mt-0.5">Manage your institutional identity and security</p>
                    </div>

                    <!-- Personal Information -->
                    <div id="personal-info" class="bg-white rounded-xl border border-gray-200 p-8 shadow-sm">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <!-- Password Security -->
                    <div id="password-security" class="bg-white rounded-xl border border-gray-200 p-8 shadow-sm">
                        @include('profile.partials.update-password-form')
                    </div>

                    <!-- Close Account -->
                    <div id="delete-account" class="bg-white rounded-xl border border-gray-200 p-8 shadow-sm border-t-4 border-t-red-100">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>

                <!-- Right Column: Institutional Info -->
                <div class="hidden xl:block w-72 space-y-4">
                    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                        <h4 class="text-[11px] font-black text-gray-900 uppercase tracking-widest mb-4">Institutional Profile</h4>
                        <div class="space-y-4">
                            <p class="text-[12px] text-gray-600 leading-relaxed">
                                Your profile information is used across the USPF Institutional Archive system to attribute your research publications and citations correctly.
                            </p>
                            <div class="p-3 bg-gray-50 border border-gray-100 rounded-lg">
                                <p class="text-[10px] font-bold text-[#26225C] uppercase mb-1">Visibility</p>
                                <p class="text-[11px] text-gray-500">Only approved research works are visible to the public. Your profile details follow institutional privacy guidelines.</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                        <h4 class="text-[11px] font-black text-gray-900 uppercase tracking-widest mb-4">Quick Links</h4>
                        <div class="space-y-2">
                            <a href="{{ route('dashboard') }}" class="block text-[11px] font-bold text-blue-600 hover:underline">Return to Dashboard</a>
                            <a href="{{ route('research.history') }}" class="block text-[11px] font-bold text-blue-600 hover:underline">View my History</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
