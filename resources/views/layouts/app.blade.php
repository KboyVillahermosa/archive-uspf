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

        <title>{{ config('app.name', 'USPF Research Archive') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
   
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>

        <style>
            :root {
                --primary-navy: #26225C;
                --primary-gold: #FFC72C;
                --secondary-navy: #3a3770;
            }
            body { 
                font-family: 'Inter', sans-serif; 
                background-color: #F8FAFC;
                color: #1E293B;
            }
            
            /* Research Cards */
            .research-card {
                background: white;
                border-radius: 0;
                padding: 1.75rem;
                border: 1px solid rgba(226, 232, 240, 1);
                transition: all 0.2s ease-in-out;
                display: flex;
                flex-direction: column;
                height: 100%;
                position: relative;
                overflow: hidden;
            }
            .research-card:hover {
                border-color: var(--primary-navy);
                background-color: #fcfcfc;
            }
            
            /* Badges & Tags */
            .badge {
                display: inline-flex;
                align-items: center;
                padding: 0.25rem 0.625rem;
                border-radius: 0;
                font-size: 0.625rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.1em;
                border: 1px solid currentColor;
            }
            .section-tag {
                display: inline-block;
                color: #94a3b8;
                font-weight: 700;
                font-size: 0.65rem;
                text-transform: uppercase;
                letter-spacing: 0.2em;
                margin-bottom: 0.5rem;
            }

            /* Animations */
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-up {
                animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            }

            /* Scrollbar */
            ::-webkit-scrollbar { width: 8px; }
            ::-webkit-scrollbar-track { background: #f8fafc; }
            ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
            ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased overflow-x-hidden">
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
