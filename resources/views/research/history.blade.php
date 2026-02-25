<x-app-layout>
    <div class="min-h-screen bg-[#f3f2ef]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row gap-6">
                
                <!-- Left Sidebar: Profile & Filters -->
                <div class="w-full md:w-64 flex-shrink-0 space-y-4">
                    <!-- Profile Summary Card -->
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                        <div class="h-14 bg-[#26225C] relative">
                            <div class="absolute -bottom-6 left-1/2 -translate-x-1/2">
                                <div class="w-12 h-12 bg-white rounded-full p-0.5 shadow-sm">
                                    <div class="w-full h-full bg-gray-100 rounded-full flex items-center justify-center border border-gray-200 overflow-hidden">
                                        <span class="text-sm font-black text-[#26225C]">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pt-8 pb-4 px-4 text-center border-b border-gray-100">
                            <h3 class="text-sm font-black text-gray-900 truncate">{{ Auth::user()->name }}</h3>
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mt-0.5">{{ Auth::user()->role }}</p>
                            @if(Auth::user()->course || Auth::user()->department)
                                <p class="text-[9px] font-medium text-gray-400 mt-2 italic leading-tight">
                                    {{ Auth::user()->course ?? Auth::user()->department }}
                                </p>
                            @endif
                        </div>
                        <div class="py-3">
                            <div class="px-4 py-1 flex justify-between items-center group cursor-pointer hover:bg-gray-50">
                                <span class="text-[11px] font-bold text-gray-500 group-hover:text-gray-900">Total Submissions</span>
                                <span class="text-[11px] font-black text-blue-600">{{ $totalCount }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Card -->
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm sticky top-20">
                        <div class="p-3 border-b border-gray-100">
                            <h4 class="text-[10px] font-black text-gray-900 uppercase tracking-widest">Manage History</h4>
                        </div>
                        <div class="py-2">
                            <button onclick="filterByStatus('all')" id="status-all" class="status-filter-btn w-full text-left px-4 py-2 text-[11px] font-bold text-blue-600 bg-blue-50/50 border-l-4 border-blue-600 transition-all">
                                All Submissions
                            </button>
                            <button onclick="filterByStatus('pending')" id="status-pending" class="status-filter-btn w-full text-left px-4 py-2 text-[11px] font-bold text-gray-500 hover:text-gray-900 hover:bg-gray-50 border-l-4 border-transparent transition-all">
                                Pending Review
                            </button>
                            <button onclick="filterByStatus('approved')" id="status-approved" class="status-filter-btn w-full text-left px-4 py-2 text-[11px] font-bold text-gray-500 hover:text-gray-900 hover:bg-gray-50 border-l-4 border-transparent transition-all">
                                Approved Works
                            </button>
                            <button onclick="filterByStatus('rejected')" id="status-rejected" class="status-filter-btn w-full text-left px-4 py-2 text-[11px] font-bold text-gray-500 hover:text-gray-900 hover:bg-gray-50 border-l-4 border-transparent transition-all">
                                Rejected
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Middle Column: History Feed -->
                <div class="flex-1 space-y-4">
                    <!-- Search & Title Header -->
                    <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                            <div>
                                <h1 class="text-lg font-black text-gray-900">Submission History</h1>
                                <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">{{ number_format($allResearch->total()) }} Records Published</p>
                            </div>
                            <form method="GET" action="{{ route('research.history') }}" class="w-full sm:w-64 relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" name="search" value="{{ $searchQuery ?? '' }}" id="historySearch"
                                       placeholder="Search history..." 
                                       class="block w-full pl-9 pr-3 py-1.5 border-gray-200 bg-[#edf3f8] rounded-md text-sm placeholder-gray-500 focus:bg-white focus:ring-1 focus:ring-blue-600 focus:border-blue-600 transition-all">
                            </form>
                        </div>
                    </div>

                    <!-- History Items -->
                    @if($allResearch->count() > 0)
                        <div id="historyItemsContainer" class="space-y-4">
                            @foreach($allResearch as $research)
                                <div class="history-item-card bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden group hover:border-blue-300 transition-all cursor-pointer"
                                     data-status="{{ $research->status }}"
                                     onclick="navigateToResearch('{{ $research->type }}', {{ $research->id }}, '{{ $research->status }}')"
                                     data-search-text="{{ strtolower($research->title . ' ' . ($research->authors ?? $research->author ?? '') . ' ' . $research->department) }}">
                                    
                                    <div class="p-4 flex gap-4">
                                        <!-- Type Icon -->
                                        <div class="shrink-0">
                                            @php
                                                $iconBg = match($research->type) {
                                                    'student' => 'bg-blue-50',
                                                    'faculty' => 'bg-purple-50',
                                                    'thesis' => 'bg-emerald-50',
                                                    'dissertation' => 'bg-rose-50',
                                                    default => 'bg-gray-50',
                                                };
                                                $iconColor = match($research->type) {
                                                    'student' => 'text-blue-600',
                                                    'faculty' => 'text-purple-600',
                                                    'thesis' => 'text-emerald-600',
                                                    'dissertation' => 'text-rose-600',
                                                    default => 'text-gray-600',
                                                };
                                            @endphp
                                            <div class="w-12 h-12 {{ $iconBg }} rounded flex items-center justify-center p-2.5">
                                                <svg class="w-full h-full {{ $iconColor }}" fill="currentColor" viewBox="0 0 24 24">
                                                    @if($research->type === 'student')
                                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm4.59-12.42L10 14.17l-2.59-2.58L6 13l4 4 8-8z"></path>
                                                    @else
                                                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zM6 20V4h7v5h5v11H6z"></path>
                                                    @endif
                                                </svg>
                                            </div>
                                        </div>

                                        <!-- Content -->
                                        <div class="flex-1 min-w-0">
                                            <div class="flex justify-between items-start">
                                                <h3 class="text-sm font-black text-gray-900 group-hover:text-blue-600 group-hover:underline transition-all line-clamp-2">
                                                    {{ $research->title }}
                                                </h3>
                                                @php
                                                    $statusPill = match($research->status) {
                                                        'pending' => 'bg-amber-100 text-amber-800',
                                                        'approved' => 'bg-emerald-100 text-emerald-800',
                                                        'rejected' => 'bg-rose-100 text-rose-800',
                                                        default => 'bg-gray-100 text-gray-800',
                                                    };
                                                @endphp
                                                <span class="ml-2 px-2 py-0.5 rounded-full {{ $statusPill }} text-[9px] font-black uppercase tracking-tighter shrink-0">
                                                    {{ $research->status }}
                                                </span>
                                            </div>
                                            <p class="text-[11px] text-gray-500 font-bold uppercase tracking-tight mt-1 truncate">
                                                {{ $research->department }} • {{ $research->type }} archive
                                            </p>
                                            <p class="text-[10px] text-gray-400 mt-0.5">
                                                Submitted on {{ $research->created_at->format('M d, Y') }}
                                            </p>

                                            @if($research->status === 'rejected' && $research->rejection_reason)
                                                <div class="mt-3 p-2 bg-rose-50 border border-rose-100 rounded text-[10px] text-rose-700 italic">
                                                    <strong>Revision Required:</strong> {{ $research->rejection_reason }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Action Bar -->
                                    <div class="px-4 py-2 bg-gray-50 border-t border-gray-100 flex justify-between items-center group-hover:bg-blue-50/30 transition-colors" onclick="event.stopPropagation()">
                                        <div class="flex gap-4">
                                            @if($research->status === 'approved')
                                                <a href="{{ route($research->type . '.show', $research->id) }}" class="flex items-center text-[11px] font-black text-gray-500 hover:text-blue-600 transition-colors uppercase tracking-widest">
                                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                    View Publication
                                                </a>
                                            @elseif($research->status === 'pending')
                                                <a href="{{ route($research->type . '.edit', $research->id) }}" class="flex items-center text-[11px] font-black text-gray-500 hover:text-amber-600 transition-colors uppercase tracking-widest">
                                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                    Modify Draft
                                                </a>
                                            @endif
                                        </div>
                                        <form action="{{ route('admin.research.delete', ['type' => $research->type, 'id' => $research->id]) }}" method="POST" onsubmit="return confirm('Archive this draft permanently?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-[10px] font-black text-gray-400 hover:text-red-600 uppercase tracking-widest transition-colors">Withdraw</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-6">
                            {{ $allResearch->links() }}
                        </div>
                    @else
                        <div class="bg-white rounded-xl border border-gray-200 p-12 text-center shadow-sm">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            </div>
                            <h3 class="text-sm font-black text-gray-900">No submission records</h3>
                            <p class="text-xs text-gray-500 mt-1">Start contributing to the institutional knowledge base.</p>
                            <a href="{{ route('dashboard') }}" class="mt-6 inline-block px-6 py-2 bg-blue-600 text-white rounded-full text-xs font-black uppercase tracking-widest hover:bg-blue-700 transition-colors shadow-sm">
                                Create Submission
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Right Sidebar: Stats & Insights -->
                <div class="hidden lg:block w-72 space-y-4">
                    <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
                        <h4 class="text-[11px] font-black text-gray-900 uppercase tracking-widest mb-4">Repository Overview</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-blue-50 p-3 rounded-lg border border-blue-100">
                                <p class="text-[9px] font-black text-blue-600 uppercase tracking-tighter">Approved</p>
                                <p class="text-xl font-black text-[#26225C] mt-1">{{ $approvedCount }}</p>
                            </div>
                            <div class="bg-amber-50 p-3 rounded-lg border border-amber-100">
                                <p class="text-[9px] font-black text-amber-600 uppercase tracking-tighter">Pending</p>
                                <p class="text-xl font-black text-[#26225C] mt-1">{{ $pendingCount }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
                        <h4 class="text-[11px] font-black text-gray-900 uppercase tracking-widest mb-2">Notice</h4>
                        <p class="text-[11px] text-gray-500 leading-relaxed italic border-l-2 border-blue-500 pl-3">
                            Approved works are automatically indexed and become available to the global USPF student and faculty community.
                        </p>
                    </div>

                    <!-- Simplified Footer Links -->
                    <div class="px-4 py-2 text-center">
                        <div class="flex flex-wrap justify-center gap-x-3 gap-y-1">
                            <a href="#" class="text-[10px] text-gray-500 hover:text-blue-600 font-medium">About</a>
                            <a href="#" class="text-[10px] text-gray-500 hover:text-blue-600 font-medium">Help Center</a>
                            <a href="#" class="text-[10px] text-gray-500 hover:text-blue-600 font-medium">Privacy & Terms</a>
                        </div>
                        <p class="text-[10px] text-gray-400 mt-4 font-black uppercase tracking-widest whitespace-nowrap">
                            USPF ARCHIVE © {{ date('Y') }}
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function navigateToResearch(type, id, status) {
            const routes = {
                'student': { show: '{{ route("student.show", ":id") }}', edit: '{{ route("student.edit", ":id") }}' },
                'faculty': { show: '{{ route("faculty.show", ":id") }}', edit: '{{ route("faculty.edit", ":id") }}' },
                'thesis': { show: '{{ route("thesis.show", ":id") }}', edit: '{{ route("thesis.edit", ":id") }}' },
                'dissertation': { show: '{{ route("dissertation.show", ":id") }}', edit: '{{ route("dissertation.edit", ":id") }}' }
            };

            if (status === 'approved') {
                window.location.href = routes[type].show.replace(':id', id);
            } else if (status === 'pending') {
                window.location.href = routes[type].edit.replace(':id', id);
            }
        }

        function filterByStatus(status) {
            const items = document.querySelectorAll('.history-item-card');
            const btns = document.querySelectorAll('.status-filter-btn');
            
            // Update UI
            btns.forEach(btn => {
                btn.classList.remove('text-blue-600', 'bg-blue-50/50', 'border-blue-600');
                btn.classList.add('text-gray-500', 'border-transparent');
                if (btn.id === `status-${status}`) {
                    btn.classList.add('text-blue-600', 'bg-blue-50/50', 'border-blue-600');
                    btn.classList.remove('text-gray-500', 'border-transparent');
                }
            });

            // Filter items
            items.forEach(item => {
                if (status === 'all' || item.getAttribute('data-status') === status) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        // Real-time search
        document.getElementById('historySearch').addEventListener('input', function(e) {
            const term = e.target.value.toLowerCase();
            const items = document.querySelectorAll('.history-item-card');
            
            items.forEach(item => {
                const text = item.getAttribute('data-search-text');
                item.style.display = text.includes(term) ? '' : 'none';
            });
        });
    </script>
</x-app-layout>
