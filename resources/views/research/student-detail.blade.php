<x-app-layout>
    <div class="min-h-screen bg-[#f3f2ef]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            
            <!-- Main Content Grid -->
            <div class="flex flex-col lg:flex-row gap-6">
                
                <!-- Left/Main Column -->
                <div class="flex-1 space-y-4">
                    
                    <!-- Research Identity Card (LinkedIn Header Style) -->
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                        <!-- Banner/Cover -->
                        <div class="h-max bg-[#26225C] relative">
                             @if($research->banner_image)
                                <img src="{{ asset('storage/' . $research->banner_image) }}" alt="Research Banner" class="w-full h-48 object-cover opacity-80">
                            @else
                                <div class="h-32 bg-gradient-to-r from-[#26225C] to-[#3a3770] opacity-90"></div>
                            @endif
                        </div>
                        
                        <!-- Header Content -->
                        <div class="px-8 pb-8 pt-6 relative">
                            <!-- Badge -->
                            <div class="flex items-center gap-2 mb-4">
                                <span class="px-2.5 py-0.5 bg-blue-50 text-blue-600 border border-blue-100 rounded text-[10px] font-black uppercase tracking-wider">
                                    Student Research
                                </span>
                                <span class="px-2.5 py-0.5 bg-gray-50 text-gray-400 border border-gray-100 rounded text-[10px] font-bold uppercase">
                                    Archive #{{ str_pad($research->id, 5, '0', STR_PAD_LEFT) }}
                                </span>
                            </div>

                            <h1 class="text-2xl md:text-3xl font-black text-gray-900 leading-tight mb-4">
                                {{ $research->title }}
                            </h1>

                            <!-- Author/Researcher Attribution -->
                            <div class="flex items-center gap-4 mt-6">
                                <div class="w-12 h-12 bg-gray-100 rounded font-black text-[#26225C] flex items-center justify-center border border-gray-100 text-lg">
                                    {{ substr($research->authors, 0, 1) }}
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-base font-black text-gray-900 truncate">{{ $research->authors }}</h4>
                                    <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest mt-0.5">
                                        {{ $research->department }} • Lead Investigator
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Stats Quick Bar -->
                        <div class="px-8 py-3 border-t border-gray-100 bg-gray-50/50 flex items-center gap-6">
                            <div class="flex items-center gap-1.5 cursor-help" title="Total public views">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <span class="text-[11px] font-black text-gray-500 uppercase">{{ number_format($viewCount) }} Views</span>
                            </div>
                            <div class="flex items-center gap-1.5 cursor-help" title="Total institutional downloads">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                <span class="text-[11px] font-black text-gray-500 uppercase">{{ number_format($downloadCount) }} Downloads</span>
                            </div>
                        </div>
                    </div>

                    <!-- Main Body Card -->
                    <div class="bg-white rounded-xl border border-gray-200 p-8 shadow-sm space-y-10">
                        <!-- Abstract -->
                        <section>
                            <h3 class="text-[11px] font-black text-[#26225C] uppercase tracking-[0.2em] mb-4 border-b border-gray-100 pb-2">Abstract</h3>
                            <div class="text-[13px] text-gray-700 leading-relaxed font-medium">
                                {{ $research->abstract }}
                            </div>
                        </section>

                        <!-- Keywords -->
                        @if($research->tags)
                        <section>
                            <h3 class="text-[11px] font-black text-[#26225C] uppercase tracking-[0.2em] mb-4 border-b border-gray-100 pb-2">Institutional Keywords</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach(explode(',', $research->tags) as $tag)
                                    <span class="px-2.5 py-1 bg-gray-50 text-gray-500 border border-gray-100 rounded text-[10px] font-black uppercase tracking-wider hover:bg-gray-100 transition-colors cursor-default">
                                        {{ trim($tag) }}
                                    </span>
                                @endforeach
                            </div>
                        </section>
                        @endif

                        <!-- Citations -->
                        <section>
                            <h3 class="text-[11px] font-black text-[#26225C] uppercase tracking-[0.2em] mb-4 border-b border-gray-100 pb-2">How to Cite</h3>
                            <div class="bg-gray-50/50 rounded-lg border border-gray-100 overflow-hidden">
                                <!-- Tabs -->
                                <div class="flex overflow-x-auto border-b border-gray-200 no-scrollbar">
                                    @php $formats = ['apa' => 'APA', 'mla' => 'MLA', 'chicago' => 'Chicago', 'harvard' => 'Harvard', 'ieee' => 'IEEE', 'vancouver' => 'Vancouver']; @endphp
                                    @foreach($formats as $id => $label)
                                        <button onclick="showCitationFormat('{{ $id }}')" id="citation-tab-{{ $id }}" class="citation-tab px-5 py-3 text-[10px] font-black uppercase tracking-widest border-b-2 transition-all whitespace-nowrap {{ $loop->first ? 'border-[#26225C] text-[#26225C] bg-white' : 'border-transparent text-gray-400 hover:text-gray-600' }}">
                                            {{ $label }}
                                        </button>
                                    @endforeach
                                </div>
                                <!-- Content -->
                                <div class="p-6">
                                    <div id="citation-container" class="text-[12px] font-mono text-gray-600 leading-relaxed mb-4">
                                        @include('research.partials.citations', ['research' => $research, 'type' => 'student'])
                                    </div>
                                    <button onclick="copyCitationToClipboard()" class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded text-[10px] font-black text-[#26225C] uppercase tracking-widest hover:bg-gray-50 transition-all">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                        Copy Reference
                                    </button>
                                </div>
                            </div>
                        </section>

                        <!-- Research Network -->
                        <section>
                            <h3 class="text-[11px] font-black text-[#26225C] uppercase tracking-[0.2em] mb-4 border-b border-gray-100 pb-2">Research Network</h3>
                            <div class="flex gap-4 mb-6">
                                <button onclick="showTab('cited-by')" id="cited-by-tab" class="px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest transition-all bg-[#26225C] text-white">
                                    References Cited
                                </button>
                                <button onclick="showTab('cites-this')" id="cites-this-tab" class="px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest transition-all bg-gray-100 text-gray-500 hover:bg-gray-200">
                                    Research Citing This
                                </button>
                            </div>
                            
                            <div id="cited-by-content" class="tab-content transition-opacity duration-300">
                                <div id="cited-research-list" class="space-y-3">
                                    <!-- Dynamic content -->
                                </div>
                            </div>
                            <div id="cites-this-content" class="tab-content hidden transition-opacity duration-300">
                                <div id="citing-research-list" class="space-y-3">
                                    <!-- Dynamic content -->
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

                <!-- Right Sidebar Column -->
                <div class="lg:w-80 space-y-4">
                    
                    <!-- Primary Actions Card -->
                    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm space-y-3">
                        <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Access & Permissions</h4>
                        
                        @php
                            $user = auth()->user();
                            $isAdmin = $user && $user->role === 'admin';
                        @endphp

                        @if($research->abstract_file)
                            <a href="{{ route('student.view-abstract.pdf', $research->id) }}" 
                               class="flex items-center justify-center gap-2 w-full py-2.5 bg-white border border-[#26225C] text-[#26225C] text-[11px] font-black uppercase tracking-widest hover:bg-[#26225C] hover:text-white transition-all rounded">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                View Abstract PDF
                            </a>
                        @endif

                        @if($research->research_file && (auth()->check() || $isAdmin))
                            <a href="{{ route('student.view.pdf', $research->id) }}" target="_blank"
                               class="flex items-center justify-center gap-2 w-full py-2.5 bg-[#FFC72C] text-[#26225C] text-[11px] font-black uppercase tracking-widest hover:brightness-105 transition-all rounded">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 10v6m0 0l-3-33l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Full Research Paper
                            </a>
                        @endif

                        <button onclick="shareResearch()" 
                                class="flex items-center justify-center gap-2 w-full py-2.5 bg-gray-50 border border-gray-200 text-gray-600 text-[11px] font-black uppercase tracking-widest hover:bg-gray-100 transition-all rounded">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"/></svg>
                            Share Repository Link
                        </button>
                    </div>

                    <!-- Repository Metadata Card -->
                    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm space-y-4">
                        <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Publication Stats</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tight">Status</span>
                                <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 text-[9px] font-black uppercase tracking-tighter rounded">Approved</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tight">Department</span>
                                <span class="text-[11px] font-black text-[#26225C] uppercase tracking-tighter">{{ $research->department }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tight">Published</span>
                                <span class="text-[11px] font-black text-gray-600 uppercase">{{ $research->approved_at ? $research->approved_at->format('M d, Y') : 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Related Works -->
                    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                        <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">You May Also Like</h4>
                        <div class="space-y-4">
                            @forelse($relatedResearch ?? [] as $related)
                                <a href="{{ route($related['route'], $related['id']) }}" class="group block">
                                    <h5 class="text-[12px] font-black text-[#26225C] leading-tight group-hover:text-blue-600 transition-colors line-clamp-2">
                                        {{ $related['title'] }}
                                    </h5>
                                    <div class="flex items-center gap-3 mt-1.5 text-[9px] font-bold text-gray-400 uppercase tracking-wider">
                                        <span>{{ $related['viewCount'] ?? 0 }} Views</span>
                                        <span>{{ $related['type'] }} archive</span>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-4">
                                    <p class="text-[11px] font-bold text-gray-400 uppercase">No related items</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Quick Navigation -->
                    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                        <a href="{{ route('dashboard') }}" class="flex items-center justify-center gap-2 w-full py-2 text-gray-500 hover:text-blue-600 transition-colors text-[11px] font-black uppercase tracking-widest">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            Back to Feed
                        </a>
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
                tab.classList.remove('border-[#26225C]', 'text-[#26225C]', 'bg-white', 'active-citation-tab');
                tab.classList.add('border-transparent', 'text-gray-400');
            });
            
            // Show selected citation content
            document.getElementById('citation-content-' + format).classList.remove('hidden');
            
            // Add active class to selected tab
            const activeTab = document.getElementById('citation-tab-' + format);
            activeTab.classList.add('border-[#26225C]', 'text-[#26225C]', 'bg-white', 'active-citation-tab');
            activeTab.classList.remove('border-transparent', 'text-gray-400');
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
                    title: '{{ $research->title }}',
                    text: 'Check out this research: {{ $research->title }}',
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
                tab.classList.remove('bg-[#26225C]', 'text-white', 'active-tab');
                tab.classList.add('bg-gray-100', 'text-gray-500');
            });
            
            // Show selected tab content
            document.getElementById(tabName + '-content').classList.remove('hidden');
            
            // Add active class to selected tab
            const activeTab = document.getElementById(tabName + '-tab');
            activeTab.classList.add('bg-[#26225C]', 'text-white', 'active-tab');
            activeTab.classList.remove('bg-gray-100', 'text-gray-500');
            
            // Load citations if not already loaded
            if (!citationsLoaded[tabName]) {
                loadCitations(tabName);
                citationsLoaded[tabName] = true;
            }
        }

        function loadCitations(type) {
            const url = type === 'cited-by' 
                ? '/references-cited/student/{{ $research->id }}' 
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
            if (!citations || citations.length === 0) {
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
                const title = type === 'cited-by' ? citation.cited_title : citation.citing_title;
                const rType = type === 'cited-by' ? citation.cited_type : citation.citing_type;
                const rId = type === 'cited-by' ? citation.cited_research_id : citation.citing_research_id;
                const user = type === 'cited-by' ? 'Institutional Archive' : (citation.citing_user || 'Author');
                const context = citation.citation_context || '';
                const date = citation.created_at || '';

                return `
                    <div class="border border-gray-200 rounded-xl p-6 hover:border-[#FFC72C] hover:shadow-lg transition-all duration-300 cursor-pointer bg-white" 
                         onclick="window.location.href='/research/${rType}/${rId}'">
                        <div class="flex items-start justify-between mb-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-[#26225C] bg-opacity-10 text-[#26225C] border border-[#FFC72C] border-opacity-30 uppercase tracking-tighter">
                                ${rType} Archive
                            </span>
                            <span class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">${date}</span>
                        </div>
                        <h5 class="font-black text-[#26225C] mb-2 text-sm leading-tight">${title}</h5>
                        <p class="text-[10px] text-gray-500 mb-3 font-bold uppercase tracking-wider">${user}</p>
                        ${context ? `
                            <div class="bg-gray-50 p-4 rounded-lg mt-3 border border-gray-100 italic">
                                <p class="text-[11px] text-gray-600 font-medium leading-relaxed">"${context}"</p>
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
