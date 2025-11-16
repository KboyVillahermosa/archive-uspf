<nav x-data="{ open: false }" class="bg-[#26225C] border-b border-[#FFC72C] shadow-lg w-full">
    <!-- Primary Navigation Menu -->
    <div class="max-w-full px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo (show for guests/students always, show for admin/faculty only on mobile) -->
                @auth
                    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'faculty' || (Auth::user()->hasRole('admin') || Auth::user()->hasRole('faculty')))
                        <!-- Logo for admin/faculty - only visible on mobile -->
                        <div class="shrink-0 flex items-center md:hidden">
                            <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                                <x-application-logo class="block h-9 w-auto fill-current text-white" />
                                <span class="text-white font-semibold text-sm">USPF Archive</span>
                            </a>
                        </div>
                    @else
                        <!-- Logo for regular users - always visible -->
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                                <x-application-logo class="block h-9 w-auto fill-current text-white" />
                                <span class="hidden sm:block text-white font-semibold text-lg">USPF Archive</span>
                            </a>
                        </div>
                    @endif
                @else
                    <!-- Logo for guests - always visible -->
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                            <x-application-logo class="block h-9 w-auto fill-current text-white" />
                            <span class="hidden sm:block text-white font-semibold text-lg">USPF Archive</span>
                        </a>
                    </div>
                @endauth

                <!-- Sidebar Toggle Button (for admin/faculty) -->
                @auth
                    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'faculty' || (Auth::user()->hasRole('admin') || Auth::user()->hasRole('faculty')))
                    <div class="flex items-center ml-4">
                        <!-- Single responsive sidebar toggle button -->
                        <button @click="$dispatch('sidebar-toggle')" 
                                class="inline-flex items-center justify-center p-2 rounded-lg text-white hover:text-[#FFC72C] hover:bg-[#1a1840] focus:outline-none focus:ring-2 focus:ring-[#FFC72C] transition-all duration-200">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                    @endif
                @endauth

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:ml-10 sm:flex sm:items-center">
                    @auth
                        @if(Auth::user()->role !== 'admin' && Auth::user()->role !== 'faculty' && !Auth::user()->hasRole('admin') && !Auth::user()->hasRole('faculty'))
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        @endif
                        
                        @if(Auth::user()->role !== 'admin' && Auth::user()->role !== 'faculty' && !Auth::user()->hasRole('admin') && !Auth::user()->hasRole('faculty'))
                        <!-- Research History Link -->
                        <x-nav-link :href="route('research.history')" :active="request()->routeIs('research.history')">
                            {{ __('My Research') }}
                        </x-nav-link>
                        
                        <!-- Upload Research Dropdown -->
                        <div class="relative" x-data="{ uploadOpen: false }">
                            <button @click="uploadOpen = !uploadOpen" 
                                class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-white hover:text-yellow-300 hover:border-yellow-300 focus:outline-none focus:text-yellow-300 focus:border-yellow-300 transition-all duration-200 ease-in-out h-16">
                                Upload Research
                                <svg class="ml-1 h-4 w-4 transition-transform duration-200" :class="{ 'rotate-180': uploadOpen }" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            
                            <div x-show="uploadOpen" @click.outside="uploadOpen = false" 
                                 class="absolute left-0 z-50 mt-2 w-64 rounded-lg shadow-xl bg-white ring-1 ring-black ring-opacity-5"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95">
                                <div class="py-2">
                                    <div class="px-4 py-2 border-b border-gray-100">
                                        <h3 class="text-sm font-semibold text-gray-900">Upload Research</h3>
                                        <p class="text-xs text-gray-500">Choose the type of research to upload</p>
                                    </div>
                                           @if(auth()->user()->hasPermissionTo('create student-research') || auth()->user()->hasRole('admin'))
                                           <a href="{{ route('student.upload') }}" 
                                              class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-150">
                                               <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                                   <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                   </svg>
                                               </div>
                                               <div>
                                                   <div class="font-medium">Student Research</div>
                                                   <div class="text-xs text-gray-500">Undergraduate research papers</div>
                                               </div>
                                           </a>
                                           @endif
                                           @if(auth()->user()->hasPermissionTo('create faculty-research') || auth()->user()->hasRole('admin'))
                                           <a href="{{ route('faculty.upload') }}" 
                                              class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition-colors duration-150">
                                               <div class="flex-shrink-0 w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                                   <svg class="h-4 w-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                                   </svg>
                                               </div>
                                               <div>
                                                   <div class="font-medium">Faculty Research</div>
                                                   <div class="text-xs text-gray-500">Academic research papers</div>
                                               </div>
                                           </a>
                                           @endif
                                           @php
                                               $canCreateThesis = false;
                                               try {
                                                   $canCreateThesis = auth()->user()->hasPermissionTo('create thesis');
                                               } catch (\Exception $e) {
                                                   $canCreateThesis = false;
                                               }
                                           @endphp
                                           @if($canCreateThesis || auth()->user()->hasRole('admin'))
                                           <a href="{{ route('thesis.upload') }}" 
                                              class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition-colors duration-150">
                                               <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                                   <svg class="h-4 w-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                   </svg>
                                               </div>
                                               <div>
                                                   <div class="font-medium">Thesis</div>
                                                   <div class="text-xs text-gray-500">Master's degree thesis</div>
                                               </div>
                                           </a>
                                           @endif
                                           @php
                                               $canCreateDissertations = false;
                                               try {
                                                   $canCreateDissertations = auth()->user()->hasPermissionTo('create dissertations');
                                               } catch (\Exception $e) {
                                                   $canCreateDissertations = false;
                                               }
                                           @endphp
                                           @if($canCreateDissertations || auth()->user()->hasRole('admin'))
                                           <a href="{{ route('dissertations.upload') }}" 
                                              class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 transition-colors duration-150">
                                               <div class="flex-shrink-0 w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                                   <svg class="h-4 w-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                   </svg>
                                               </div>
                                               <div>
                                                   <div class="font-medium">Dissertation</div>
                                                   <div class="text-xs text-gray-500">Doctoral dissertation</div>
                                               </div>
                                           </a>
                                           @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            @auth
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-white bg-[#26225C] hover:text-yellow-300 hover:bg-[#1a1840] focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:ring-offset-2 focus:ring-offset-[#26225C] transition-all duration-200 ease-in-out">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center mr-2">
                                    <span class="text-[#26225C] font-semibold text-sm">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </span>
                                </div>
                                <span class="font-medium">{{ Auth::user()->name }}</span>
                                @if(Auth::user()->role === 'admin')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 ml-2">Admin</span>
                                @endif
                            </div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4 text-white transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="bg-white rounded-lg shadow-lg border border-gray-200 py-1">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <div class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                            </div>
                            <x-dropdown-link :href="route('profile.edit')" 
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-800 transition-colors duration-200">
                                {{ __('Profile Settings') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();" 
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 transition-colors duration-150">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>
            @endauth

            <!-- Hamburger (only for users without sidebar) -->
            @auth
                @if(!(Auth::user()->role === 'admin' || Auth::user()->role === 'faculty' || (Auth::user()->hasRole('admin') || Auth::user()->hasRole('faculty'))))
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="open = ! open" 
                        class="inline-flex items-center justify-center p-2 rounded-lg text-white hover:text-yellow-300 hover:bg-[#1a1840] focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:ring-offset-2 focus:ring-offset-[#26225C] transition-all duration-200 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                @endif
            @else
                <!-- Hamburger for guests -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="open = ! open" 
                        class="inline-flex items-center justify-center p-2 rounded-lg text-white hover:text-yellow-300 hover:bg-[#1a1840] focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:ring-offset-2 focus:ring-offset-[#26225C] transition-all duration-200 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endauth
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-[#26225C] border-t border-[#1a1840]">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            
            @auth
                @if(Auth::user()->role !== 'admin')
                <!-- Mobile Research History Link -->
                <x-responsive-nav-link :href="route('research.history')" :active="request()->routeIs('research.history')">
                    📊 My Research
                </x-responsive-nav-link>
                
                <!-- Mobile Upload Research Section -->
                <div class="px-4 py-2">
                    <div class="text-sm font-semibold text-yellow-300 uppercase tracking-wider mb-2">Upload Research</div>
                    <div class="space-y-1 ml-4">
                               @if(auth()->user()->hasPermissionTo('create student-research') || auth()->user()->hasRole('admin'))
                               <x-responsive-nav-link :href="route('student.upload')">
                                   📚 Student Research
                               </x-responsive-nav-link>
                               @endif
                               @if(auth()->user()->hasPermissionTo('create faculty-research') || auth()->user()->hasRole('admin'))
                               <x-responsive-nav-link :href="route('faculty.upload')">
                                   🔬 Faculty Research
                               </x-responsive-nav-link>
                               @endif
                               @php
                                   $canCreateThesisNav = false;
                                   try {
                                       $canCreateThesisNav = auth()->user()->hasPermissionTo('create thesis');
                                   } catch (\Exception $e) {
                                       $canCreateThesisNav = false;
                                   }
                               @endphp
                               @if($canCreateThesisNav || auth()->user()->hasRole('admin'))
                               <x-responsive-nav-link :href="route('thesis.upload')">
                                   📖 Thesis
                               </x-responsive-nav-link>
                               @endif
                               @php
                                   $canCreateDissertationsNav = false;
                                   try {
                                       $canCreateDissertationsNav = auth()->user()->hasPermissionTo('create dissertations');
                                   } catch (\Exception $e) {
                                       $canCreateDissertationsNav = false;
                                   }
                               @endphp
                               @if($canCreateDissertationsNav || auth()->user()->hasRole('admin'))
                               <x-responsive-nav-link :href="route('dissertations.upload')">
                                   📋 Dissertation
                               </x-responsive-nav-link>
                               @endif
                    </div>
                </div>
                @endif
                
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        @auth
        <div class="pt-4 pb-1 border-t border-[#1a1840]">
            <div class="px-4 py-3">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center mr-3">
                        <span class="text-[#26225C] font-semibold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </span>
                    </div>
                    <div>
                        <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-yellow-300">{{ Auth::user()->email }}</div>
                        @if(Auth::user()->role === 'admin')
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 mt-1">Admin</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile Settings') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @endauth
    </div>
</nav>
