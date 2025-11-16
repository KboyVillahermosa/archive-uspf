@php
    $user = auth()->user();
    $isAdmin = $user && ($user->hasRole('admin') || $user->role === 'admin');
    $isFaculty = $user && ($user->hasRole('faculty') || $user->role === 'faculty');
    $useSidebar = $isAdmin || $isFaculty;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="overflow-x-hidden">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
   
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased overflow-x-hidden">
        @if($useSidebar)
            <!-- Layout with Sidebar for Admin/Faculty -->
            <div x-data="sidebar()" 
                 @sidebar-toggle.window="toggle()"
                 class="min-h-screen bg-gray-100 flex overflow-x-hidden w-full">
                <!-- Sidebar -->
                <x-sidebar />

                <!-- Main Content Area -->
                <div :class="expanded ? 'md:ml-64' : 'md:ml-20'" 
                     class="flex-1 flex flex-col transition-all duration-300 min-w-0 overflow-x-hidden w-full">
                    <!-- Top Navigation Bar -->
                    @include('layouts.navigation')

                    <!-- Page Content -->
                    <main class="flex-1 overflow-x-hidden bg-gray-50 min-w-0 w-full">
                        @isset($header)
                            <header class="bg-white shadow-sm border-b border-gray-200">
                                <div class="px-4 sm:px-6 lg:px-8 py-4">
                                    {{ $header }}
                                </div>
                            </header>
                        @endisset

                        <div class="px-4 sm:px-6 lg:px-8 py-6 w-full max-w-full overflow-x-hidden">
                            {{ $slot }}
                        </div>
                    </main>
                </div>
            </div>
        @else
            <!-- Regular Layout without Sidebar -->
            <div class="min-h-screen bg-gray-100">
                @include('layouts.navigation')

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>
        @endif
        
        @flasher_render

        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        
        @if($useSidebar)
        <script>
            function sidebar() {
                return {
                    expanded: localStorage.getItem('sidebar-expanded') !== 'false',
                    mobileOpen: false,
                    
                    init() {
                        this.$watch('expanded', (value) => {
                            localStorage.setItem('sidebar-expanded', value);
                        });
                    },
                    
                    toggle() {
                        // On mobile devices, toggle mobile overlay
                        if (window.innerWidth < 768) {
                            this.mobileOpen = !this.mobileOpen;
                        } else {
                            // On desktop, toggle sidebar expansion
                            this.expanded = !this.expanded;
                        }
                    }
                }
            }
        </script>
        @endif
    </body>
</html>
