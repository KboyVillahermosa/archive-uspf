<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:200,300,400,500,600,700,800,900" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    
    <style>
        :root {
            --primary-navy: #26225C;
            --primary-gold: #FFC72C;
            --secondary-navy: #342e7c;
            --bg-light: #F3F2EF;
        }

        body {
            font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", "Fira Sans", Ubuntu, Oxygen, "Oxygen Sans", Cantarell, "Droid Sans", "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Lucida Grande", Helvetica, Arial, sans-serif;
            background-color: var(--bg-light);
            color: rgba(0,0,0,0.9);
            scroll-behavior: smooth;
            -webkit-font-smoothing: antialiased;
        }

        .btn-premium {
            background-color: var(--primary-navy);
            color: white;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 9999px;
            font-weight: 600;
        }

        .btn-premium:hover {
            background-color: var(--secondary-navy);
        }

        .btn-secondary {
            background-color: transparent;
            color: rgba(0,0,0,0.6);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 9999px;
            font-weight: 600;
            box-shadow: inset 0 0 0 1px rgba(0,0,0,0.6);
        }

        .btn-secondary:hover {
            background-color: rgba(0,0,0,0.08);
            color: rgba(0,0,0,0.9);
            box-shadow: inset 0 0 0 2px rgba(0,0,0,0.9);
        }

        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: #F3F2EF; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 5px; border: 2px solid #F3F2EF; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>

