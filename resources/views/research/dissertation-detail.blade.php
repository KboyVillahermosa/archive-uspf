<x-app-layout>
    <style>
        /* Skeleton Loader Styles */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: skeleton-loading 1.5s ease-in-out infinite;
            border-radius: 4px;
        }
        
        @keyframes skeleton-loading {
            0% {
                background-position: 200% 0;
            }
            100% {
                background-position: -200% 0;
            }
        }
        
        .skeleton-text {
            height: 1rem;
            margin-bottom: 0.5rem;
        }
        
        .skeleton-title {
            height: 1.5rem;
            width: 60%;
            margin-bottom: 0.75rem;
        }
        
        .skeleton-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 1.5rem;
        }
        
        .skeleton-container {
            display: block;
        }
        
        .content-container {
            display: none;
        }
        
        .content-container.loaded {
            display: block;
        }
        
        .skeleton-container.loaded {
            display: none;
        }
    </style>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            <!-- Skeleton Loader for Main Content -->
            <div class="skeleton-container main-content-skeleton">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 space-y-8">
                        <!-- Basic Info Skeleton -->
                        <div class="skeleton-card mb-8">
                            <div class="flex flex-wrap items-center gap-6">
                                <div class="skeleton skeleton-text w-32 h-6"></div>
                                <div class="skeleton skeleton-text w-32 h-6"></div>
                            </div>
                        </div>
                        <!-- Research Details Skeleton -->
                        <div class="skeleton-card mb-8">
                            <div class="skeleton skeleton-title mb-4"></div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div class="skeleton h-24 rounded-lg"></div>
                                <div class="skeleton h-24 rounded-lg"></div>
                            </div>
                            <div class="skeleton h-32 rounded-lg mb-4"></div>
                            <div class="flex gap-3">
                                <div class="skeleton h-8 w-20 rounded-full"></div>
                                <div class="skeleton h-8 w-24 rounded-full"></div>
                                <div class="skeleton h-8 w-16 rounded-full"></div>
                            </div>
                        </div>
                        <!-- Citation Skeleton -->
                        <div class="skeleton-card mb-8">
                            <div class="skeleton skeleton-title mb-4"></div>
                            <div class="skeleton h-20 rounded-lg"></div>
                        </div>
                    </div>
                    <!-- Sidebar Skeleton -->
                    <div class="space-y-8">
                        <div class="skeleton-card">
                            <div class="skeleton skeleton-title mb-4"></div>
                            <div class="skeleton h-12 rounded-xl mb-3"></div>
                            <div class="skeleton h-12 rounded-xl"></div>
                        </div>
                        <div class="skeleton-card">
                            <div class="skeleton skeleton-title mb-4"></div>
                            <div class="space-y-3">
                                <div class="skeleton h-8"></div>
                                <div class="skeleton h-8"></div>
                                <div class="skeleton h-8"></div>
                            </div>
                        </div>
                        <div class="skeleton-card">
                            <div class="skeleton skeleton-title mb-4"></div>
                            <div class="flex items-center">
                                <div class="skeleton w-16 h-16 rounded-xl mr-4"></div>
                                <div class="flex-1">
                                    <div class="skeleton h-5 w-32 mb-2"></div>
                                    <div class="skeleton h-4 w-40 mb-1"></div>
                                    <div class="skeleton h-4 w-24"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-container main-content-content">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Basic Info -->
                    <section class="mb-8">
                        <div class="flex flex-wrap items-center gap-6">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-[#26225C] bg-opacity-10 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="h-5 w-5 text-[#26225C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Author</span>
                                    <p class="font-semibold text-[#26225C]">{{ $dissertation->author }}</p>
                                </div>
                            </div>
                            
                            @if($dissertation->approved_at)
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-[#26225C] bg-opacity-10 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="h-5 w-5 text-[#26225C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Published</span>
                                    <p class="font-semibold text-[#26225C]">{{ $dissertation->approved_at ? $dissertation->approved_at->format('F j, Y') : 'N/A' }}</p>
                                </div>
                            </div>
                            @endif

                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-[#26225C] bg-opacity-10 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="h-5 w-5 text-[#26225C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V5a2 2 0 012-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Year Completed</span>
                                    <p class="font-semibold text-[#26225C]">{{ $dissertation->year_completed }}</p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Research Details -->
                    <section class="mb-8">
                        <div class="mb-6">
                            <h3 class="text-2xl font-light text-[#26225C] mb-1">Research Details</h3>
                            <p class="text-sm text-gray-500">Comprehensive research information</p>
                        </div>
                        <div>
                            <!-- Department & Academic Level -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                                <div class="p-6 border-l-4 border-[#FFC72C] bg-gray-50 rounded-lg">
                                    <div class="flex items-center mb-3">
                                        <div class="w-10 h-10 bg-[#26225C] bg-opacity-10 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="h-5 w-5 text-[#26225C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                        </div>
                                        <h3 class="font-semibold text-[#26225C]">Department</h3>
                                    </div>
                                    <p class="text-gray-700 font-medium">{{ $dissertation->department }}</p>
                                </div>
                                <div class="p-6 border-l-4 border-[#FFC72C] bg-gray-50 rounded-lg">
                                    <div class="flex items-center mb-3">
                                        <div class="w-10 h-10 bg-[#26225C] bg-opacity-10 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="h-5 w-5 text-[#26225C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                            </svg>
                                        </div>
                                        <h3 class="font-semibold text-[#26225C]">Academic Level</h3>
                                    </div>
                                    <p class="text-gray-700 font-medium">Doctoral Degree</p>
                                </div>
                            </div>

                            <!-- Abstract -->
                            <div class="mb-8">
                                <h3 class="text-xl font-semibold text-[#26225C] mb-4">Abstract</h3>
                                <div class="prose max-w-none text-gray-700 leading-relaxed bg-gray-50 p-6 rounded-lg border-l-4 border-[#FFC72C]">
                                    {{ $dissertation->abstract }}
                                </div>
                            </div>

                            <!-- Keywords -->
                            @if($dissertation->keywords)
                            <div class="mb-8">
                                <h3 class="text-lg font-semibold text-[#26225C] mb-4">Keywords</h3>
                                <div class="flex flex-wrap gap-3">
                                    @foreach(explode(',', $dissertation->keywords) as $tag)
                                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-[#26225C] bg-opacity-10 text-[#26225C] border border-[#FFC72C] border-opacity-30">
                                            {{ trim($tag) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </section>

                    <!-- Citation -->
                    <section class="mb-8">
                        <div class="mb-6">
                            <h3 class="text-2xl font-light text-[#26225C] mb-1">How to Cite</h3>
                            <p class="text-sm text-gray-500">Multiple academic citation formats</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg border-l-4 border-[#FFC72C] overflow-hidden">
                            <!-- Citation Format Tabs -->
                            <div class="border-b border-gray-200 bg-white">
                                <nav class="flex overflow-x-auto -mb-px" style="scrollbar-width: thin;">
                                    <button onclick="showCitationFormat('apa')" id="citation-tab-apa" class="citation-tab border-transparent text-gray-500 hover:text-[#26225C] hover:border-[#FFC72C] whitespace-nowrap py-3 px-4 border-b-2 font-medium text-sm active-citation-tab">
                                        APA
                                    </button>
                                    <button onclick="showCitationFormat('mla')" id="citation-tab-mla" class="citation-tab border-transparent text-gray-500 hover:text-[#26225C] hover:border-[#FFC72C] whitespace-nowrap py-3 px-4 border-b-2 font-medium text-sm">
                                        MLA
                                    </button>
                                    <button onclick="showCitationFormat('chicago')" id="citation-tab-chicago" class="citation-tab border-transparent text-gray-500 hover:text-[#26225C] hover:border-[#FFC72C] whitespace-nowrap py-3 px-4 border-b-2 font-medium text-sm">
                                        Chicago
                                    </button>
                                    <button onclick="showCitationFormat('harvard')" id="citation-tab-harvard" class="citation-tab border-transparent text-gray-500 hover:text-[#26225C] hover:border-[#FFC72C] whitespace-nowrap py-3 px-4 border-b-2 font-medium text-sm">
                                        Harvard
                                    </button>
                                    <button onclick="showCitationFormat('ieee')" id="citation-tab-ieee" class="citation-tab border-transparent text-gray-500 hover:text-[#26225C] hover:border-[#FFC72C] whitespace-nowrap py-3 px-4 border-b-2 font-medium text-sm">
                                        IEEE
                                    </button>
                                    <button onclick="showCitationFormat('vancouver')" id="citation-tab-vancouver" class="citation-tab border-transparent text-gray-500 hover:text-[#26225C] hover:border-[#FFC72C] whitespace-nowrap py-3 px-4 border-b-2 font-medium text-sm">
                                        Vancouver
                                    </button>
                                </nav>
                            </div>

                            <!-- Citation Content -->
                            <div class="p-6">
                                @php
                                    $year = $dissertation->approved_at ? $dissertation->approved_at->format('Y') : $dissertation->year_completed;
                                    $date = $dissertation->approved_at ? $dissertation->approved_at->format('d M. Y') : date('d M. Y', strtotime($dissertation->year_completed . '-01-01'));
                                @endphp

                                <!-- APA Format -->
                                <div id="citation-content-apa" class="citation-content">
                                    <p class="text-sm text-gray-700 font-mono mb-4 leading-relaxed">
                                        {{ $dissertation->author }} ({{ $year }}). <em>{{ $dissertation->title }}</em> (Doctoral dissertation). 
                                        {{ $dissertation->department }}, University of Southern Philippines Foundation. 
                                        Retrieved from {{ url()->current() }}
                                    </p>
                                </div>

                                <!-- MLA Format -->
                                <div id="citation-content-mla" class="citation-content hidden">
                                    <p class="text-sm text-gray-700 font-mono mb-4 leading-relaxed">
                                        {{ $dissertation->author }}. "{{ $dissertation->title }}." Doctoral dissertation, University of Southern Philippines Foundation, 
                                        {{ $dissertation->department }}, {{ $date }}, 
                                        {{ url()->current() }}.
                                    </p>
                                </div>

                                <!-- Chicago Format -->
                                <div id="citation-content-chicago" class="citation-content hidden">
                                    <p class="text-sm text-gray-700 font-mono mb-4 leading-relaxed">
                                        {{ $dissertation->author }}. "{{ $dissertation->title }}." Doctoral dissertation, {{ $dissertation->department }}, 
                                        University of Southern Philippines Foundation, {{ $year }}. 
                                        {{ url()->current() }}.
                                    </p>
                                </div>

                                <!-- Harvard Format -->
                                <div id="citation-content-harvard" class="citation-content hidden">
                                    <p class="text-sm text-gray-700 font-mono mb-4 leading-relaxed">
                                        {{ $dissertation->author }} {{ $year }}, <em>{{ $dissertation->title }}</em>, Doctoral dissertation, University of Southern Philippines Foundation, 
                                        {{ $dissertation->department }}, viewed {{ date('d M Y') }}, &lt;{{ url()->current() }}&gt;.
                                    </p>
                                </div>

                                <!-- IEEE Format -->
                                <div id="citation-content-ieee" class="citation-content hidden">
                                    <p class="text-sm text-gray-700 font-mono mb-4 leading-relaxed">
                                        {{ $dissertation->author }}, "{{ $dissertation->title }}," Doctoral dissertation, University of Southern Philippines Foundation, 
                                        {{ $dissertation->department }}, {{ $year }}. 
                                        [Online]. Available: {{ url()->current() }}
                                    </p>
                                </div>

                                <!-- Vancouver Format -->
                                <div id="citation-content-vancouver" class="citation-content hidden">
                                    <p class="text-sm text-gray-700 font-mono mb-4 leading-relaxed">
                                        {{ $dissertation->author }}. {{ $dissertation->title }}. Doctoral dissertation. University of Southern Philippines Foundation; 
                                        {{ $year }}. 
                                        Available from: {{ url()->current() }}
                                    </p>
                                </div>

                                <button onclick="copyCitationToClipboard()" class="inline-flex items-center px-4 py-2 text-sm text-[#26225C] hover:text-[#FFC72C] hover:bg-[#26225C] hover:bg-opacity-5 rounded-lg transition-colors font-medium">
                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                    Copy Citation
                                </button>
                            </div>
                        </div>
                    </section>

                    <!-- Research Citations & References -->
                    <section class="mb-8">
                        <div class="mb-6">
                            <h3 class="text-2xl font-light text-[#26225C] mb-1">Research Network</h3>
                            <p class="text-sm text-gray-500">Citations and references</p>
                        </div>
                        <div>
                            <!-- Tab Navigation -->
                            <div class="border-b border-gray-200 mb-6">
                                <nav class="-mb-px flex space-x-8">
                                    <button onclick="showTab('cited-by')" id="cited-by-tab" class="border-transparent text-gray-500 hover:text-[#26225C] hover:border-[#FFC72C] whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm active-tab">
                                        Cited by this Research
                                    </button>
                                    <button onclick="showTab('cites-this')" id="cites-this-tab" class="border-transparent text-gray-500 hover:text-[#26225C] hover:border-[#FFC72C] whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm">
                                        Research that cites this
                                    </button>
                                </nav>
                            </div>

                            <!-- Cited by this Research Tab -->
                            <div id="cited-by-content" class="tab-content">
                                <div class="mb-6">
                                    <h4 class="font-semibold text-[#26225C] mb-2">References cited in this research</h4>
                                    <p class="text-sm text-gray-600 mb-4">Research papers and sources that were referenced by this work.</p>
                                </div>
                                <div id="cited-research-list">
                                    <div class="text-center py-8">
                                        <div class="inline-flex items-center">
                                            <svg class="animate-spin h-6 w-6 mr-3 text-[#26225C]" fill="none" viewBox="0 0 24 24">
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
                                    <h4 class="font-semibold text-[#26225C] mb-2">Research that references this work</h4>
                                    <p class="text-sm text-gray-600 mb-4">Other research papers that have cited this work in their studies.</p>
                                </div>
                                <div id="citing-research-list">
                                    <div class="text-center py-8">
                                        <div class="inline-flex items-center">
                                            <svg class="animate-spin h-6 w-6 mr-3 text-[#26225C]" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <span class="text-sm text-gray-600 font-medium">Loading citations...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Sidebar -->
                <div class="space-y-8">
                    <!-- Quick Actions -->
                    <section>
                        <div class="mb-4">
                            <h3 class="text-lg font-medium text-[#26225C]">Quick Actions</h3>
                        </div>
                        <div class="space-y-4">
                            @php
                                $isAdmin = false;
                                try {
                                    $isAdmin = auth()->user()->hasRole('admin') || auth()->user()->role === 'admin';
                                } catch (\Exception $e) {
                                    $isAdmin = auth()->user()->role === 'admin';
                                }
                            @endphp
                            @if($dissertation->document_file && $isAdmin)
                                <a href="{{ route('dissertation.view.pdf', $dissertation->id) }}" 
                                   target="_blank"
                                   class="flex items-center justify-center w-full px-6 py-3 bg-[#FFC72C] hover:bg-[#e6b326] text-[#26225C] font-medium rounded-xl transition-colors">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View PDF
                                </a>
                                <a href="{{ route('dissertation.download-survey', $dissertation->id) }}" 
                                   class="mp-form flex items-center justify-center w-full px-6 py-3 bg-[#26225C] hover:bg-[#3a3770] text-white font-medium rounded-xl transition-colors"
                                   data-target="downloadModal">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Download Full Paper
                                </a>
                            @endif
                            
                            <button onclick="shareResearch()" class="flex items-center justify-center w-full px-6 py-3 bg-gray-100 hover:bg-gray-200 text-[#26225C] font-medium rounded-xl transition-colors">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                                </svg>
                                Share Research
                            </button>
                        </div>
                    </section>

                    <!-- Research Statistics -->
                    <section>
                        <div class="mb-4">
                            <h3 class="text-lg font-medium text-[#26225C]">Statistics</h3>
                        </div>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center py-3 border-b border-gray-200">
                                <span class="text-gray-600 font-medium flex items-center">
                                    <svg class="h-4 w-4 mr-2 text-[#26225C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Views
                                </span>
                                <span class="font-semibold text-[#26225C] text-xl">{{ $viewCount }}</span>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-gray-200">
                                <span class="text-gray-600 font-medium flex items-center">
                                    <svg class="h-4 w-4 mr-2 text-[#26225C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Downloads
                                </span>
                                <span class="font-semibold text-[#26225C] text-xl">{{ $downloadCount }}</span>
                            </div>
                            @if($dissertation->approved_at)
                            <div class="flex justify-between items-center py-3">
                                <span class="text-gray-600 font-medium flex items-center">
                                    <svg class="h-4 w-4 mr-2 text-[#26225C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Published
                                </span>
                                <span class="font-semibold text-[#26225C] text-xl">{{ $dissertation->approved_at->diffForHumans() }}</span>
                            </div>
                            @endif
                        </div>
                    </section>

                    <!-- Submitted By -->
                    <section>
                        <div class="mb-4">
                            <h3 class="text-lg font-medium text-[#26225C]">Submitted By</h3>
                        </div>
                        <div class="flex items-center">
                            <div class="h-16 w-16 bg-[#26225C] bg-opacity-10 rounded-xl flex items-center justify-center">
                                <span class="text-[#26225C] font-semibold text-xl">
                                    {{ substr($dissertation->user->name ?? 'NA', 0, 2) }}
                                </span>
                            </div>
                            <div class="ml-4">
                                <p class="font-semibold text-[#26225C] text-lg">{{ $dissertation->user->name ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-600">{{ $dissertation->user->email ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-500">Research Contributor</p>
                            </div>
                        </div>
                    </section>

                    <!-- Back to Dashboard -->
                    <section>
                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center justify-center w-full px-6 py-3 bg-gray-100 hover:bg-gray-200 text-[#26225C] font-medium rounded-xl transition-colors">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Dashboard
                        </a>
                    </section>
                </div>
            </div>
            </div>
        </div>
    </div>

    <!-- Download Modal -->
    <div id="downloadModal" class="modal fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 transition-opacity duration-300 ease-in-out" style="display: none;">
        <div class="flex justify-center pt-8 px-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full transform transition-all duration-300 ease-out modal-content-wrapper">
                <div class="modal-content">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        function showCitationFormat(format) {
            // Hide all citation contents
            document.querySelectorAll('.citation-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Remove active class from all tabs
            document.querySelectorAll('.citation-tab').forEach(tab => {
                tab.classList.remove('border-[#FFC72C]', 'text-[#26225C]', 'active-citation-tab');
                tab.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Show selected citation content
            document.getElementById('citation-content-' + format).classList.remove('hidden');
            
            // Add active class to selected tab
            const activeTab = document.getElementById('citation-tab-' + format);
            activeTab.classList.add('border-[#FFC72C]', 'text-[#26225C]', 'active-citation-tab');
            activeTab.classList.remove('border-transparent', 'text-gray-500');
        }

        function copyCitationToClipboard() {
            const activeCitation = document.querySelector('.citation-content:not(.hidden) .font-mono');
            if (!activeCitation) return;
            
            const citation = activeCitation.textContent;
            navigator.clipboard.writeText(citation).then(() => {
                const toast = document.createElement('div');
                toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg z-50 font-medium';
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
                    title: '{{ $dissertation->title }}',
                    text: 'Check out this research: {{ $dissertation->title }}',
                    url: window.location.href
                });
            } else {
                navigator.clipboard.writeText(window.location.href).then(() => {
                    const toast = document.createElement('div');
                    toast.className = 'fixed top-4 right-4 bg-[#26225C] text-white px-6 py-3 rounded-xl shadow-lg z-50 font-medium';
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
                tab.classList.remove('border-[#FFC72C]', 'text-[#26225C]', 'active-tab');
                tab.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Show selected tab content
            document.getElementById(tabName + '-content').classList.remove('hidden');
            
            // Add active class to selected tab
            const activeTab = document.getElementById(tabName + '-tab');
            activeTab.classList.add('border-[#FFC72C]', 'text-[#26225C]', 'active-tab');
            activeTab.classList.remove('border-transparent', 'text-gray-500');
            
            // Load citations if not already loaded
            if (!citationsLoaded[tabName]) {
                loadCitations(tabName);
                citationsLoaded[tabName] = true;
            }
        }

        function loadCitations(type) {
            const url = type === 'cited-by' 
                ? '/my-citations?filter=citing_research_title:{{ urlencode($dissertation->title) }}' 
                : '/research-citations/dissertation/{{ $dissertation->id }}';
            
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
                const typeName = citation.citing_type || citation.cited_type || 'research';
                const title = citation.citing_title || citation.cited_title || 'Unknown Title';
                const user = citation.citing_user || citation.cited_authors || 'Unknown Author';
                const context = citation.citation_context || '';
                const date = citation.created_at || '';

                return `
                    <div class="border border-gray-200 rounded-xl p-6 hover:border-[#FFC72C] hover:shadow-lg transition-all duration-300 cursor-pointer bg-white" onclick="viewResearch('${typeName}', ${citation.cited_research_id || citation.citing_research_id || 'null'})">
                        <div class="flex items-start justify-between mb-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-[#26225C] bg-opacity-10 text-[#26225C] border border-[#FFC72C] border-opacity-30">
                                ${typeName.charAt(0).toUpperCase() + typeName.slice(1)} Research
                            </span>
                            <span class="text-xs text-gray-500 font-medium">${date}</span>
                        </div>
                        <h5 class="font-semibold text-[#26225C] mb-2 text-lg">${title}</h5>
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
            
            // Skeleton Loader Management
            function hideSkeletons() {
                document.querySelectorAll('.skeleton-container').forEach(skeleton => {
                    skeleton.classList.add('loaded');
                });
                document.querySelectorAll('.content-container').forEach(content => {
                    content.classList.add('loaded');
                });
            }
            
            // Hide skeletons when page is fully loaded
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', function() {
                    setTimeout(hideSkeletons, 500);
                });
            } else {
                setTimeout(hideSkeletons, 500);
            }
            
            window.addEventListener('load', function() {
                hideSkeletons();
            });
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
