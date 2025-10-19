<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    Faculty Research Details
                </h2>
                <p class="text-sm text-gray-600 mt-1">{{ $research->department }}</p>
            </div>
            <div class="flex space-x-3">
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-purple-100 text-purple-600 border border-purple-200">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                    Faculty Research
                </span>
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-green-100 text-green-600 border border-green-200">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Approved
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Research Banner -->
            @if($research->banner_image)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-8">
                    <div class="relative h-64">
                        <img src="{{ asset('storage/' . $research->banner_image) }}" alt="Research Banner" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent">
                            <div class="absolute bottom-6 left-6 right-6">
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-purple-600/90 text-white mb-3">
                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                    </svg>
                                    Faculty Research
                                </span>
                                <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">{{ $research->title }}</h1>
                                <p class="text-white/90 text-sm">By: {{ $research->user->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Title & Basic Info (when no banner) -->
                    @if(!$research->banner_image)
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                            <div class="bg-gradient-to-r from-purple-50 to-purple-100 px-8 py-6 border-b border-gray-100">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $research->title }}</h1>
                                        <p class="text-gray-600">Faculty Research • {{ $research->approved_at->format('Y') }}</p>
                                    </div>
                                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="p-8">
                                <div class="flex flex-wrap items-center gap-6 mb-8">
                                    <div class="flex items-center text-gray-600">
                                        <div class="p-2 bg-purple-100 rounded-lg mr-3">
                                            <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Lead Researcher</span>
                                            <p class="font-semibold text-gray-900">{{ $research->user->name }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center text-gray-600">
                                        <div class="p-2 bg-purple-100 rounded-lg mr-3">
                                            <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V5a2 2 0 012-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Published</span>
                                            <p class="font-semibold text-gray-900">{{ $research->approved_at->format('F j, Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Research Details -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-slate-50 to-gray-50 px-8 py-6 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">Research Details</h3>
                                    <p class="text-gray-600 text-sm">Comprehensive research information</p>
                                </div>
                                <div class="w-12 h-12 bg-slate-500 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="p-8">
                            @if($research->banner_image)
                                <div class="flex flex-wrap items-center gap-4 mb-6 text-sm text-gray-600">
                                    <div class="flex items-center">
                                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>Published: {{ $research->approved_at->format('F j, Y') }}</span>
                                    </div>
                                </div>
                            @endif

                            <!-- Department & Co-Researchers -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-6 rounded-xl border border-gray-200">
                                    <div class="flex items-center mb-3">
                                        <div class="p-2 bg-purple-100 rounded-lg mr-3">
                                            <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                        </div>
                                        <h3 class="font-semibold text-gray-700">Department</h3>
                                    </div>
                                    <p class="text-gray-900 font-medium">{{ $research->department }}</p>
                                </div>
                                @if($research->co_researchers)
                                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-6 rounded-xl border border-gray-200">
                                        <div class="flex items-center mb-3">
                                            <div class="p-2 bg-purple-100 rounded-lg mr-3">
                                                <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                            </div>
                                            <h3 class="font-semibold text-gray-700">Co-Researchers</h3>
                                        </div>
                                        <p class="text-gray-900 font-medium">{{ $research->co_researchers }}</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Abstract -->
                            <div class="mb-8">
                                <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                                    <div class="p-2 bg-purple-100 rounded-lg mr-3">
                                        <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    Abstract
                                </h3>
                                <div class="prose max-w-none text-gray-700 leading-relaxed bg-gray-50 p-6 rounded-xl border border-gray-200">
                                    {{ $research->abstract }}
                                </div>
                            </div>

                            <!-- Tags -->
                            @if($research->tags)
                                <div class="mb-8">
                                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                        <div class="p-2 bg-purple-100 rounded-lg mr-3">
                                            <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                            </svg>
                                        </div>
                                        Research Keywords
                                    </h3>
                                    <div class="flex flex-wrap gap-3">
                                        @foreach(explode(',', $research->tags) as $tag)
                                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-purple-100 text-purple-600 border border-purple-200 hover:bg-purple-200 transition-colors">
                                                {{ trim($tag) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Citation -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-slate-50 to-gray-50 px-8 py-6 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">How to Cite</h3>
                                    <p class="text-gray-600 text-sm">Academic citation format</p>
                                </div>
                                <div class="w-12 h-12 bg-slate-500 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v6a2 2 0 002 2h2m2-2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2m-4 12h8m0 0V9a2 2 0 00-2-2H8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="p-8">
                            <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-6 rounded-xl border-l-4 border-purple-500">
                                <p class="text-sm text-gray-700 font-mono mb-4 leading-relaxed">
                                    {{ $research->user->name }}{{ $research->co_researchers ? ', ' . $research->co_researchers : '' }} ({{ $research->approved_at->format('Y') }}). <em>{{ $research->title }}</em>. 
                                    {{ $research->department }}, University of Southern Philippines Foundation. 
                                    Retrieved from {{ url()->current() }}
                                </p>
                                <button onclick="copyToClipboard()" class="inline-flex items-center px-4 py-2 text-sm text-purple-600 hover:text-purple-800 hover:bg-purple-100 rounded-lg transition-all duration-200 font-semibold">
                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                    Copy Citation
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Research Citations & References -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-slate-50 to-gray-50 px-8 py-6 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2 flex items-center">
                                        <svg class="h-6 w-6 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                        </svg>
                                        Research Network
                                    </h3>
                                    <p class="text-gray-600 text-sm">Citations and references</p>
                                </div>
                                <div class="w-12 h-12 bg-slate-500 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="p-8">
                            <!-- Tab Navigation -->
                            <div class="border-b border-gray-200 mb-6">
                                <nav class="-mb-px flex space-x-8">
                                    <button onclick="showTab('cited-by')" id="cited-by-tab" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-3 px-1 border-b-2 font-semibold text-sm active-tab">
                                        Cited by this Research
                                    </button>
                                    <button onclick="showTab('cites-this')" id="cites-this-tab" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-3 px-1 border-b-2 font-semibold text-sm">
                                        Research that cites this
                                    </button>
                                </nav>
                            </div>

                            <!-- Cited by this Research Tab -->
                            <div id="cited-by-content" class="tab-content">
                                <div class="mb-6">
                                    <h4 class="font-bold text-gray-800 mb-2">References cited in this research</h4>
                                    <p class="text-sm text-gray-600 mb-4">Research papers and sources that were referenced by this work.</p>
                                </div>
                                <div id="cited-research-list">
                                    <div class="text-center py-8">
                                        <div class="inline-flex items-center">
                                            <svg class="animate-spin h-6 w-6 mr-3 text-purple-600" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <span class="text-sm text-gray-600 font-medium">Loading citations...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Research that cites this Tab -->
                            <div id="cites-this-content" class="tab-content hidden">
                                <div class="mb-6">
                                    <h4 class="font-bold text-gray-800 mb-2">Research that references this work</h4>
                                    <p class="text-sm text-gray-600 mb-4">Other research papers that have cited this work in their studies.</p>
                                </div>
                                <div id="citing-research-list">
                                    <div class="text-center py-8">
                                        <div class="inline-flex items-center">
                                            <svg class="animate-spin h-6 w-6 mr-3 text-purple-600" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <span class="text-sm text-gray-600 font-medium">Loading citations...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-8">
                    <!-- Quick Actions -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-50 to-purple-100 px-6 py-4 border-b border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900">Quick Actions</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                @if($research->research_file)
                                    <a href="{{ route('faculty.download-survey', $research->id) }}" 
                                       class="mp-form flex items-center justify-center w-full px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white font-semibold rounded-xl transition-all duration-300 hover:shadow-lg hover:-translate-y-1"
                                       data-target="downloadModal">
                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Download Full Paper
                                    </a>
                                @endif
                                
                                <button onclick="shareResearch()" class="flex items-center justify-center w-full px-6 py-3 bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 text-gray-700 font-semibold rounded-xl transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                                    </svg>
                                    Share Research
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Research Statistics -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-slate-50 to-gray-50 px-6 py-4 border-b border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900">Statistics</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                    <span class="text-gray-600 font-medium flex items-center">
                                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Views
                                    </span>
                                    <span class="font-bold text-gray-900 text-xl">{{ $viewCount }}</span>
                                </div>
                                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                    <span class="text-gray-600 font-medium flex items-center">
                                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Downloads
                                    </span>
                                    <span class="font-bold text-gray-900 text-xl">{{ $downloadCount }}</span>
                                </div>
                                <div class="flex justify-between items-center py-3">
                                    <span class="text-gray-600 font-medium flex items-center">
                                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Published
                                    </span>
                                    <span class="font-bold text-gray-900 text-xl">{{ $research->approved_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Research Team -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-50 to-purple-100 px-6 py-4 border-b border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900">Research Team</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <div class="h-12 w-12 bg-gradient-to-br from-purple-100 to-purple-200 rounded-xl flex items-center justify-center">
                                        <span class="text-purple-600 font-bold text-lg">
                                            {{ substr($research->user->name, 0, 2) }}
                                        </span>
                                    </div>
                                    <div class="ml-4">
                                        <p class="font-bold text-gray-900">{{ $research->user->name }}</p>
                                        <p class="text-sm text-gray-600 font-medium">Lead Researcher</p>
                                    </div>
                                </div>
                                @if($research->co_researchers)
                                    @foreach(explode(',', $research->co_researchers) as $coResearcher)
                                        <div class="flex items-center">
                                            <div class="h-12 w-12 bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl flex items-center justify-center">
                                                <span class="text-gray-600 font-bold text-lg">
                                                    {{ substr(trim($coResearcher), 0, 2) }}
                                                </span>
                                            </div>
                                            <div class="ml-4">
                                                <p class="font-bold text-gray-900">{{ trim($coResearcher) }}</p>
                                                <p class="text-sm text-gray-600 font-medium">Co-Researcher</p>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Back to Dashboard -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="p-6">
                            <a href="{{ route('dashboard') }}" 
                               class="flex items-center justify-center w-full px-6 py-3 bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 text-gray-700 font-semibold rounded-xl transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Back to Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Download Modal -->
    <div id="downloadModal" class="modal fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4">
            <div class="modal-content">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard() {
            const citation = document.querySelector('.font-mono').textContent;
            navigator.clipboard.writeText(citation).then(() => {
                const toast = document.createElement('div');
                toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg z-50 font-semibold';
                toast.textContent = 'Citation copied to clipboard!';
                document.body.appendChild(toast);
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 3000);
            });
        }

        function shareResearch() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $research->title }}',
                    text: 'Check out this faculty research: {{ $research->title }}',
                    url: window.location.href
                });
            } else {
                navigator.clipboard.writeText(window.location.href).then(() => {
                    const toast = document.createElement('div');
                    toast.className = 'fixed top-4 right-4 bg-blue-500 text-white px-6 py-3 rounded-xl shadow-lg z-50 font-semibold';
                    toast.textContent = 'Research link copied to clipboard!';
                    document.body.appendChild(toast);
                    setTimeout(() => {
                        document.body.removeChild(toast);
                    }, 3000);
                });
            }
        }

        // Citations functionality
        let citationsLoaded = {
            'cited-by': false,
            'cites-this': false
        };

        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Remove active class from all tabs
            document.querySelectorAll('[id$="-tab"]').forEach(tab => {
                tab.classList.remove('border-purple-500', 'text-purple-600', 'active-tab');
                tab.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Show selected tab content
            document.getElementById(tabName + '-content').classList.remove('hidden');
            
            // Add active class to selected tab
            const activeTab = document.getElementById(tabName + '-tab');
            activeTab.classList.add('border-purple-500', 'text-purple-600', 'active-tab');
            activeTab.classList.remove('border-transparent', 'text-gray-500');
            
            // Load citations if not already loaded
            if (!citationsLoaded[tabName]) {
                loadCitations(tabName);
                citationsLoaded[tabName] = true;
            }
        }

        function loadCitations(type) {
            const url = type === 'cited-by' 
                ? '/my-citations?filter=citing_research_title:{{ urlencode($research->title) }}' 
                : '/research-citations/faculty/{{ $research->id }}';
            
            const container = type === 'cited-by' 
                ? document.getElementById('cited-research-list')
                : document.getElementById('citing-research-list');

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    displayCitations(data, container, type);
                })
                .catch(error => {
                    console.error('Error loading citations:', error);
                    container.innerHTML = `
                        <div class="text-center py-8 text-gray-500">
                            <svg class="mx-auto h-8 w-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-sm">Error loading citations</p>
                        </div>
                    `;
                });
        }

        function displayCitations(citations, container, type) {
            if (citations.length === 0) {
                const message = type === 'cited-by' 
                    ? 'This research has not cited any other research in our database.'
                    : 'No other research has cited this work yet.';
                    
                container.innerHTML = `
                    <div class="text-center py-8 text-gray-500">
                        <svg class="mx-auto h-8 w-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                        <p class="text-sm">${message}</p>
                    </div>
                `;
                return;
            }

            const citationsList = citations.map(citation => {
                const typeColors = {
                    'student': 'blue',
                    'faculty': 'purple', 
                    'thesis': 'green',
                    'dissertation': 'red'
                };
                
                const typeName = citation.citing_type || citation.cited_type || 'research';
                const color = typeColors[typeName] || 'gray';
                const title = citation.citing_title || citation.cited_title || 'Unknown Title';
                const user = citation.citing_user || citation.cited_authors || 'Unknown Author';
                const context = citation.citation_context || '';
                const date = citation.created_at || '';

                return `
                    <div class="border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 cursor-pointer bg-gradient-to-br from-white to-gray-50" onclick="viewResearch('${typeName}', ${citation.cited_research_id || citation.citing_research_id || 'null'})">
                        <div class="flex items-start justify-between mb-3">
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-${color}-100 text-${color}-600 border border-${color}-200">
                                ${typeName.charAt(0).toUpperCase() + typeName.slice(1)} Research
                            </span>
                            <span class="text-xs text-gray-500 font-medium">${date}</span>
                        </div>
                        <h5 class="font-bold text-gray-900 mb-2 text-lg">${title}</h5>
                        ${type === 'cites-this' ? `<p class="text-sm text-gray-600 mb-3 font-medium">By: ${user}</p>` : ''}
                        ${context ? `
                            <div class="bg-gray-50 p-4 rounded-lg mt-3 border border-gray-200">
                                <p class="text-xs text-gray-700 font-medium"><strong>Context:</strong> ${context}</p>
                            </div>
                        ` : ''}
                    </div>
                `;
            }).join('');

            container.innerHTML = `<div class="space-y-4">${citationsList}</div>`;
        }

        // Initialize with first tab active
        document.addEventListener('DOMContentLoaded', function() {
            showTab('cited-by');
        });

        function viewResearch(type, id) {
            if (!id || id === 'null' || id === 'undefined') {
                console.error('No research ID provided');
                alert('Unable to open research details. Research ID not available.');
                return;
            }
            
            let url = '';
            switch(type) {
                case 'student':
                    url = `/research/student/${id}`;
                    break;
                case 'faculty':
                    url = `/research/faculty/${id}`;
                    break;
                case 'thesis':
                    url = `/research/thesis/${id}`;
                    break;
                case 'dissertation':
                    url = `/research/dissertation/${id}`;
                    break;
                default:
                    console.error('Unknown research type:', type);
                    return;
            }
            
            window.open(url, '_blank');
        }
    </script>
</x-app-layout>