<body class="min-h-screen bg-[#F3F2EF]">
    <!-- Navigation Bar -->
    <nav class="bg-white sticky top-0 z-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('welcome') }}" class="flex items-center group">
                        <img src="{{ asset('images/logo.png') }}" alt="USPF Logo" class="h-10 w-10 object-contain mr-2" />
                        <h1 class="text-xl font-black text-[#26225C] tracking-tight hidden sm:block">USPF Archive</h1>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('research.by-department') }}" class="text-gray-500 hover:text-[#26225C] font-semibold text-sm transition-colors duration-200">Browse</a>
                    <a href="{{ route('research.by-department') }}" class="text-gray-500 hover:text-[#26225C] font-semibold text-sm transition-colors duration-200">Departments</a>
                    
                    <div class="h-6 w-px bg-gray-300"></div>

                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-[#26225C] font-black text-sm hover:underline">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-[#26225C] font-black text-sm px-5 py-1.5 rounded-full border-2 border-[#26225C] hover:bg-gray-50 transition-colors">Sign in</a>
                        @endauth
                    @endif
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" id="mobile-menu-button" class="text-gray-500 hover:text-[#26225C] p-2">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile menu -->
    <div id="mobile-menu" class="md:hidden hidden bg-white border-b border-gray-200 shadow-sm">
        <div class="px-4 pt-2 pb-4 space-y-1">
            <a href="{{ route('research.by-department') }}" class="text-gray-600 hover:text-[#26225C] block py-2 text-sm font-bold">Browse Research</a>
            <a href="{{ route('research.by-department') }}" class="text-gray-600 hover:text-[#26225C] block py-2 text-sm font-bold">Departments</a>
            
            <div class="border-t border-gray-200 pt-4 mt-2">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-[#26225C] block w-full bg-gray-50 text-center py-2 rounded-lg text-sm font-black">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-[#26225C] block w-full border-2 border-[#26225C] text-center py-2 rounded-full text-sm font-black">Sign in</a>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="relative h-[90vh] min-h-[700px] flex items-center overflow-hidden bg-[#26225C]">
        <!-- Background Asset -->
        <div class="absolute inset-0 z-0">
            @if(file_exists(public_path('images/bg.mp4')))
                <video autoplay loop muted playsinline class="w-full h-full object-cover opacity-80">
                    <source src="/images/bg.mp4" type="video/mp4">
                </video>
            @endif
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 to-transparent"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full text-left">
            <div class="lg:w-2/3">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-light text-white mb-4 leading-tight tracking-tight px-1 drop-shadow-lg">
                    Welcome to your <br> <strong class="font-black text-white">academic community</strong>
                </h1>
                <p class="text-lg md:text-xl text-gray-200 mb-2 max-w-2xl font-light leading-relaxed px-1 drop-shadow">
                    A centralized repository for research studies, theses, and dissertations. Driving innovation through institutional knowledge.
                </p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="py-2 bg-[#F3F2EF]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Global Search Section -->
            <div id="search-section" class="mb-8">
                <div class="bg-white border border-gray-200 rounded-xl p-6 lg:p-8 shadow-sm">
                    <h2 class="text-xl font-bold text-gray-900 mb-5">Find a colleague or publication</h2>
                    <form id="search-form" method="GET" action="{{ route('welcome') }}" class="relative max-w-2xl">
                        <div class="relative flex items-center bg-gray-50 rounded-lg border border-gray-300 overflow-hidden focus-within:border-gray-500 focus-within:ring-1 focus-within:ring-gray-500 transition-all">
                            <div class="pl-4 text-gray-600">
                                <svg id="search-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <svg id="loading-spinner" class="w-5 h-5 hidden animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                            <input 
                                type="text" 
                                name="search" 
                                id="search-input"
                                value="{{ $searchQuery ?? '' }}"
                                placeholder="Search by title, authors, or department..." 
                                class="w-full px-4 py-3 bg-transparent border-0 focus:ring-0 text-base text-gray-900"
                                autocomplete="off"
                            >
                            @if(!empty($searchQuery))
                                <button type="button" id="clear-search" class="p-2 mr-2 text-gray-500 hover:text-gray-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            @endif
                        </div>
                    </form>

                    @if(!empty($searchQuery))
                        <div class="mt-4 flex items-center gap-4 text-sm">
                            <span class="text-gray-600">
                                Found <strong>{{ $approvedStudentResearch->count() + $approvedFacultyResearch->count() + $approvedThesis->count() + $approvedDissertations->count() }}</strong> results for "{{ $searchQuery }}"
                            </span>
                            <a href="{{ route('welcome') }}" class="text-[#26225C] font-semibold hover:underline">Clear search</a>
                        </div>
                    @else
                        <div class="mt-5 flex flex-wrap gap-2 items-center">
                            <span class="text-sm font-semibold text-gray-600 mr-2">Suggested topics</span>
                            <span class="px-4 py-1.5 bg-gray-100 border border-gray-200 rounded-full text-sm font-semibold text-gray-700 cursor-pointer hover:bg-gray-200 transition-colors">Computer Science</span>
                            <span class="px-4 py-1.5 bg-gray-100 border border-gray-200 rounded-full text-sm font-semibold text-gray-700 cursor-pointer hover:bg-gray-200 transition-colors">Education</span>
                            <span class="px-4 py-1.5 bg-gray-100 border border-gray-200 rounded-full text-sm font-semibold text-gray-700 cursor-pointer hover:bg-gray-200 transition-colors">Business</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Research Sections -->
            @php
                $totalResearch = $approvedStudentResearch->count() + $approvedFacultyResearch->count() + $approvedThesis->count() + $approvedDissertations->count();
            @endphp
            @if($totalResearch > 0)
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                    
                    <!-- Left Column / Content feeds -->
                    <div class="md:col-span-8 space-y-4">
                        
                        @if($approvedStudentResearch->count() > 0 || $approvedFacultyResearch->count() > 0)
                            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                                    <h2 class="text-base font-bold text-gray-900">Recent Publications</h2>
                                </div>
                                <div class="divide-y divide-gray-200">
                                    @foreach($approvedStudentResearch->take(3) as $research)
                                        <div class="p-6 hover:bg-gray-50 transition-colors group">
                                            <div class="flex items-start justify-between gap-4">
                                                <div class="flex-1">
                                                    <span class="text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2 block">Student Research</span>
                                                    <a href="{{ route('student.show.public', $research->id) }}" class="block inline-block w-full">
                                                        <h4 class="text-base font-bold text-gray-900 mb-1 group-hover:text-blue-700 transition-colors">{{ $research->title }}</h4>
                                                    </a>
                                                    <p class="text-sm text-gray-600 mb-3">{{ $research->authors }}</p>
                                                    <div class="flex items-center gap-3 text-xs text-gray-500">
                                                        <span class="font-semibold">{{ $research->department }}</span>
                                                        <span>&bull;</span>
                                                        <span>{{ $research->year_completed ?? '2024' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    @foreach($approvedFacultyResearch->take(3) as $research)
                                        <div class="p-6 hover:bg-gray-50 transition-colors group">
                                            <div class="flex items-start justify-between gap-4">
                                                <div class="flex-1">
                                                    <span class="text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2 block">Faculty Research</span>
                                                    <a href="{{ route('faculty.show.public', $research->id) }}" class="block inline-block w-full">
                                                        <h4 class="text-base font-bold text-gray-900 mb-1 group-hover:text-blue-700 transition-colors">{{ $research->title }}</h4>
                                                    </a>
                                                    <p class="text-sm text-gray-600 mb-3">{{ $research->user->name }}</p>
                                                    <div class="flex items-center gap-3 text-xs text-gray-500">
                                                        <span class="font-semibold">{{ $research->department }}</span>
                                                        <span>&bull;</span>
                                                        <span>{{ $research->year_published ?? '2024' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($approvedThesis->count() > 0 || $approvedDissertations->count() > 0)
                            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                                    <h2 class="text-base font-bold text-gray-900">Postgraduate Studies</h2>
                                </div>
                                <div class="divide-y divide-gray-200">
                                    @foreach($approvedThesis->take(3) as $thesis)
                                        <div class="p-6 hover:bg-gray-50 transition-colors group">
                                            <div class="flex items-start justify-between gap-4">
                                                <div class="flex-1">
                                                    <span class="text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2 block">Master's Thesis</span>
                                                    <a href="{{ route('thesis.show.public', $thesis->id) }}" class="block inline-block w-full">
                                                        <h4 class="text-base font-bold text-gray-900 mb-1 group-hover:text-blue-700 transition-colors">{{ $thesis->title }}</h4>
                                                    </a>
                                                    <p class="text-sm text-gray-600 mb-3">{{ $thesis->author }}</p>
                                                    <div class="flex items-center gap-3 text-xs text-gray-500">
                                                        <span class="font-semibold">{{ $thesis->department }}</span>
                                                        <span>&bull;</span>
                                                        <span>{{ $thesis->year_completed ?? '2024' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    @foreach($approvedDissertations->take(3) as $dissertation)
                                        <div class="p-6 hover:bg-gray-50 transition-colors group">
                                            <div class="flex items-start justify-between gap-4">
                                                <div class="flex-1">
                                                    <span class="text-[11px] font-bold text-gray-500 uppercase tracking-widest mb-2 block">Dissertation</span>
                                                    <a href="{{ route('dissertation.show.public', $dissertation->id) }}" class="block inline-block w-full">
                                                        <h4 class="text-base font-bold text-gray-900 mb-1 group-hover:text-blue-700 transition-colors">{{ $dissertation->title }}</h4>
                                                    </a>
                                                    <p class="text-sm text-gray-600 mb-3">{{ $dissertation->author }}</p>
                                                    <div class="flex items-center gap-3 text-xs text-gray-500">
                                                        <span class="font-semibold">{{ $dissertation->department }}</span>
                                                        <span>&bull;</span>
                                                        <span>{{ $dissertation->year_completed ?? '2024' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Right Column / Side Widgets -->
                    <div class="md:col-span-4 space-y-4">
                        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                            <h3 class="text-base font-bold text-gray-900 mb-3">Join the Academic Network</h3>
                            <p class="text-sm text-gray-600 mb-5 leading-relaxed">
                                Connect with diverse institutional resources, build your research network, and access premium capabilities.
                            </p>
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="btn-premium w-full block py-2.5 text-sm text-center">Dashboard Access</a>
                                @else
                                    <a href="{{ route('login') }}" class="btn-secondary w-full block py-2 text-sm text-center mb-3">Sign in</a>
                                @endauth
                            @endif
                            <a href="{{ route('research.by-department') }}" class="text-[#26225C] font-semibold text-sm hover:underline block text-center mt-4">Browse Directory</a>
                        </div>
                        
                        <!-- Footer links in right column style -->
                        <div class="pt-4 pb-12 flex flex-wrap gap-x-4 gap-y-2 justify-center">
                            <a href="#" class="text-xs font-semibold text-gray-500 hover:text-[#26225C] hover:underline">About</a>
                            <a href="#" class="text-xs font-semibold text-gray-500 hover:text-[#26225C] hover:underline">Accessibility</a>
                            <a href="#" class="text-xs font-semibold text-gray-500 hover:text-[#26225C] hover:underline">User Agreement</a>
                            <a href="#" class="text-xs font-semibold text-gray-500 hover:text-[#26225C] hover:underline">Privacy Policy</a>
                            <div class="w-full text-center mt-2 flex items-center justify-center gap-1.5">
                                <span class="font-bold text-[#26225C] text-xs">USPF Archive</span>
                                <span class="text-xs text-gray-500">&copy; {{ date('Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            @else
                <!-- Empty State / No Results -->
                <div class="bg-white border border-gray-200 rounded-xl p-12 text-center shadow-sm max-w-3xl mx-auto">
                    @if(!empty($searchQuery))
                        <h3 class="text-xl font-bold text-gray-900 mb-2">No matching publications found</h3>
                        <p class="text-gray-600 mb-6">We couldn't find any research matching "<span class="font-semibold">{{ $searchQuery }}</span>"</p>
                        <a href="{{ route('welcome') }}" class="btn-secondary px-6 py-2">Clear search</a>
                    @else
                        <h3 class="text-xl font-bold text-gray-900 mb-2">No publications available yet</h3>
                        <p class="text-gray-600">Check back later for newly approved research publications.</p>
                    @endif
                </div>
            @endif
        </div>
    </main>

    <!-- Mobile Menu script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const hamburgerIcon = mobileMenuButton.querySelector('svg');
            
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
            
            // Search functionality
            const searchInput = document.getElementById('search-input');
            const searchForm = document.getElementById('search-form');
            const clearButton = document.getElementById('clear-search');
            const searchIcon = document.getElementById('search-icon');
            const loadingSpinner = document.getElementById('loading-spinner');
            let isSearching = false;

            function showLoading() {
                if (searchIcon) searchIcon.classList.add('hidden');
                if (loadingSpinner) loadingSpinner.classList.remove('hidden');
                isSearching = true;
            }

            if (clearButton) {
                clearButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    searchInput.value = '';
                    window.location.href = '{{ route("welcome") }}';
                });
            }

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const query = this.value.trim();
                    if (clearButton) {
                        clearButton.classList.toggle('hidden', query.length === 0);
                    }
                });
            }

            if (searchForm) {
                searchForm.addEventListener('submit', function(e) {
                    if (!isSearching) showLoading();
                    else e.preventDefault();
                });
            }
        });
    </script>
</body>
</html>