<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Student Research Details
                </h2>
                <p class="text-sm text-gray-600 mt-1">{{ $research->department }} • {{ $research->program }}</p>
            </div>
            <div class="flex space-x-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    Student Research
                </span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    Approved
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Research Banner -->
            @if($research->banner_image)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="relative h-64">
                        <img src="{{ asset('storage/' . $research->banner_image) }}" alt="Research Banner" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent">
                            <div class="absolute bottom-6 left-6 right-6">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-600/90 text-white mb-2">
                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    Student Research
                                </span>
                                <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">{{ $research->title }}</h1>
                                <p class="text-white/90 text-sm">By: {{ $research->authors }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Title & Basic Info (when no banner) -->
                    @if(!$research->banner_image)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $research->title }}</h1>
                                <div class="flex flex-wrap items-center gap-4 mb-6">
                                    <div class="flex items-center text-gray-600">
                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <span class="font-medium">Authors:</span>
                                        <span class="ml-2">{{ $research->authors }}</span>
                                    </div>
                                    
                                    <div class="flex items-center text-gray-600">
                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>{{ $research->approved_at->format('F j, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Research Details -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
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

                            <!-- Department & Program -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex items-center mb-2">
                                        <svg class="h-5 w-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        <h3 class="font-medium text-gray-700">Department</h3>
                                    </div>
                                    <p class="text-gray-900">{{ $research->department }}</p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex items-center mb-2">
                                        <svg class="h-5 w-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                        </svg>
                                        <h3 class="font-medium text-gray-700">Program</h3>
                                    </div>
                                    <p class="text-gray-900">{{ $research->program }}</p>
                                </div>
                            </div>

                            <!-- Abstract -->
                            <div class="mb-6">
                                <h3 class="text-xl font-semibold text-gray-900 mb-3 flex items-center">
                                    <svg class="h-5 w-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Abstract
                                </h3>
                                <div class="prose max-w-none text-gray-700 leading-relaxed bg-gray-50 p-4 rounded-lg">
                                    {{ $research->abstract }}
                                </div>
                            </div>

                            <!-- Keywords -->
                            @if($research->tags)
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                                        <svg class="h-5 w-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        Keywords
                                    </h3>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach(explode(',', $research->tags) as $tag)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 hover:bg-blue-200 transition-colors">
                                                {{ trim($tag) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Citation -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                                <svg class="h-5 w-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v6a2 2 0 002 2h2m2-2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2m-4 12h8m0 0V9a2 2 0 00-2-2H8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                How to Cite
                            </h3>
                            <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-blue-500">
                                <p class="text-sm text-gray-700 font-mono mb-3">
                                    {{ $research->authors }} ({{ $research->approved_at->format('Y') }}). <em>{{ $research->title }}</em>. 
                                    {{ $research->department }}, University of Southern Philippines Foundation. 
                                    Retrieved from {{ url()->current() }}
                                </p>
                                <button onclick="copyToClipboard()" class="inline-flex items-center px-3 py-1 text-sm text-blue-600 hover:text-blue-800 hover:bg-blue-100 rounded transition-colors">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                    Copy Citation
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Research Citations & References -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="h-5 w-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                                Research Network
                            </h3>
                            
                            <!-- Tab Navigation -->
                            <div class="border-b border-gray-200 mb-4">
                                <nav class="-mb-px flex space-x-8">
                                    <button onclick="showTab('cited-by')" id="cited-by-tab" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm active-tab">
                                        Cited by this Research
                                    </button>
                                    <button onclick="showTab('cites-this')" id="cites-this-tab" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                                        Research that cites this
                                    </button>
                                </nav>
                            </div>

                            <!-- Cited by this Research Tab -->
                            <div id="cited-by-content" class="tab-content">
                                <div class="mb-4">
                                    <h4 class="font-medium text-gray-800 mb-2">References cited in this research</h4>
                                    <p class="text-sm text-gray-600 mb-4">Research papers and sources that were referenced by this work.</p>
                                </div>
                                <div id="cited-research-list">
                                    <div class="text-center py-4">
                                        <div class="inline-flex items-center">
                                            <svg class="animate-spin h-4 w-4 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <span class="text-sm text-gray-600">Loading citations...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Research that cites this Tab -->
                            <div id="cites-this-content" class="tab-content hidden">
                                <div class="mb-4">
                                    <h4 class="font-medium text-gray-800 mb-2">Research that references this work</h4>
                                    <p class="text-sm text-gray-600 mb-4">Other research papers that have cited this work in their studies.</p>
                                </div>
                                <div id="citing-research-list">
                                    <div class="text-center py-4">
                                        <div class="inline-flex items-center">
                                            <svg class="animate-spin h-4 w-4 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <span class="text-sm text-gray-600">Loading citations...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Quick Actions -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                            <div class="space-y-3">
                                @if($research->research_file)
                                    <a href="{{ route('student.download-survey', $research->id) }}" 
                                       class="mp-form flex items-center justify-center w-full px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 shadow-sm"
                                       data-target="downloadModal">
                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Download Full Paper
                                    </a>
                                @endif
                                
                                <button onclick="shareResearch()" class="flex items-center justify-center w-full px-4 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition duration-200">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                                    </svg>
                                    Share Research
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Research Statistics -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistics</h3>
                            <div class="space-y-4">
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="text-gray-600 flex items-center">
                                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Views
                                    </span>
                                    <span class="font-semibold text-gray-900">{{ $viewCount }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="text-gray-600 flex items-center">
                                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Downloads
                                    </span>
                                    <span class="font-semibold text-gray-900">{{ $downloadCount }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-gray-600 flex items-center">
                                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Published
                                    </span>
                                    <span class="font-semibold text-gray-900">{{ $research->approved_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submitted By -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Submitted By</h3>
                            <div class="flex items-center">
                                <div class="h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-blue-600 font-medium text-lg">
                                        {{ substr($research->user->name, 0, 2) }}
                                    </span>
                                </div>
                                <div class="ml-3">
                                    <p class="font-medium text-gray-900">{{ $research->user->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $research->user->email }}</p>
                                    <p class="text-xs text-gray-500">Research Contributor</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Back to Dashboard -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <a href="{{ route('dashboard') }}" 
                               class="flex items-center justify-center w-full px-4 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition duration-200">
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
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="modal-content">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard() {
            const citation = document.querySelector('.font-mono').textContent;
            navigator.clipboard.writeText(citation).then(() => {
                // Create a toast notification instead of alert
                const toast = document.createElement('div');
                toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
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
                    text: 'Check out this research: {{ $research->title }}',
                    url: window.location.href
                });
            } else {
                navigator.clipboard.writeText(window.location.href).then(() => {
                    const toast = document.createElement('div');
                    toast.className = 'fixed top-4 right-4 bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
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
                tab.classList.remove('border-blue-500', 'text-blue-600', 'active-tab');
                tab.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Show selected tab content
            document.getElementById(tabName + '-content').classList.remove('hidden');
            
            // Add active class to selected tab
            const activeTab = document.getElementById(tabName + '-tab');
            activeTab.classList.add('border-blue-500', 'text-blue-600', 'active-tab');
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
                : '/research-citations/student/{{ $research->id }}';
            
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
                const user = citation.citing_user || 'Unknown Author';
                const context = citation.citation_context || '';
                const date = citation.created_at || '';

                return `
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-${color}-100 text-${color}-800">
                                ${typeName.charAt(0).toUpperCase() + typeName.slice(1)} Research
                            </span>
                            <span class="text-xs text-gray-500">${date}</span>
                        </div>
                        <h5 class="font-medium text-gray-900 mb-1">${title}</h5>
                        ${type === 'cites-this' ? `<p class="text-sm text-gray-600 mb-2">By: ${user}</p>` : ''}
                        ${context ? `
                            <div class="bg-gray-50 p-3 rounded mt-2">
                                <p class="text-xs text-gray-700"><strong>Context:</strong> ${context}</p>
                            </div>
                        ` : ''}
                    </div>
                `;
            }).join('');

            container.innerHTML = `<div class="space-y-3">${citationsList}</div>`;
        }

        // Initialize with first tab active
        document.addEventListener('DOMContentLoaded', function() {
            showTab('cited-by');
        });
    </script>
</x-app-layout>
