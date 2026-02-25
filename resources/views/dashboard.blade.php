<x-app-layout>
    <div class="min-h-screen bg-[#F3F2EF] py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                
                <!-- Left Column: Profile & Navigation -->
                <aside class="lg:col-span-3 space-y-4">
                    <!-- User Profile Card -->
                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                        <div class="h-16 bg-[#26225C] relative">
                            <div class="absolute -bottom-10 left-1/2 -translate-x-1/2">
                                <div class="w-20 h-20 rounded-full bg-white p-1 border border-gray-100 shadow-lg flex items-center justify-center">
                                    <div class="w-full h-full rounded-full bg-gray-100 border border-gray-200 flex items-center justify-center font-black text-2xl text-[#26225C]">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pt-12 pb-6 px-4 text-center">
                            <h3 class="text-lg font-black text-[#26225C] tracking-tight">{{ auth()->user()->name }}</h3>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">
                                {{ auth()->user()->role === 'admin' ? 'System Administrator' : (auth()->user()->role === 'faculty' ? 'Faculty Researcher' : 'University Researcher') }}
                            </p>
                        </div>
                        <div class="border-y border-gray-100 py-3">
                            <div class="px-4 py-1.5 flex justify-between text-[11px] font-bold tracking-tight group cursor-pointer hover:bg-gray-50">
                                <span class="text-gray-400 uppercase">Profile Views</span>
                                <span class="text-[#26225C]">--</span>
                            </div>
                            <div class="px-4 py-1.5 flex justify-between text-[11px] font-bold tracking-tight group cursor-pointer hover:bg-gray-50">
                                <span class="text-gray-400 uppercase">My Publications</span>
                                <span class="text-[#26225C]">0</span>
                            </div>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="block py-3 text-center text-[10px] font-black text-[#26225C] uppercase tracking-widest hover:bg-gray-50 active:bg-gray-100 transition border-b border-gray-100">
                            My Dashboard
                        </a>
                        <!-- New Submission Section moved here for clarity -->
                        <div class="p-3 bg-gray-50/50">
                             <h4 class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Institutional Submission</h4>
                             <div class="grid grid-cols-2 gap-2">
                                <a href="{{ route('student.upload') }}" class="flex items-center justify-center p-2 rounded bg-white border border-gray-100 hover:border-blue-500 hover:text-blue-600 transition text-[9px] font-bold text-[#26225C] uppercase">
                                    Student
                                </a>
                                <a href="{{ route('faculty.upload') }}" class="flex items-center justify-center p-2 rounded bg-white border border-gray-100 hover:border-purple-500 hover:text-purple-600 transition text-[9px] font-bold text-[#26225C] uppercase">
                                    Faculty
                                </a>
                                <a href="{{ route('thesis.upload') }}" class="flex items-center justify-center p-2 rounded bg-white border border-gray-100 hover:border-green-500 hover:text-green-600 transition text-[9px] font-bold text-[#26225C] uppercase">
                                    Thesis
                                </a>
                                <a href="{{ route('dissertations.upload') }}" class="flex items-center justify-center p-2 rounded bg-white border border-gray-100 hover:border-red-500 hover:text-red-600 transition text-[9px] font-bold text-[#26225C] uppercase">
                                    Dissert.
                                </a>
                             </div>
                        </div>
                    </div>

                    <!-- Quick Navigation Card -->
                    <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm sticky top-8">
                        <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Quick Explore</h4>
                        <div class="space-y-3">
                            <a href="{{ route('research.by-department') }}" class="flex items-center group text-sm font-bold text-[#26225C] hover:text-blue-600 transition">
                                <div class="w-8 h-8 rounded bg-gray-50 flex items-center justify-center mr-3 group-hover:bg-blue-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <span class="uppercase tracking-tighter">Departments</span>
                            </a>
                            <a href="{{ route('research.history') }}" class="flex items-center group text-sm font-bold text-[#26225C] hover:text-blue-600 transition">
                                <div class="w-8 h-8 rounded bg-gray-50 flex items-center justify-center mr-3 group-hover:bg-blue-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <span class="uppercase tracking-tighter">My History</span>
                            </a>
                        </div>
                        <div class="mt-6 pt-6 border-t border-gray-100">
                             <a href="#" class="text-[10px] font-black text-blue-600 uppercase tracking-widest hover:underline">
                                 Discover more +
                             </a>
                        </div>
                    </div>
                </aside>

                <!-- Middle Column: Main Feed -->
                <main class="lg:col-span-6 space-y-4">
                    <!-- Search / Post Creator Box -->
                    <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="w-12 h-12 flex-shrink-0 rounded-full bg-gray-100 border border-gray-200 flex items-center justify-center font-bold text-[#26225C]">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <form action="{{ route('dashboard') }}" method="GET" class="flex-1 relative">
                                <input 
                                    type="text" 
                                    name="search"
                                    id="researchSearchInput"
                                    value="{{ $searchQuery ?? '' }}"
                                    placeholder="Search institutional research repository..." 
                                    class="w-full bg-gray-50 border border-gray-200 rounded-full py-3.5 px-6 text-xs font-bold text-gray-700 hover:bg-gray-100 focus:bg-white focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition cursor-pointer"
                                >
                            </form>
                        </div>
                        <div class="flex justify-between px-2 pt-2 gap-2 overflow-x-auto pb-1 scrollbar-hide">
                            @php
                                $categoryItems = [
                                    ['label' => 'Student', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253', 'color' => 'blue'],
                                    ['label' => 'Faculty', 'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z', 'color' => 'purple'],
                                    ['label' => 'Thesis', 'icon' => 'M12 14l9-5-9-5-9 5 9 5z', 'color' => 'green'],
                                    ['label' => 'Dissertation', 'icon' => 'M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4v3H3V7z', 'color' => 'red'],
                                ];
                            @endphp
                            @foreach($categoryItems as $item)
                                <button type="button" 
                                        onclick="filterByType('{{ strtolower($item['label']) }}')"
                                        id="filter-{{ strtolower($item['label']) }}"
                                        class="category-filter-btn flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition group flex-shrink-0">
                                    <svg class="w-5 h-5 text-{{ $item['color'] }}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"></path>
                                    </svg>
                                    <span class="text-xs font-black text-gray-500 group-hover:text-gray-900 uppercase tracking-tighter">{{ $item['label'] }}</span>
                                </button>
                            @endforeach
                            <button type="button" 
                                    onclick="filterByType('all')"
                                    id="filter-all"
                                    class="category-filter-btn flex items-center space-x-2 px-3 py-2 rounded-lg bg-gray-100 text-[#26225C] transition group flex-shrink-0">
                                <span class="text-xs font-black uppercase tracking-tighter">All Feed</span>
                            </button>
                        </div>
                    </div>

                    <!-- Filter Divider -->
                    <div class="flex items-center py-2">
                        <hr class="flex-1 border-gray-300">
                        <div class="px-4 text-[10px] font-black text-gray-400 uppercase tracking-widest flex items-center">
                            Sort by: <span class="text-[#26225C] ml-1 flex items-center cursor-pointer">Most Recent <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg></span>
                        </div>
                    </div>

                    <!-- Research Feed -->
                    <div id="researchFeed" class="space-y-4">
                        @if(isset($mostRecent) && $mostRecent->count())
                            @foreach($mostRecent as $item)
                                @php
                                    $type = $item->type ?? 'student';
                                    $routeName = match($type) {
                                        'student' => 'student.show',
                                        'faculty' => 'faculty.show',
                                        'thesis' => 'thesis.show',
                                        'dissertation' => 'dissertation.show',
                                        default => 'student.show',
                                    };
                                    $colorClass = match($type) {
                                        'student' => 'blue',
                                        'faculty' => 'purple',
                                        'thesis' => 'green',
                                        'dissertation' => 'red',
                                        default => 'blue',
                                    };
                                @endphp
                                <div class="research-item bg-white border border-gray-200 rounded-lg shadow-sm group hover:border-gray-300 transition"
                                     data-type="{{ $type }}"
                                     data-search-text="{{ strtolower($item->title . ' ' . ($item->authors ?? $item->author ?? '') . ' ' . ($item->department ?? '') . ' ' . ($item->tags ?? $item->keywords ?? '')) }}">
                                    <!-- Card Header -->
                                    <div class="p-4 flex items-start justify-between">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-{{ $colorClass }}-50 border border-{{ $colorClass }}-100 flex items-center justify-center font-bold text-{{ $colorClass }}-600 text-sm">
                                                {{ substr($item->authors ?? $item->author ?? 'U', 0, 1) }}
                                            </div>
                                            <div>
                                                <h4 class="text-xs font-black text-[#26225C] tracking-tight group-hover:text-blue-600 transition truncate max-w-[200px] md:max-w-md">
                                                    {{ Str::limit($item->authors ?? $item->author ?? 'University User', 40) }}
                                                </h4>
                                                <div class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">
                                                    {{ $item->department ?? 'Department Not Specified' }} • {{ optional($item->approved_at)->format('M d, Y') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-end">
                                            <span class="badge bg-{{ $colorClass }}-50 text-{{ $colorClass }}-600 mb-1">
                                                {{ ucfirst($type) }}
                                            </span>
                                        </div>
                                    </div>
                                    <!-- Card Content -->
                                    <div class="px-4 pb-4">
                                        <a href="{{ route($routeName, $item->id) }}" class="block">
                                            <h3 class="text-base font-black text-[#26225C] mb-2 leading-snug group-hover:underline">
                                                {{ $item->title }}
                                            </h3>
                                            @if($item->abstract || $item->description)
                                            <p class="text-[13px] text-gray-600 line-clamp-2 leading-relaxed">
                                                {{ $item->abstract ?? $item->description }}
                                            </p>
                                            @endif
                                        </a>
                                    </div>
                                    <!-- Card Footer -->
                                    <div class="px-4 py-3 bg-gray-50/50 border-t border-gray-100 flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex items-center text-gray-400 group/link cursor-pointer hover:text-blue-600 transition">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                <span class="text-[10px] font-black uppercase tracking-widest">{{ number_format($item->views ?? 0) }} Views</span>
                                            </div>
                                        </div>
                                        <a href="{{ route($routeName, $item->id) }}" class="text-[10px] font-black text-blue-600 uppercase tracking-widest flex items-center hover:underline">
                                            View Details
                                            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="bg-white border border-gray-200 rounded-lg p-12 text-center shadow-sm">
                                <div class="w-16 h-16 bg-gray-50 border border-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="h-8 w-8 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-black text-[#26225C] uppercase tracking-tighter mb-1">Queue is empty</h3>
                                <p class="text-[11px] text-gray-400 font-bold uppercase tracking-widest">No recent publications found in the repository.</p>
                            </div>
                        @endif
                    </div>
                </main>

                <!-- Right Column: Institutional Insights -->
                <aside class="lg:col-span-3 space-y-4">
                    <!-- Statistics Card -->
                    <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                        <div class="flex items-center justify-between mb-6">
                            <h4 class="text-[10px] font-black text-[#26225C] uppercase tracking-[0.2em]">Archive Analytics</h4>
                            <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/></svg>
                        </div>
                        
                        <div class="space-y-6">
                            @php
                                $totalResearch = $approvedStudentResearch->count() + $approvedFacultyResearch->count() + $approvedThesis->count() + $approvedDissertations->count();
                            @endphp
                            <div>
                                <div class="text-3xl font-black text-[#26225C] tracking-tighter leading-none">{{ number_format($totalResearch) }}</div>
                                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Total Publications</div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-50">
                                <div>
                                    <div class="text-xs font-black text-[#26225C] leading-none">{{ $approvedStudentResearch->count() }}</div>
                                    <div class="text-[9px] font-bold text-gray-400 uppercase tracking-tight mt-1">Student</div>
                                </div>
                                <div>
                                    <div class="text-xs font-black text-[#26225C] leading-none">{{ $approvedFacultyResearch->count() }}</div>
                                    <div class="text-[9px] font-bold text-gray-400 uppercase tracking-tight mt-1">Faculty</div>
                                </div>
                                <div>
                                    <div class="text-xs font-black text-[#26225C] leading-none">{{ $approvedThesis->count() }}</div>
                                    <div class="text-[9px] font-bold text-gray-400 uppercase tracking-tight mt-1">Thesis</div>
                                </div>
                                <div>
                                    <div class="text-xs font-black text-[#26225C] leading-none">{{ $approvedDissertations->count() }}</div>
                                    <div class="text-[9px] font-bold text-gray-400 uppercase tracking-tight mt-1">Dissert.</div>
                                </div>
                            </div>
                        </div>
                        
                        <a href="{{ route('research.by-department') }}" class="block mt-6 w-full text-center py-2 bg-gray-50 border border-gray-100 text-[10px] font-black text-[#26225C] uppercase tracking-[0.1em] hover:bg-[#26225C] hover:text-white transition rounded">
                            Download Report
                        </a>
                    </div>

                    <!-- Most Viewed Sidebar -->
                    @if(isset($mostViewed) && $mostViewed->count())
                    <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                        <h4 class="text-[10px] font-black text-[#26225C] uppercase tracking-[0.2em] mb-4">Trending Today</h4>
                        <div class="space-y-4">
                            @foreach($mostViewed->take(5) as $item)
                            <a href="{{ route(match($item->type ?? 'student'){'student'=>'student.show','faculty'=>'faculty.show','thesis'=>'thesis.show','dissertation'=>'dissertation.show',default=>'student.show'}, $item->id) }}" class="group block">
                                <h5 class="text-xs font-bold text-[#26225C] line-clamp-2 leading-tight group-hover:text-blue-600 transition">
                                    {{ $item->title }}
                                </h5>
                                <div class="text-[9px] font-bold text-gray-400 uppercase mt-1">
                                    {{ number_format((int)($item->views ?? 0)) }} viewers
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Footer Links -->
                    <div class="px-4 py-2 flex flex-wrap gap-x-4 gap-y-2 justify-center">
                        <a href="#" class="text-[10px] font-bold text-gray-400 hover:text-blue-600 hover:underline">Accessibility</a>
                        <a href="#" class="text-[10px] font-bold text-gray-400 hover:text-blue-600 hover:underline">Help Center</a>
                        <a href="#" class="text-[10px] font-bold text-gray-400 hover:text-blue-600 hover:underline">Privacy & Terms</a>
                    </div>
                    <div class="text-center">
                        <p class="text-[10px] font-black text-[#26225C] tracking-tighter">USPF <span class="text-[#FFC72C]">ARCHIVE</span> © 2024</p>
                    </div>
                </aside>
            </div>
        </div>
    </div>

    <script>
        // Search/Filter Functionality
        let searchTimeout;
        
        function filterByType(type) {
            const researchItems = document.querySelectorAll('.research-item');
            const searchInput = document.getElementById('researchSearchInput');
            const searchTerm = searchInput.value.trim().toLowerCase();
            const filterBtns = document.querySelectorAll('.category-filter-btn');
            
            // Update UI state of buttons
            filterBtns.forEach(btn => {
                btn.classList.remove('bg-gray-100', 'ring-1', 'ring-blue-500');
                if (btn.id === `filter-${type}`) {
                    btn.classList.add('bg-gray-100', 'ring-1', 'ring-blue-500');
                }
            });

            let visibleCount = 0;
            researchItems.forEach(item => {
                const itemType = item.getAttribute('data-type').toLowerCase();
                const searchText = item.getAttribute('data-search-text') || '';
                
                const typeMatch = (type === 'all' || itemType === type);
                const searchMatch = (searchTerm === '' || searchText.includes(searchTerm));
                
                if (typeMatch && searchMatch) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            showNoResultsMessage(visibleCount === 0);
            
            // Scroll to feed if mobile
            if (window.innerWidth < 768) {
                document.getElementById('researchFeed').scrollIntoView({ behavior: 'smooth' });
            }
        }

        function filterResearch() {
            const searchInput = document.getElementById('researchSearchInput');
            const searchTerm = searchInput.value.trim().toLowerCase();
            const activeFilterBtn = document.querySelector('.category-filter-btn.bg-gray-100');
            const activeType = activeFilterBtn ? activeFilterBtn.id.replace('filter-', '') : 'all';
            
            // Clear previous timeout for server submit
            clearTimeout(searchTimeout);
            
            const researchItems = document.querySelectorAll('.research-item');
            let visibleCount = 0;
            
            researchItems.forEach(item => {
                const itemType = item.getAttribute('data-type').toLowerCase();
                const searchText = item.getAttribute('data-search-text') || '';
                
                const typeMatch = (activeType === 'all' || itemType === activeType);
                const searchMatch = (searchTerm === '' || searchText.includes(searchTerm));
                
                if (typeMatch && searchMatch) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            showNoResultsMessage(visibleCount === 0 && (searchTerm.length > 0 || activeType !== 'all'));
            
            // Submit form to server after user stops typing
            searchTimeout = setTimeout(function() {
                if (searchTerm.length >= 2 || searchTerm.length === 0) {
                    // Only submit if not just client-side filtering
                    // document.getElementById('searchForm').submit(); 
                }
            }, 800); 
        }

        function showNoResultsMessage(show) {
            let noResultsMsg = document.getElementById('noResultsMessage');
            const feedContainer = document.getElementById('researchFeed');
            
            if (show && !noResultsMsg) {
                noResultsMsg = document.createElement('div');
                noResultsMsg.id = 'noResultsMessage';
                noResultsMsg.className = 'bg-white border border-gray-200 rounded-lg p-12 text-center shadow-sm';
                noResultsMsg.innerHTML = `
                    <div class="w-16 h-16 bg-gray-50 border border-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-sm font-black text-[#26225C] uppercase tracking-tighter mb-1">No research found</h3>
                    <p class="text-[11px] text-gray-400 font-bold uppercase tracking-widest">Try adjusting your search terms</p>
                `;
                feedContainer.appendChild(noResultsMsg);
            } else if (!show && noResultsMsg) {
                noResultsMsg.remove();
            }
        }

        // Initialize search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('researchSearchInput');
            
            if (searchInput) {
                searchInput.addEventListener('input', filterResearch);
                
                searchInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        clearTimeout(searchTimeout);
                        this.closest('form').submit();
                    }
                });
            }
            
            @if(!empty($searchQuery))
            const resultCount = document.querySelectorAll('.research-item:not([style*="display: none"])').length;
            if (resultCount === 0) {
                showNoResultsMessage(true);
            }
            @endif
        });
    </script>
</x-app-layout>
