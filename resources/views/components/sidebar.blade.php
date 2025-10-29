@php
    $user = auth()->user();
    $isAdmin = $user && ($user->hasRole('admin') || $user->role === 'admin');
    $isFaculty = $user && ($user->hasRole('faculty') || $user->role === 'faculty');
@endphp

@if($isAdmin || $isFaculty)
<div class="main">
    <!-- Desktop Sidebar -->
    <aside :class="expanded ? 'w-64' : 'w-20'" 
           class="hidden md:flex fixed inset-y-0 left-0 z-50 bg-[#26225C] shadow-xl transform transition-all duration-300 ease-in-out flex-col">
        
        <!-- Navigation Links -->
        <nav class="flex-1 py-6 space-y-2 overflow-y-auto mt-16" :class="expanded ? 'px-4' : 'px-2'">
            @if($isAdmin)
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center text-sm font-medium rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.dashboard') ? 'bg-yellow-400 text-[#26225C] shadow-md' : 'text-white hover:bg-[#1a1840] hover:text-yellow-300' }}"
                   :class="expanded ? 'px-4 py-3 justify-start' : 'px-2 py-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0" :class="expanded ? 'mr-3' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span x-show="expanded" 
                          x-transition:enter="transition ease-out duration-200 delay-100" 
                          x-transition:enter-start="opacity-0" 
                          x-transition:enter-end="opacity-100" 
                          x-transition:leave="transition ease-in duration-150" 
                          x-transition:leave-start="opacity-100" 
                          x-transition:leave-end="opacity-0"
                          class="whitespace-nowrap">Dashboard</span>
                </a>

                <!-- Pending Research -->
                <a href="{{ route('admin.pending-research') }}" 
                   class="flex items-center text-sm font-medium rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.pending-research') ? 'bg-yellow-400 text-[#26225C] shadow-md' : 'text-white hover:bg-[#1a1840] hover:text-yellow-300' }}"
                   :class="expanded ? 'px-4 py-3 justify-start' : 'px-2 py-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0" :class="expanded ? 'mr-3' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span x-show="expanded" 
                          x-transition:enter="transition ease-out duration-200 delay-100" 
                          x-transition:enter-start="opacity-0" 
                          x-transition:enter-end="opacity-100" 
                          x-transition:leave="transition ease-in duration-150" 
                          x-transition:leave-start="opacity-100" 
                          x-transition:leave-end="opacity-0"
                          class="whitespace-nowrap">Pending Research</span>
                </a>

                <!-- Manage Users -->
                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center text-sm font-medium rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.users.*') ? 'bg-yellow-400 text-[#26225C] shadow-md' : 'text-white hover:bg-[#1a1840] hover:text-yellow-300' }}"
                   :class="expanded ? 'px-4 py-3 justify-start' : 'px-2 py-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0" :class="expanded ? 'mr-3' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span x-show="expanded" 
                          x-transition:enter="transition ease-out duration-200 delay-100" 
                          x-transition:enter-start="opacity-0" 
                          x-transition:enter-end="opacity-100" 
                          x-transition:leave="transition ease-in duration-150" 
                          x-transition:leave-start="opacity-100" 
                          x-transition:leave-end="opacity-0"
                          class="whitespace-nowrap">Manage Users</span>
                </a>

                <!-- Roles & Permissions -->
                <a href="{{ route('admin.roles.index') }}" 
                   class="flex items-center text-sm font-medium rounded-lg transition-all duration-200 group {{ request()->routeIs('admin.roles.*') ? 'bg-yellow-400 text-[#26225C] shadow-md' : 'text-white hover:bg-[#1a1840] hover:text-yellow-300' }}"
                   :class="expanded ? 'px-4 py-3 justify-start' : 'px-2 py-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0" :class="expanded ? 'mr-3' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                    </svg>
                    <span x-show="expanded" 
                          x-transition:enter="transition ease-out duration-200 delay-100" 
                          x-transition:enter-start="opacity-0" 
                          x-transition:enter-end="opacity-100" 
                          x-transition:leave="transition ease-in duration-150" 
                          x-transition:leave-start="opacity-100" 
                          x-transition:leave-end="opacity-0"
                          class="whitespace-nowrap">Roles & Permissions</span>
                </a>
            @endif

            @if($isFaculty && !$isAdmin)
                <!-- Faculty Dashboard -->
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center text-sm font-medium rounded-lg transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'bg-yellow-400 text-[#26225C] shadow-md' : 'text-white hover:bg-[#1a1840] hover:text-yellow-300' }}"
                   :class="expanded ? 'px-4 py-3 justify-start' : 'px-2 py-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0" :class="expanded ? 'mr-3' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span x-show="expanded" 
                          x-transition:enter="transition ease-out duration-200 delay-100" 
                          x-transition:enter-start="opacity-0" 
                          x-transition:enter-end="opacity-100" 
                          x-transition:leave="transition ease-in duration-150" 
                          x-transition:leave-start="opacity-100" 
                          x-transition:leave-end="opacity-0"
                          class="whitespace-nowrap">Dashboard</span>
                </a>

                <!-- My Research -->
                <a href="{{ route('research.history') }}" 
                   class="flex items-center text-sm font-medium rounded-lg transition-all duration-200 group {{ request()->routeIs('research.history') ? 'bg-yellow-400 text-[#26225C] shadow-md' : 'text-white hover:bg-[#1a1840] hover:text-yellow-300' }}"
                   :class="expanded ? 'px-4 py-3 justify-start' : 'px-2 py-3 justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0" :class="expanded ? 'mr-3' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span x-show="expanded" 
                          x-transition:enter="transition ease-out duration-200 delay-100" 
                          x-transition:enter-start="opacity-0" 
                          x-transition:enter-end="opacity-100" 
                          x-transition:leave="transition ease-in duration-150" 
                          x-transition:leave-start="opacity-100" 
                          x-transition:leave-end="opacity-0"
                          class="whitespace-nowrap">My Research</span>
                </a>
            @endif
        </nav>

        <!-- Sidebar Footer -->
        <div class="border-t border-[#1a1840] bg-[#1a1840] flex-shrink-0" 
             :class="expanded ? 'p-4' : 'p-2'"
             x-show="expanded" 
             x-transition:enter="transition ease-out duration-200 delay-100"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="flex items-center" :class="expanded ? 'space-x-3' : 'justify-center'">
                <div class="w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center shadow-md flex-shrink-0">
                    <span class="text-[#26225C] font-semibold text-sm">
                        {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                    </span>
                </div>
                <div class="flex-1 min-w-0" x-show="expanded">
                    <p class="text-sm font-medium text-white truncate">{{ $user->name ?? 'User' }}</p>
                    <p class="text-xs text-yellow-300 truncate">{{ $user->email ?? '' }}</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Mobile Overlay Backdrop -->
    <div x-show="mobileOpen" 
         @click="mobileOpen = false" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed top-16 left-0 right-0 bottom-0 bg-black/70 z-40 md:hidden"
         style="display: none;"></div>

    <!-- Mobile Sidebar -->
    <aside x-show="mobileOpen" 
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="-translate-x-full"
           x-transition:enter-end="translate-x-0"
           x-transition:leave="transition ease-in duration-300"
           x-transition:leave-start="translate-x-0"
           x-transition:leave-end="-translate-x-full"
           class="fixed top-16 left-0 bottom-0 z-50 w-64 bg-[#26225C] shadow-xl flex flex-col md:hidden"
           style="display: none;">
        
        <!-- Mobile Header -->
        <div class="flex items-center justify-between h-16 px-6 border-b border-[#1a1840] flex-shrink-0">
            <div class="flex items-center space-x-2">
                <x-application-logo class="block h-8 w-auto fill-current text-white" />
                <span class="text-white font-semibold text-lg">USPF Archive</span>
            </div>
            <button @click="mobileOpen = false" class="text-white hover:text-yellow-300 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Mobile Navigation Links -->
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            @if($isAdmin)
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" 
                   @click="mobileOpen = false"
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-yellow-400 text-[#26225C] shadow-md' : 'text-white hover:bg-[#1a1840] hover:text-yellow-300' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <!-- Pending Research -->
                <a href="{{ route('admin.pending-research') }}" 
                   @click="mobileOpen = false"
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.pending-research') ? 'bg-yellow-400 text-[#26225C] shadow-md' : 'text-white hover:bg-[#1a1840] hover:text-yellow-300' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Pending Research</span>
                </a>

                <!-- Manage Users -->
                <a href="{{ route('admin.users.index') }}" 
                   @click="mobileOpen = false"
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-yellow-400 text-[#26225C] shadow-md' : 'text-white hover:bg-[#1a1840] hover:text-yellow-300' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span>Manage Users</span>
                </a>

                <!-- Roles & Permissions -->
                <a href="{{ route('admin.roles.index') }}" 
                   @click="mobileOpen = false"
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.roles.*') ? 'bg-yellow-400 text-[#26225C] shadow-md' : 'text-white hover:bg-[#1a1840] hover:text-yellow-300' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                    </svg>
                    <span>Roles & Permissions</span>
                </a>
            @endif

            @if($isFaculty && !$isAdmin)
                <!-- Faculty Dashboard -->
                <a href="{{ route('dashboard') }}" 
                   @click="mobileOpen = false"
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-yellow-400 text-[#26225C] shadow-md' : 'text-white hover:bg-[#1a1840] hover:text-yellow-300' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <!-- My Research -->
                <a href="{{ route('research.history') }}" 
                   @click="mobileOpen = false"
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('research.history') ? 'bg-yellow-400 text-[#26225C] shadow-md' : 'text-white hover:bg-[#1a1840] hover:text-yellow-300' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>My Research</span>
                </a>
            @endif
        </nav>

        <!-- Mobile Footer -->
        <div class="p-4 border-t border-[#1a1840] bg-[#1a1840] flex-shrink-0">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center shadow-md flex-shrink-0">
                    <span class="text-[#26225C] font-semibold text-sm">
                        {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ $user->name ?? 'User' }}</p>
                    <p class="text-xs text-yellow-300 truncate">{{ $user->email ?? '' }}</p>
                </div>
            </div>
        </div>
    </aside>
</div>
@endif
