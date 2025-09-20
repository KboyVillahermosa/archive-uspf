<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Dissertation Details
                </h2>
                <p class="text-sm text-gray-600 mt-1">{{ $dissertation->department }} • {{ $dissertation->year_completed }}</p>
            </div>
            <div class="flex space-x-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Doctoral Dissertation
                </span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    Approved
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Title & Basic Info -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $dissertation->title }}</h1>
                            
                            <div class="flex flex-wrap items-center gap-4 mb-6">
                                <div class="flex items-center text-gray-600">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span class="font-medium">Author:</span>
                                    <span class="ml-2">{{ $dissertation->author }}</span>
                                </div>
                                
                                <div class="flex items-center text-gray-600">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>Completed {{ $dissertation->year_completed }}</span>
                                </div>
                            </div>

                            <!-- Department & Academic Level -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h3 class="font-medium text-gray-700 mb-1">Department</h3>
                                    <p class="text-gray-900">{{ $dissertation->department }}</p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h3 class="font-medium text-gray-700 mb-1">Academic Level</h3>
                                    <p class="text-gray-900">Doctoral Degree</p>
                                </div>
                            </div>

                            <!-- Abstract -->
                            <div class="mb-6">
                                <h3 class="text-xl font-semibold text-gray-900 mb-3">Abstract</h3>
                                <div class="prose max-w-none text-gray-700 leading-relaxed">
                                    {{ $dissertation->abstract }}
                                </div>
                            </div>

                            <!-- Keywords -->
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-3">Keywords</h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach(explode(',', $dissertation->keywords) as $keyword)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                            {{ trim($keyword) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            <!-- Cited By Section -->
                            <div class="mt-8">
                                <h3 class="text-lg font-semibold text-gray-800 mb-3">Cited By</h3>
                                @if(isset($citedBy) && $citedBy->count())
                                    <ul class="space-y-2">
                                        @foreach($citedBy as $citation)
                                            <li class="border-b pb-2">
                                                <span class="font-medium capitalize">{{ $citation->citing_research_type }}</span>:
                                                {{ $citation->citing_research_title }}
                                                <span class="text-xs text-gray-500">(by {{ optional($citation->citingUser)->name }})</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="text-gray-500">No citations yet.</div>
                                @endif
                            </div>

                            <!-- Citations Section -->
                            <div class="mt-8">
                                <h3 class="text-lg font-semibold text-gray-800 mb-3">Citations</h3>
                                @if(isset($citations) && $citations->count())
                                    <ul class="space-y-2">
                                        @foreach($citations as $citation)
                                            <li class="border-b pb-2">
                                                <span class="font-medium capitalize">{{ $citation->cited_research_type }}</span>:
                                                {{ $citation->cited_research_title }}
                                                <span class="text-xs text-gray-500">(by {{ optional($citation->citedUser)->name ?? 'N/A' }})</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="text-gray-500">No references cited.</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Citation -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">How to Cite</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-700 font-mono">
                                    {{ $dissertation->author }} ({{ $dissertation->year_completed }}). <em>{{ $dissertation->title }}</em> (Doctoral dissertation). 
                                    {{ $dissertation->department }}, University of Southern Philippines Foundation. 
                                    Retrieved from {{ url()->current() }}
                                </p>
                                <button onclick="copyToClipboard()" class="mt-2 text-sm text-red-600 hover:text-red-800">
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
                                    <h4 class="font-medium text-gray-800 mb-2">References cited in this dissertation</h4>
                                    <p class="text-sm text-gray-600 mb-4">Research papers and sources that were referenced by this dissertation.</p>
                                </div>
                                <div id="cited-research-list">
                                    <div class="text-center py-4">
                                        <div class="inline-flex items-center">
                                            <svg class="animate-spin h-4 w-4 mr-2 text-red-600" fill="none" viewBox="0 0 24 24">
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
                                    <h4 class="font-medium text-gray-800 mb-2">Research that references this dissertation</h4>
                                    <p class="text-sm text-gray-600 mb-4">Other research papers that have cited this dissertation in their studies.</p>
                                </div>
                                <div id="citing-research-list">
                                    <div class="text-center py-4">
                                        <div class="inline-flex items-center">
                                            <svg class="animate-spin h-4 w-4 mr-2 text-red-600" fill="none" viewBox="0 0 24 24">
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
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Document Access</h3>
                            <div class="space-y-3">
                                @if($dissertation->document_file)
                                    <a href="{{ route('dissertation.download-survey', $dissertation->id) }}" 
                                       class="mp-form flex items-center justify-center w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200"
                                       data-target="downloadModal">
                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Download Dissertation
                                    </a>
                                @endif
                                
                                <button onclick="shareResearch()" class="flex items-center justify-center w-full px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition duration-200">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                                    </svg>
                                    Share Dissertation
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Document Information -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Document Info</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Type</span>
                                    <span class="font-semibold text-gray-900">Doctoral Dissertation</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Year Completed</span>
                                    <span class="font-semibold text-gray-900">{{ $dissertation->year_completed }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Department</span>
                                    <span class="font-semibold text-gray-900 text-right text-sm">{{ $dissertation->department }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Published</span>
                                    <span class="font-semibold text-gray-900">{{ $dissertation->approved_at->diffForHumans() }}</span>
                                </div>
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
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="text-gray-600 flex items-center">
                                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Citations
                                    </span>
                                    <span class="font-semibold text-gray-900">{{ rand(5, 50) }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-gray-600 flex items-center">
                                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Published
                                    </span>
                                    <span class="font-semibold text-gray-900">{{ $dissertation->approved_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Author Information -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Author</h3>
                            <div class="flex items-center">
                                <div class="h-12 w-12 bg-red-100 rounded-full flex items-center justify-center">
                                    <span class="text-red-600 font-medium text-lg">
                                        {{ substr($dissertation->author, 0, 2) }}
                                    </span>
                                </div>
                                <div class="ml-3">
                                    <p class="font-medium text-gray-900">{{ $dissertation->author }}</p>
                                    <p class="text-sm text-gray-600">Doctoral Graduate</p>
                                    <p class="text-sm text-gray-600">{{ $dissertation->department }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Back to Dashboard -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <a href="{{ route('dashboard') }}" 
                               class="flex items-center justify-center w-full px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition duration-200">
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
                    title: '{{ $dissertation->title }}',
                    text: 'Check out this dissertation: {{ $dissertation->title }}',
                    url: window.location.href
                });
            } else {
                navigator.clipboard.writeText(window.location.href).then(() => {
                    const toast = document.createElement('div');
                    toast.className = 'fixed top-4 right-4 bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                    toast.textContent = 'Dissertation link copied to clipboard!';
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
                tab.classList.remove('border-red-500', 'text-red-600', 'active-tab');
                tab.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Show selected tab content
            document.getElementById(tabName + '-content').classList.remove('hidden');
            
            // Add active class to selected tab
            const activeTab = document.getElementById(tabName + '-tab');
            activeTab.classList.add('border-red-500', 'text-red-600', 'active-tab');
            activeTab.classList.remove('border-transparent', 'text-gray-500');
            
            // Load citations if not already loaded
            if (!citationsLoaded[tabName]) {
                loadCitations(tabName);
                citationsLoaded[tabName] = true;
            }
        }

        function loadCitations(type) {
            const url = type === 'cited-by' 
                ? '/my-citations' 
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
                    ? 'This dissertation has not cited any other research in our database.'
                    : 'No other research has cited this dissertation yet.';
                    
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
