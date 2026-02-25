<nav x-data="{ open: false, profileOpen: false }" class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-14">
            <!-- Left Section: Logo & Search -->
            <div class="flex items-center flex-1">
                <!-- Logo -->
                <div class="shrink-0 flex items-center mr-2">
                    <a href="{{ route('dashboard') }}" class="group flex items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="USPF Logo" class="h-10 w-10 object-contain" />
                    </a>
                </div>

                <!-- Global Search Box -->
                <div class="hidden sm:block flex-1 max-w-sm ml-2">
                    <form action="{{ route('dashboard') }}" method="GET" class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-gray-900 transition-colors">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ $searchQuery ?? '' }}"
                               placeholder="Search institutional archives..." 
                               class="block w-full pl-9 pr-3 py-1.5 border-transparent bg-[#edf3f8] border-none rounded-md text-sm placeholder-gray-500 focus:bg-white focus:ring-2 focus:ring-[#26225C] focus:border-transparent transition-all duration-200">
                    </form>
                </div>
            </div>

            <!-- Right Section: Navigation Links -->
            <div class="flex items-center space-x-1 sm:space-x-4">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" 
                   class="nav-item-link group flex flex-col items-center justify-center px-1 sm:px-3 pt-1 border-b-2 {{ request()->routeIs('dashboard') ? 'border-gray-900 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-900' }} transition-all duration-200">
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23 9v2h-2v7a3 3 0 01-3 3h-4v-6h-4v6H6a3 3 0 01-3-3v-7H1V9l11-7 11 7z"></path>
                    </svg>
                    <span class="text-[10px] hidden sm:block mt-1 font-medium">Home</span>
                </a>

                @auth
                    <!-- My Research / Network equivalent -->
                    <a href="{{ route('research.history') }}" 
                       class="nav-item-link group flex flex-col items-center justify-center px-1 sm:px-3 pt-1 border-b-2 {{ request()->routeIs('research.history') ? 'border-gray-900 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-900' }} transition-all duration-200">
                        <svg class="h-6 w-6 text-current" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm1 14h-2v-2h2v2zm0-4h-2V7h2v5z"></path>
                        </svg>
                        <span class="text-[10px] hidden sm:block mt-1 font-medium">My Archive</span>
                    </a>

                    <!-- Notifications / Activity -->
                    <button class="nav-item-link group flex flex-col items-center justify-center px-1 sm:px-3 pt-1 border-b-2 border-transparent text-gray-500 hover:text-gray-900 transition-all duration-200">
                        <div class="relative">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 22a2.98 2.98 0 002.818-2H9.182A2.98 2.98 0 0012 22zm7-7.414V10c0-3.217-2.185-5.927-5.145-6.742C13.562 2.52 12.846 2 12 2s-1.562.52-1.855 1.258C7.185 4.074 5 6.783 5 10v4.586l-1.707 1.707A1 1 0 004 18h16a1 1 0 00.707-1.707L19 14.586z"></path>
                            </svg>
                            <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-600 ring-2 ring-white"></span>
                        </div>
                        <span class="text-[10px] hidden sm:block mt-1 font-medium">Notifications</span>
                    </button>

                    <!-- Me Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="flex flex-col items-center justify-center px-3 pt-1 border-b-2 border-transparent text-gray-500 hover:text-gray-900 transition-all duration-200">
                            <div class="h-6 w-6 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden border border-gray-100">
                                <span class="text-[10px] font-bold text-[#26225C]">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <div class="flex items-center mt-1">
                                <span class="text-[10px] hidden sm:block font-medium">Me</span>
                                <svg class="h-3 w-3 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>

                        <!-- Dropdown Content -->
                        <div x-show="open" 
                             @click.outside="open = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             class="absolute right-0 mt-2 w-64 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 overflow-hidden z-50">
                            <div class="p-4 border-b border-gray-100">
                                <div class="flex items-center space-x-3">
                                    <div class="h-12 w-12 rounded-full bg-gray-100 flex items-center justify-center text-lg font-black text-[#26225C]">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                        <p class="text-[11px] text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('profile.edit') }}" class="mt-3 block w-full text-center py-1 border border-blue-600 text-blue-600 rounded-full text-sm font-bold hover:bg-blue-50 transition-colors">
                                    View Profile
                                </a>
                            </div>

                            <div class="py-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                        Sign Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('login') }}" class="px-4 py-1.5 text-sm font-bold text-gray-500 hover:bg-gray-100 rounded-full transition">Sign in</a>
                        <a href="{{ route('register') }}" class="px-4 py-1.5 text-sm font-bold text-blue-600 border border-blue-600 hover:bg-blue-50 rounded-full transition">Join now</a>
                    </div>
                @endauth

                <!-- Hidden Work / Menu Link -->
                @auth
                    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'faculty')
                    <div class="border-l border-gray-200 ml-2 pl-2 hidden sm:flex items-center">
                        <button class="nav-item-link group flex flex-col items-center justify-center px-3 pt-1 border-b-2 border-transparent text-gray-500 hover:text-gray-900 transition-all duration-200">
                             <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3 3h4v4H3V3zm7 0h4v4h-4V3zm7 0h4v4h-4V3zM3 10h4v4H3v-4zm7 0h4v4h-4v-4zm7 0h4v4h-4v-4zM3 17h4v4H3v-4zm7 0h4v4h-4v-4zm7 0h4v4h-4v-4z"></path>
                            </svg>
                            <div class="flex items-center mt-1">
                                <span class="text-[10px] font-medium">Admin</span>
                                <svg class="h-3 w-3 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</nav>
