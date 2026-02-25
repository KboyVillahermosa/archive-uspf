@php
    $user = auth()->user();
    $isAdmin = $user && ($user->hasRole('admin') || $user->role === 'admin');
    $isFaculty = $user && ($user->hasRole('faculty') || $user->role === 'faculty');
    
    // Check permissions for faculty access
    $canViewPendingResearch = $isAdmin || (
        $user && (
            $user->hasPermissionTo('approve student-research') ||
            $user->hasPermissionTo('approve faculty-research') ||
            $user->hasPermissionTo('approve thesis') ||
            $user->hasPermissionTo('approve dissertations')
        )
    );
    
    try {
        $canManageUsers = $isAdmin || ($isFaculty && $user && $user->hasPermissionTo('manage department users')) || ($user && $user->hasPermissionTo('view-any users'));
    } catch (\Exception $e) {
        $canManageUsers = $isAdmin || ($user && $user->hasPermissionTo('view-any users'));
    }
@endphp

@if($isAdmin || $isFaculty)
<div class="main">
    <!-- Desktop Sidebar -->
    <aside :class="expanded ? 'w-64' : 'w-20'" 
           class="hidden md:flex fixed inset-y-0 left-0 z-50 bg-white transition-all duration-300 ease-in-out flex-col border-r border-gray-200">
        
        <!-- Sidebar Header -->
        <div class="flex items-center h-14 px-6 border-b border-gray-100 flex-shrink-0">
            <div class="flex items-center" :class="expanded ? 'space-x-3' : 'justify-center w-full'">
                <div class="p-1 bg-[#26225C] rounded-md">
                    <img src="{{ asset('images/logo.png') }}" alt="USPF Logo" class="h-6 w-6 object-contain brightness-0 invert" />
                </div>
                <span x-show="expanded" 
                      class="text-gray-900 font-black text-sm tracking-tight whitespace-nowrap uppercase">Institutional <span class="text-blue-600">Admin</span></span>
            </div>
        </div>
        
        <!-- Navigation Links -->
        <nav class="flex-1 py-4 space-y-0.5 overflow-y-auto custom-scrollbar">
            @php
                $navItems = [
                    [
                        'route' => 'admin.dashboard',
                        'label' => 'Dashboard',
                        'icon' => '<path d="M23 9v2h-2v7a3 3 0 01-3 3h-4v-6h-4v6H6a3 3 0 01-3-3v-7H1V9l11-7 11 7z"></path>',
                        'show' => $isAdmin || $isFaculty,
                        'active' => request()->routeIs('admin.dashboard')
                    ],
                    [
                        'route' => 'admin.research',
                        'label' => 'Content Library',
                        'icon' => '<path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>',
                        'show' => $isAdmin || $isFaculty,
                        'active' => request()->routeIs('admin.research')
                    ],
                    [
                        'route' => 'admin.pending-research',
                        'label' => 'Approvals',
                        'icon' => '<path d="M9 11l3 3L22 4m-2-2v10H4V2"></path>', // Simplified for placeholder
                        'real_icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
                        'show' => $canViewPendingResearch,
                        'active' => request()->routeIs('admin.pending-research')
                    ],
                    [
                        'route' => 'admin.users.index',
                        'label' => 'Members',
                        'icon' => '<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2m16-10a4 4 0 11-8 0 4 4 0 018 0z"></path>',
                        'show' => $canManageUsers,
                        'active' => request()->routeIs('admin.users.*')
                    ],
                    [
                        'route' => 'admin.roles.index',
                        'label' => 'Governance',
                        'icon' => '<path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-11V7a4 4 0 00-8 0v4h8z"></path>',
                        'show' => $isAdmin,
                        'active' => request()->routeIs('admin.roles.*')
                    ],
                    [
                        'route' => 'admin.downloads-views',
                        'label' => 'Insights',
                        'icon' => '<path d="M18 20V10M12 20V4M6 20v-6"></path>',
                        'show' => $isAdmin,
                        'active' => request()->routeIs('admin.downloads-views')
                    ]
                ];
            @endphp

            @foreach($navItems as $item)
                @if($item['show'])
                <a href="{{ route($item['route']) }}" 
                   class="flex items-center transition-all duration-200 group relative {{ $item['active'] ? 'text-gray-900 font-bold' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}"
                   :class="expanded ? 'px-6 py-3 justify-start' : 'px-2 py-4 justify-center'">
                    @if($item['active'])
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-blue-600 rounded-r"></div>
                    @endif
                    <svg class="w-5 h-5 flex-shrink-0" :class="expanded ? 'mr-3' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        {!! $item['real_icon'] ?? $item['icon'] !!}
                    </svg>
                    <span x-show="expanded" class="text-sm tracking-tight whitespace-nowrap">{{ $item['label'] }}</span>
                </a>
                @endif
            @endforeach

            @if($isFaculty)
                <div class="mt-6 mb-2 px-6" x-show="expanded">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Repository</span>
                </div>
                <a href="{{ route('faculty.upload') }}" 
                   class="flex items-center px-6 py-3 transition-all duration-200 group {{ request()->routeIs('faculty.upload') ? 'text-gray-900 font-bold' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span x-show="expanded" class="text-sm tracking-tight whitespace-nowrap">Publish New</span>
                </a>
            @endif
        </nav>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-gray-100 flex-shrink-0">
            <div class="flex items-center" :class="expanded ? 'space-x-3' : 'justify-center w-full'">
                <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center border border-gray-200 flex-shrink-0">
                    <span class="text-[#26225C] font-bold text-xs">
                        {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                    </span>
                </div>
                <div class="flex-1 min-w-0" x-show="expanded">
                    <p class="text-[12px] font-bold text-gray-900 truncate leading-tight">{{ $user->name ?? 'User' }}</p>
                    <p class="text-[10px] text-gray-400 uppercase tracking-tight truncate">{{ $user->role ?? 'Institutional' }}</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Mobile Sidebar Backdrop -->
    <div x-show="mobileOpen" 
         @click="mobileOpen = false" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-[60] md:hidden"></div>

    <!-- Mobile Sidebar -->
    <aside x-show="mobileOpen" 
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="-translate-x-full"
           x-transition:enter-end="translate-x-0"
           x-transition:leave="transition ease-in duration-300"
           x-transition:leave-start="translate-x-0"
           x-transition:leave-end="-translate-x-full"
           class="fixed top-0 left-0 bottom-0 z-[70] w-[80%] max-w-[280px] bg-white shadow-2xl flex flex-col md:hidden border-r border-gray-200">
        
        <!-- Mobile Header -->
        <div class="flex items-center justify-between h-14 px-6 border-b border-gray-100 flex-shrink-0">
            <div class="flex items-center space-x-3">
                <div class="p-1 bg-[#26225C] rounded-md">
                    <img src="{{ asset('images/logo.png') }}" alt="USPF Logo" class="h-6 w-6 object-contain brightness-0 invert" />
                </div>
                <span class="text-gray-900 font-black text-sm uppercase tracking-tight">Institutional Admin</span>
            </div>
            <button @click="mobileOpen = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Mobile Navigation -->
        <nav class="flex-1 px-2 py-4 space-y-1 overflow-y-auto">
            @foreach($navItems as $item)
                @if($item['show'])
                <a href="{{ route($item['route']) }}" 
                   @click="mobileOpen = false"
                   class="flex items-center px-4 py-3 rounded-md text-sm transition-all duration-200 {{ $item['active'] ? 'bg-blue-50 text-blue-700 font-bold' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        {!! $item['real_icon'] ?? $item['icon'] !!}
                    </svg>
                    <span>{{ $item['label'] }}</span>
                </a>
                @endif
            @endforeach
        </nav>

        <!-- Mobile Footer -->
        <div class="p-6 border-t border-gray-100 flex-shrink-0">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center border border-gray-200 shadow-sm">
                    <span class="text-[#26225C] font-black text-sm">
                        {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-bold text-gray-900 truncate">{{ $user->name ?? 'User' }}</p>
                    <p class="text-[10px] text-gray-500 uppercase tracking-widest truncate">{{ $user->role ?? 'Institutional' }}</p>
                </div>
            </div>
        </div>
    </aside>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.2);
    }
</style>
@endif
