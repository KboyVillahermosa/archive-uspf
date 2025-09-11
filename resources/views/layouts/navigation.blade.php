<nav x-data="{ open: false }" class="bg-[#26225C] border-b border-[#26225C]">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-white" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:ml-10 sm:flex sm:items-center">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-[#FFD700] focus:text-[#FFD700]">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    
                    @auth
                        @if(Auth::user()->role !== 'admin')
                        <!-- Research History Link -->
                        <x-nav-link :href="route('research.history')" :active="request()->routeIs('research.history')" class="text-white hover:text-[#FFD700] focus:text-[#FFD700]">
                            {{ __('My Research') }}
                        </x-nav-link>
                        
                        <!-- Upload Research Dropdown -->
                        <div class="relative" x-data="{ uploadOpen: false }">
                            <button @click="uploadOpen = !uploadOpen" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-white hover:text-[#FFD700] hover:border-[#FFD700] focus:outline-none focus:text-[#FFD700] focus:border-[#FFD700] transition duration-150 ease-in-out h-16">
                                Upload Research
                                <svg class="ml-1 h-4 w-4 transition-transform duration-200 text-white" :class="{ 'rotate-180': uploadOpen }" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            
                            <div x-show="uploadOpen" @click.outside="uploadOpen = false" 
                                 class="absolute left-0 z-50 mt-1 w-56 rounded-md shadow-lg bg-[#26225C] ring-1 ring-black ring-opacity-5"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95">
                                <div class="py-1">
                                    <a href="{{ route('student.upload') }}" class="flex items-center px-4 py-3 text-sm text-white hover:bg-[#FFD700] hover:text-[#26225C] transition duration-150 ease-in-out">
                                        <svg class="mr-3 h-5 w-5 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                        <span class="font-medium">Student Research</span>
                                    </a>
                                    <a href="{{ route('faculty.upload') }}" class="flex items-center px-4 py-3 text-sm text-white hover:bg-[#FFD700] hover:text-[#26225C] transition duration-150 ease-in-out">
                                        <svg class="mr-3 h-5 w-5 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                        </svg>
                                        <span class="font-medium">Faculty Research</span>
                                    </a>
                                    <a href="{{ route('thesis.upload') }}" class="flex items-center px-4 py-3 text-sm text-white hover:bg-[#FFD700] hover:text-[#26225C] transition duration-150 ease-in-out">
                                        <svg class="mr-3 h-5 w-5 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span class="font-medium">Thesis</span>
                                    </a>
                                    <a href="{{ route('dissertations.upload') }}" class="flex items-center px-4 py-3 text-sm text-white hover:bg-[#FFD700] hover:text-[#26225C] transition duration-150 ease-in-out">
                                        <svg class="mr-3 h-5 w-5 text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span class="font-medium">Dissertation</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if(Auth::user()->role === 'admin')
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')" class="text-white hover:text-[#FFD700] focus:text-[#FFD700]">
                            {{ __('Admin Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.pending-research')" :active="request()->routeIs('admin.pending-research')" class="text-white hover:text-[#FFD700] focus:text-[#FFD700]">
                            {{ __('Pending Research') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.users')" :active="request()->routeIs('admin.users')" class="text-white hover:text-[#FFD700] focus:text-[#FFD700]">
                            {{ __('Manage Users') }}
                        </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            @auth
            <div class="hidden sm:flex sm:items-center sm:ml-6 bg-[#26225C]">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-[#26225C] hover:text-[#FFD700] hover:bg-[#1a1840] focus:outline-none transition ease-in-out duration-150">
                            <div class="flex items-center">
                                <span>{{ Auth::user()->name }}</span>
                                @if(Auth::user()->role === 'admin')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 ml-2">Admin</span>
                                @endif
                            </div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="bg-[#26225C]">
                            <x-dropdown-link :href="route('profile.edit')" class="text-white hover:bg-white hover:text-[#26225C]">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();" class="text-white hover:bg-[#FFD700] hover:text-[#26225C]">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>
            @endauth

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-[#FFD700] hover:bg-[#1a1840] focus:outline-none focus:bg-[#1a1840] focus:text-[#FFD700] transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-[#26225C]">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-[#FFD700] focus:text-[#FFD700]">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @auth
                @if(Auth::user()->role !== 'admin')
                <!-- Mobile Research History Link -->
                <x-responsive-nav-link :href="route('research.history')" :active="request()->routeIs('research.history')" class="text-white hover:text-[#FFD700] focus:text-[#FFD700]">
                    📊 My Research
                </x-responsive-nav-link>
                <!-- Mobile Upload Research Links -->
                <div class="ml-4 pl-4 border-l-2 border-[#FFD700] space-y-1">
                    <div class="px-3 py-2 text-xs font-medium text-[#FFD700] uppercase tracking-wider">Upload Research</div>
                    <x-responsive-nav-link :href="route('student.upload')" class="pl-4 text-white hover:text-[#FFD700] focus:text-[#FFD700]">
                        📚 Student Research
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('faculty.upload')" class="pl-4 text-white hover:text-[#FFD700] focus:text-[#FFD700]">
                        🔬 Faculty Research
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('thesis.upload')" class="pl-4 text-white hover:text-[#FFD700] focus:text-[#FFD700]">
                        📖 Thesis
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('dissertations.upload')" class="pl-4 text-white hover:text-[#FFD700] focus:text-[#FFD700]">
                        📋 Dissertation
                    </x-responsive-nav-link>
                </div>
                @endif
                @if(Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')" class="text-white hover:text-[#FFD700] focus:text-[#FFD700]">
                    {{ __('Admin Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.pending-research')" :active="request()->routeIs('admin.pending-research')" class="text-white hover:text-[#FFD700] focus:text-[#FFD700]">
                    {{ __('Pending Research') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.users')" :active="request()->routeIs('admin.users')" class="text-white hover:text-[#FFD700] focus:text-[#FFD700]">
                    {{ __('Manage Users') }}
                </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        @auth
        <div class="pt-4 pb-1 border-t border-[#FFD700]">
            <div class="px-4">
                <div class="font-medium text-base text-white flex items-center">
                    {{ Auth::user()->name }}
                    @if(Auth::user()->role === 'admin')
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 ml-2">Admin</span>
                    @endif
                </div>
                <div class="font-medium text-sm text-[#FFD700]">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-white hover:text-[#FFD700] focus:text-[#FFD700]">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();" class="text-white hover:text-[#FFD700] focus:text-[#FFD700]">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @endauth
    </div>
</nav>
