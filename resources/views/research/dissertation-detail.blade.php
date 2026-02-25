<x-app-layout>
    <div class="min-h-screen bg-[#f3f2ef]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            
            <!-- Main Content Grid -->
            <div class="flex flex-col lg:flex-row gap-6">
                
                <!-- Left/Main Column -->
                <div class="flex-1 space-y-4">
                    
                    <!-- Research Identity Card -->
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                        <!-- Banner -->
                        <div class="h-max bg-[#26225C] relative">
                             @if($dissertation->banner_image)
                                <img src="{{ asset('storage/' . $dissertation->banner_image) }}" alt="Research Banner" class="w-full h-48 object-cover opacity-80">
                            @else
                                <div class="h-32 bg-gradient-to-r from-[#26225C] to-[#3a3770] opacity-90"></div>
                            @endif
                        </div>
                        
                        <!-- Header -->
                        <div class="px-8 pb-8 pt-6 relative">
                            <div class="flex items-center gap-2 mb-4">
                                <span class="px-2.5 py-0.5 bg-blue-50 text-blue-600 border border-blue-100 rounded text-[10px] font-black uppercase tracking-wider">
                                    Doctoral Dissertation
                                </span>
                                <span class="px-2.5 py-0.5 bg-gray-50 text-gray-400 border border-gray-100 rounded text-[10px] font-bold uppercase">
                                    Archive #D-{{ str_pad($dissertation->id, 5, '0', STR_PAD_LEFT) }}
                                </span>
                            </div>

                            <h1 class="text-2xl md:text-3xl font-black text-gray-900 leading-tight mb-4">
                                {{ $dissertation->title }}
                            </h1>

                            <div class="flex items-center gap-4 mt-6">
                                <div class="w-12 h-12 bg-gray-100 rounded font-black text-[#26225C] flex items-center justify-center border border-gray-100 text-lg">
                                    {{ substr($dissertation->author ?? 'D', 0, 1) }}
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-base font-black text-gray-900 truncate">{{ $dissertation->author ?? 'Researcher' }}</h4>
                                    <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest mt-0.5">
                                        {{ $dissertation->department }} • Doctoral Candidate
                                    </p>
                                </div>
                            </div>
                        </div>

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

                    <!-- Content Card -->
                    <div class="bg-white rounded-xl border border-gray-200 p-8 shadow-sm space-y-10">
                        <section>
                            <h3 class="text-[11px] font-black text-[#26225C] uppercase tracking-[0.2em] mb-4 border-b border-gray-100 pb-2">Abstract</h3>
                            <div class="text-[13px] text-gray-700 leading-relaxed font-medium">
                                {{ $dissertation->abstract }}
                            </div>
                        </section>

                        @if($dissertation->keywords)
                        <section>
                            <h3 class="text-[11px] font-black text-[#26225C] uppercase tracking-[0.2em] mb-4 border-b border-gray-100 pb-2">Institutional Keywords</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach(explode(',', $dissertation->keywords) as $tag)
                                    <span class="px-2.5 py-1 bg-gray-50 text-gray-500 border border-gray-100 rounded text-[10px] font-black uppercase tracking-wider hover:bg-gray-100 transition-colors cursor-default">
                                        {{ trim($tag) }}
                                    </span>
                                @endforeach
                            </div>
                        </section>
                        @endif

                        <section>
                            <h3 class="text-[11px] font-black text-[#26225C] uppercase tracking-[0.2em] mb-4 border-b border-gray-100 pb-2">How to Cite</h3>
                            <div class="bg-gray-50/50 rounded-lg border border-gray-100 overflow-hidden">
                                <div class="flex overflow-x-auto border-b border-gray-200 no-scrollbar">
                                    @php $formats = ['apa' => 'APA', 'mla' => 'MLA', 'chicago' => 'Chicago', 'harvard' => 'Harvard', 'ieee' => 'IEEE', 'vancouver' => 'Vancouver']; @endphp
                                    @foreach($formats as $id => $label)
                                        <button onclick="showCitationFormat('{{ $id }}')" id="citation-tab-{{ $id }}" class="citation-tab px-5 py-3 text-[10px] font-black uppercase tracking-widest border-b-2 transition-all whitespace-nowrap {{ $loop->first ? 'border-[#26225C] text-[#26225C] bg-white' : 'border-transparent text-gray-400 hover:text-gray-600' }}">
                                            {{ $label }}
                                        </button>
                                    @endforeach
                                </div>
                                <div class="p-6">
                                    <div id="citation-container" class="text-[12px] font-mono text-gray-600 leading-relaxed mb-4">
                                        @include('research.partials.citations', ['research' => $dissertation, 'type' => 'dissertation'])
                                    </div>
                                    <button onclick="copyCitationToClipboard()" class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded text-[10px] font-black text-[#26225C] uppercase tracking-widest hover:bg-gray-50 transition-all">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                        Copy Reference
                                    </button>
                                </div>
                            </div>
                        </section>

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
                                <div id="cited-research-list" class="space-y-3"></div>
                            </div>
                            <div id="cites-this-content" class="tab-content hidden transition-opacity duration-300">
                                <div id="citing-research-list" class="space-y-3"></div>
                            </div>
                        </section>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:w-80 space-y-4">
                    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm space-y-3">
                        <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Access & Permissions</h4>
                        
                        @if($dissertation->abstract_file)
                            <a href="{{ route('dissertation.view-abstract.pdf', $dissertation->id) }}" 
                               class="flex items-center justify-center gap-2 w-full py-2.5 bg-white border border-[#26225C] text-[#26225C] text-[11px] font-black uppercase tracking-widest hover:bg-[#26225C] hover:text-white transition-all rounded">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                View Abstract PDF
                            </a>
                        @endif

                        @php $isAdmin = auth()->user() && auth()->user()->role === 'admin'; @endphp
                        @if($dissertation->dissertation_file && (auth()->check() || $isAdmin))
                            <a href="{{ route('dissertation.view.pdf', $dissertation->id) }}" target="_blank"
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

                    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm space-y-4">
                        <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Publication Stats</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tight">Department</span>
                                <span class="text-[11px] font-black text-[#26225C] uppercase tracking-tighter">{{ $dissertation->department }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tight">Level</span>
                                <span class="text-[11px] font-black text-[#26225C] uppercase tracking-tighter">Doctoral</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tight">Published</span>
                                <span class="text-[11px] font-black text-gray-600 uppercase">{{ $dissertation->approved_at ? $dissertation->approved_at->format('M d, Y') : 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

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
                                        <span>{{ $related['type'] }}</span>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-4">
                                    <p class="text-[11px] font-bold text-gray-400 uppercase">No related items</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

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

    <script>
        function showCitationFormat(format) {
            document.querySelectorAll('.citation-content').forEach(c => c.classList.add('hidden'));
            document.querySelectorAll('.citation-tab').forEach(t => {
                t.classList.remove('border-[#26225C]', 'text-[#26225C]', 'bg-white');
                t.classList.add('border-transparent', 'text-gray-400');
            });
            document.getElementById('citation-content-' + format).classList.remove('hidden');
            const active = document.getElementById('citation-tab-' + format);
            active.classList.add('border-[#26225C]', 'text-[#26225C]', 'bg-white');
            active.classList.remove('border-transparent', 'text-gray-400');
        }

        function copyCitationToClipboard() {
            const active = document.querySelector('.citation-content:not(.hidden) .font-mono');
            if (active) {
                navigator.clipboard.writeText(active.textContent.trim()).then(() => alert('Reference copied!'));
            }
        }

        function shareResearch() {
            if (navigator.share) {
                navigator.share({ title: '{{ $dissertation->title }}', url: window.location.href });
            } else {
                navigator.clipboard.writeText(window.location.href).then(() => alert('Link copied!'));
            }
        }

        let citationsLoaded = { 'cited-by': false, 'cites-this': false };
        function showTab(tab) {
            document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
            document.getElementById(tab + '-content').classList.remove('hidden');
            document.querySelectorAll('[id$="-tab"]').forEach(t => {
                t.classList.remove('bg-[#26225C]', 'text-white');
                t.classList.add('bg-gray-100', 'text-gray-500');
            });
            const active = document.getElementById(tab + '-tab');
            active.classList.add('bg-[#26225C]', 'text-white');
            active.classList.remove('bg-gray-100', 'text-gray-500');
            
            if (!citationsLoaded[tab]) {
                loadCitations(tab);
                citationsLoaded[tab] = true;
            }
        }

        function loadCitations(type) {
            const url = type === 'cited-by' 
                ? '/references-cited/dissertation/{{ $dissertation->id }}' 
                : '/research-citations/dissertation/{{ $dissertation->id }}';
            const container = document.getElementById(type === 'cited-by' ? 'cited-research-list' : 'citing-research-list');
            fetch(url)
                .then(r => r.json())
                .then(data => displayCitations(data, container, type))
                .catch(err => {
                    container.innerHTML = '<p class="text-[11px] text-gray-400 uppercase font-bold text-center py-6">Failed to load data</p>';
                });
        }

        function displayCitations(data, container, type) {
            if (!data || !data.length) {
                container.innerHTML = `<p class="text-[11px] text-gray-400 uppercase font-bold text-center py-6">${type === 'cited-by' ? 'No references cited' : 'No research citing this'}</p>`;
                return;
            }
            container.innerHTML = data.map(c => {
                const title = type === 'cited-by' ? c.cited_title : c.citing_title;
                const rType = type === 'cited-by' ? c.cited_type : c.citing_type;
                const rId = type === 'cited-by' ? c.cited_research_id : c.citing_research_id;
                
                return `
                    <div class="p-4 border border-gray-100 rounded-lg hover:border-blue-200 transition-colors bg-gray-50/30 cursor-pointer" 
                         onclick="window.location.href='/research/${rType}/${rId}'">
                        <h5 class="text-[12px] font-black text-[#26225C] mb-1 line-clamp-2">${title}</h5>
                        <div class="flex items-center gap-2">
                            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">${rType} Archive</span>
                            ${c.citation_context ? `<span class="text-[9px] font-medium text-blue-500 italic truncate">— ${c.citation_context}</span>` : ''}
                        </div>
                    </div>
                `;
            }).join('');
        }

        document.addEventListener('DOMContentLoaded', () => showTab('cited-by'));
    </script>
</x-app-layout>
