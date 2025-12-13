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
            
            <!-- Skeleton Loader for Quick Actions -->
            <div class="skeleton-container quick-actions-skeleton mb-12">
                <div class="mb-6">
                    <div class="skeleton skeleton-title w-48 mb-2"></div>
                    <div class="skeleton skeleton-text w-64"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @for($i = 0; $i < 4; $i++)
                    <div class="skeleton-card">
                        <div class="flex items-start justify-between mb-4">
                            <div class="skeleton w-12 h-12 rounded-xl"></div>
                            <div class="skeleton w-5 h-5 rounded"></div>
                        </div>
                        <div class="skeleton skeleton-text w-32 mb-2"></div>
                        <div class="skeleton skeleton-text w-40"></div>
                    </div>
                    @endfor
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="content-container quick-actions-content">
            <section class="mb-12">
            <section class="mb-12">
                <div class="flex items-center justify-between mb-6">
                        <div>
                        <h2 class="text-2xl font-light text-[#26225C] mb-1">Submit Research</h2>
                        <p class="text-sm text-gray-500">Choose a research type to begin your submission</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @if(auth()->user()->hasPermissionTo('create student-research') || auth()->user()->hasRole('admin'))
                    <a href="{{ route('student.upload') }}" class="group relative bg-white rounded-xl p-6 border border-gray-200 hover:border-[#FFC72C] hover:shadow-lg transition-all duration-300">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-[#26225C] to-[#3a3770] rounded-xl flex items-center justify-center shadow-sm">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                            </div>
                            <svg class="h-5 w-5 text-gray-300 group-hover:text-[#FFC72C] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        <h3 class="text-base font-semibold text-[#26225C] mb-1">Student Research</h3>
                        <p class="text-sm text-gray-500">Undergraduate research projects</p>
                        </a>
                        @endif

                        @if(auth()->user()->hasPermissionTo('create faculty-research') || auth()->user()->hasRole('admin'))
                    <a href="{{ route('faculty.upload') }}" class="group relative bg-white rounded-xl p-6 border border-gray-200 hover:border-[#FFC72C] hover:shadow-lg transition-all duration-300">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-[#26225C] to-[#3a3770] rounded-xl flex items-center justify-center shadow-sm">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                    </svg>
                            </div>
                            <svg class="h-5 w-5 text-gray-300 group-hover:text-[#FFC72C] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        <h3 class="text-base font-semibold text-[#26225C] mb-1">Faculty Research</h3>
                        <p class="text-sm text-gray-500">Academic publications</p>
                        </a>
                        @endif

                        @php
                            $canCreateThesis = false;
                            try {
                                $canCreateThesis = auth()->user()->hasPermissionTo('create thesis');
                            } catch (\Exception $e) {
                                $canCreateThesis = false;
                            }
                        @endphp
                        @if($canCreateThesis || auth()->user()->hasRole('admin'))
                    <a href="{{ route('thesis.upload') }}" class="group relative bg-white rounded-xl p-6 border border-gray-200 hover:border-[#FFC72C] hover:shadow-lg transition-all duration-300">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-[#26225C] to-[#3a3770] rounded-xl flex items-center justify-center shadow-sm">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                            </div>
                            <svg class="h-5 w-5 text-gray-300 group-hover:text-[#FFC72C] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        <h3 class="text-base font-semibold text-[#26225C] mb-1">Thesis</h3>
                        <p class="text-sm text-gray-500">Master's degree thesis</p>
                        </a>
                        @endif

                        @php
                            $canCreateDissertations = false;
                            try {
                                $canCreateDissertations = auth()->user()->hasPermissionTo('create dissertations');
                            } catch (\Exception $e) {
                                $canCreateDissertations = false;
                            }
                        @endphp
                        @if($canCreateDissertations || auth()->user()->hasRole('admin'))
                    <a href="{{ route('dissertations.upload') }}" class="group relative bg-white rounded-xl p-6 border border-gray-200 hover:border-[#FFC72C] hover:shadow-lg transition-all duration-300">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-[#26225C] to-[#3a3770] rounded-xl flex items-center justify-center shadow-sm">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                            </div>
                            <svg class="h-5 w-5 text-gray-300 group-hover:text-[#FFC72C] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        <h3 class="text-base font-semibold text-[#26225C] mb-1">Dissertation</h3>
                        <p class="text-sm text-gray-500">Doctoral dissertation</p>
                        </a>
                        @endif
                    </div>
                    
                    @php
                        $hasAnyUploadPermission = false;
                        $uploadPermissions = ['create student-research', 'create faculty-research', 'create thesis', 'create dissertations'];
                        foreach ($uploadPermissions as $perm) {
                            try {
                                if (auth()->user()->hasPermissionTo($perm)) {
                                    $hasAnyUploadPermission = true;
                                    break;
                                }
                            } catch (\Exception $e) {
                                // Permission doesn't exist, skip it
                            }
                        }
                    @endphp
                    @if(!$hasAnyUploadPermission && !auth()->user()->hasRole('admin'))
                <div class="mt-6 text-center py-4">
                    <p class="text-sm text-gray-500">No upload permissions assigned. Please contact your administrator.</p>
                    </div>
                    @endif
            </section>
            </div>

            <!-- Skeleton Loader for Research Archive -->
            <div class="skeleton-container archive-skeleton mb-12">
                <div class="mb-6">
                    <div class="skeleton skeleton-title w-48 mb-2"></div>
                    <div class="skeleton skeleton-text w-40"></div>
                </div>
                <div class="skeleton-card h-32"></div>
            </div>

            <!-- Research Archive Quick Link -->
            <div class="content-container archive-content">
            <section class="mb-12">
            <section class="mb-12">
                <div class="flex items-center justify-between mb-6">
                        <div>
                        <h2 class="text-2xl font-light text-[#26225C] mb-1">Research Archive</h2>
                        <p class="text-sm text-gray-500">Browse research by department</p>
                        </div>
                            @php
                                $totalResearch = $approvedStudentResearch->count() + $approvedFacultyResearch->count() + $approvedThesis->count() + $approvedDissertations->count();
                            @endphp
                    <div class="text-right">
                        <div class="text-3xl font-light text-[#26225C]">{{ number_format($totalResearch) }}</div>
                        <div class="text-xs text-gray-500 mt-0.5">Total Research</div>
                    </div>
                </div>
                <a href="{{ route('research.by-department') }}" class="group block bg-gradient-to-r from-[#26225C] to-[#3a3770] rounded-xl p-8 hover:shadow-xl transition-all duration-300">
                            <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-6">
                            <div class="w-16 h-16 bg-white bg-opacity-20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                            <div>
                                <h3 class="text-xl font-semibold text-white mb-1">Browse by Department</h3>
                                <p class="text-sm text-yellow-100 mb-3">Explore research organized by academic departments</p>
                                <div class="flex items-center space-x-4 text-sm text-white text-opacity-80">
                                            @if($approvedStudentResearch->count() > 0)
                                        <span>{{ $approvedStudentResearch->count() }} Student</span>
                                            @endif
                                            @if($approvedFacultyResearch->count() > 0)
                                        <span>{{ $approvedFacultyResearch->count() }} Faculty</span>
                                            @endif
                                            @if($approvedThesis->count() > 0)
                                        <span>{{ $approvedThesis->count() }} Thesis</span>
                                            @endif
                                            @if($approvedDissertations->count() > 0)
                                        <span>{{ $approvedDissertations->count() }} Dissertations</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                        <svg class="h-6 w-6 text-white text-opacity-60 group-hover:text-opacity-100 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                </a>
            </section>
            </div>

            <!-- Skeleton Loader for Research Library -->
            <div class="skeleton-container research-library-skeleton mb-12">
                <div class="mb-6">
                    <div class="skeleton skeleton-title w-48 mb-2"></div>
                    <div class="skeleton skeleton-text w-56"></div>
                </div>
                <!-- Recently Added Skeleton -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <div class="skeleton skeleton-text w-32"></div>
                        <div class="skeleton skeleton-text w-20"></div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @for($i = 0; $i < 6; $i++)
                        <div class="skeleton-card">
                            <div class="flex items-center justify-between mb-3">
                                <div class="skeleton h-6 w-20 rounded-full"></div>
                                <div class="skeleton h-4 w-16"></div>
                            </div>
                            <div class="skeleton skeleton-text w-full mb-2"></div>
                            <div class="skeleton skeleton-text w-3/4 mb-3"></div>
                            <div class="skeleton skeleton-text w-24"></div>
                        </div>
                        @endfor
                    </div>
                </div>
                <!-- Most Viewed Skeleton -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <div class="skeleton skeleton-text w-32"></div>
                        <div class="skeleton skeleton-text w-20"></div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @for($i = 0; $i < 6; $i++)
                        <div class="skeleton-card">
                            <div class="flex items-center justify-between mb-3">
                                <div class="skeleton h-6 w-20 rounded-full"></div>
                                <div class="skeleton h-4 w-16"></div>
                            </div>
                            <div class="skeleton skeleton-text w-full mb-2"></div>
                            <div class="skeleton skeleton-text w-3/4 mb-3"></div>
                            <div class="skeleton skeleton-text w-24"></div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Research Grid - Combined Sections -->
            <div class="content-container research-library-content">
            <section class="mb-12">
            <section class="mb-12">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                        <div>
                        <h2 class="text-2xl font-light text-[#26225C] mb-1">Research Library</h2>
                        <p class="text-sm text-gray-500">Recently added and popular research</p>
                    </div>
                    
                    <!-- Search Bar -->
                    <form method="GET" action="{{ route('dashboard') }}" id="searchForm" class="relative w-full md:w-96">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            name="search"
                            id="researchSearchInput" 
                            value="{{ $searchQuery ?? '' }}"
                            placeholder="Search by title, author, keywords, department..." 
                            class="block w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#FFC72C] focus:border-[#FFC72C] text-sm"
                        >
                        <button 
                            type="button"
                            id="clearSearchBtn" 
                            class="absolute inset-y-0 right-0 pr-3 items-center {{ !empty($searchQuery) ? 'flex' : 'hidden' }}"
                            onclick="clearSearch()"
                        >
                            <svg class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </form>
                </div>

                <!-- Recently Added -->
                @if(isset($mostRecent) && $mostRecent->count())
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-[#26225C]">Recently Added</h3>
                        <span class="text-sm text-gray-500">{{ $mostRecent->count() }} items</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
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
                            @endphp
                            <a href="{{ route($routeName, $item->id) }}" 
                               class="research-item group bg-white rounded-xl p-5 border border-gray-200 hover:border-[#FFC72C] hover:shadow-lg transition-all duration-300"
                               data-search-text="{{ strtolower($item->title . ' ' . ($item->authors ?? $item->author ?? '') . ' ' . ($item->department ?? '') . ' ' . ($item->tags ?? $item->keywords ?? '')) }}">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs font-medium px-3 py-1 rounded-full bg-[#26225C] bg-opacity-10 text-[#26225C] border border-[#FFC72C] border-opacity-30">{{ ucfirst($type) }}</span>
                                    <span class="text-xs text-gray-400">{{ optional($item->approved_at)->diffForHumans() }}</span>
                                </div>
                                <h4 class="text-sm font-semibold text-[#26225C] mb-2 line-clamp-2 leading-snug group-hover:text-[#FFC72C] transition-colors">{{ Str::limit($item->title, 70) }}</h4>
                                <div class="flex items-center text-xs text-gray-500 mt-3">
                                    <span>View details</span>
                                    <svg class="h-3 w-3 ml-1.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </a>
                        @endforeach
                </div>
            </div>
            @endif

            <!-- Most Viewed -->
            @if(isset($mostViewed) && $mostViewed->count())
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-[#26225C]">Most Viewed</h3>
                        <span class="text-sm text-gray-500">{{ $mostViewed->count() }} items</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($mostViewed as $item)
                            @php
                                $type = $item->type ?? 'student';
                                $routeName = match($type) {
                                    'student' => 'student.show',
                                    'faculty' => 'faculty.show',
                                    'thesis' => 'thesis.show',
                                    'dissertation' => 'dissertation.show',
                                    default => 'student.show',
                                };
                            @endphp
                            <a href="{{ route($routeName, $item->id) }}" class="group bg-white rounded-xl p-5 border border-gray-200 hover:border-[#FFC72C] hover:shadow-lg transition-all duration-300">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs font-medium px-3 py-1 rounded-full bg-[#26225C] bg-opacity-10 text-[#26225C] border border-[#FFC72C] border-opacity-30">{{ ucfirst($type) }}</span>
                                    <div class="flex items-center text-xs text-gray-500">
                                        <svg class="h-3.5 w-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        {{ number_format((int)($item->views ?? 0)) }}
                                    </div>
                                </div>
                                <h4 class="text-sm font-semibold text-[#26225C] mb-2 line-clamp-2 leading-snug group-hover:text-[#FFC72C] transition-colors">{{ Str::limit($item->title, 70) }}</h4>
                                <div class="flex items-center text-xs text-gray-500 mt-3">
                                    <span>View details</span>
                                    <svg class="h-3 w-3 ml-1.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </section>
            </div>

            <!-- Skeleton Loader for Approved Research -->
            <div class="skeleton-container approved-research-skeleton">
                <div class="mb-6">
                    <div class="skeleton skeleton-title w-48 mb-2"></div>
                    <div class="skeleton skeleton-text w-64"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @for($i = 0; $i < 6; $i++)
                    <div class="skeleton-card">
                        <div class="flex items-center mb-3">
                            <div class="skeleton w-10 h-10 rounded-lg mr-3"></div>
                            <div class="skeleton h-6 w-20 rounded-full"></div>
                        </div>
                        <div class="skeleton skeleton-text w-full mb-2"></div>
                        <div class="skeleton skeleton-text w-3/4 mb-2"></div>
                        <div class="skeleton skeleton-text w-1/2 mb-3"></div>
                        <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                            <div class="skeleton skeleton-text w-20"></div>
                            <div class="skeleton w-4 h-4 rounded"></div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>

            <!-- Approved Research -->
            <div class="content-container approved-research-content">
            <section>
            <section>
                <div class="flex items-center justify-between mb-6">
                        <div>
                        <h2 class="text-2xl font-light text-[#26225C] mb-1">Approved Research</h2>
                        <p class="text-sm text-gray-500">Latest research approved by administrators</p>
                    </div>
                </div>
                
                    @if($approvedStudentResearch->count() > 0 || $approvedFacultyResearch->count() > 0 || $approvedThesis->count() > 0 || $approvedDissertations->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <!-- Student Research -->
                            @foreach($approvedStudentResearch as $research)
                            <a href="{{ route('student.show', $research->id) }}" 
                               class="research-item group bg-white rounded-xl p-5 border border-gray-200 hover:border-[#FFC72C] hover:shadow-lg transition-all duration-300"
                               data-search-text="{{ strtolower($research->title . ' ' . $research->authors . ' ' . $research->department . ' ' . $research->program . ' ' . ($research->tags ?? '')) }}">
                                <div class="flex items-center mb-3">
                                    <div class="w-10 h-10 bg-[#26225C] bg-opacity-10 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="h-5 w-5 text-[#26225C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                    </div>
                                    <span class="text-xs font-medium px-3 py-1 rounded-full bg-[#FFC72C] bg-opacity-20 text-[#26225C] border border-[#FFC72C] border-opacity-30">Student</span>
                                </div>
                                <h4 class="text-sm font-semibold text-[#26225C] mb-2 line-clamp-2 leading-snug group-hover:text-[#FFC72C] transition-colors">{{ Str::limit($research->title, 60) }}</h4>
                                <p class="text-xs text-gray-600 mb-2 line-clamp-1">{{ Str::limit($research->authors, 50) }}</p>
                                <p class="text-xs text-gray-500 mb-3">{{ Str::limit($research->department, 30) }} • {{ Str::limit($research->program, 25) }}</p>
                                <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                    <span class="text-xs text-gray-500">{{ $research->approved_at->diffForHumans() }}</span>
                                    <svg class="h-4 w-4 text-gray-400 group-hover:text-[#FFC72C] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </a>
                            @endforeach

                            <!-- Faculty Research -->
                            @foreach($approvedFacultyResearch as $research)
                            <a href="{{ route('faculty.show', $research->id) }}" 
                               class="research-item group bg-white rounded-xl p-5 border border-gray-200 hover:border-[#FFC72C] hover:shadow-lg transition-all duration-300"
                               data-search-text="{{ strtolower($research->title . ' ' . $research->user->name . ' ' . ($research->co_researchers ?? '') . ' ' . $research->department . ' ' . ($research->tags ?? '')) }}">
                                <div class="flex items-center mb-3">
                                    <div class="w-10 h-10 bg-[#26225C] bg-opacity-10 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="h-5 w-5 text-[#26225C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                            </svg>
                                    </div>
                                    <span class="text-xs font-medium px-3 py-1 rounded-full bg-[#FFC72C] bg-opacity-20 text-[#26225C] border border-[#FFC72C] border-opacity-30">Faculty</span>
                                </div>
                                <h4 class="text-sm font-semibold text-[#26225C] mb-2 line-clamp-2 leading-snug group-hover:text-[#FFC72C] transition-colors">{{ Str::limit($research->title, 60) }}</h4>
                                <p class="text-xs text-gray-600 mb-2">Lead: {{ $research->user->name }}</p>
                                    @if($research->co_researchers)
                                    <p class="text-xs text-gray-500 mb-2 line-clamp-1">Co-researchers: {{ Str::limit($research->co_researchers, 40) }}</p>
                                    @endif
                                <p class="text-xs text-gray-500 mb-3">{{ Str::limit($research->department, 40) }}</p>
                                <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                    <span class="text-xs text-gray-500">{{ $research->approved_at->diffForHumans() }}</span>
                                    <svg class="h-4 w-4 text-gray-400 group-hover:text-[#FFC72C] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </a>
                            @endforeach

                            <!-- Thesis -->
                            @foreach($approvedThesis as $thesis)
                            <a href="{{ route('thesis.show', $thesis->id) }}" 
                               class="research-item group bg-white rounded-xl p-5 border border-gray-200 hover:border-[#FFC72C] hover:shadow-lg transition-all duration-300"
                               data-search-text="{{ strtolower($thesis->title . ' ' . $thesis->author . ' ' . $thesis->department . ' ' . ($thesis->program ?? '') . ' ' . ($thesis->keywords ?? '')) }}">
                                <div class="flex items-center mb-3">
                                    <div class="w-10 h-10 bg-[#26225C] bg-opacity-10 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="h-5 w-5 text-[#26225C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                    </div>
                                    <span class="text-xs font-medium px-3 py-1 rounded-full bg-[#FFC72C] bg-opacity-20 text-[#26225C] border border-[#FFC72C] border-opacity-30">Thesis</span>
                                </div>
                                <h4 class="text-sm font-semibold text-[#26225C] mb-2 line-clamp-2 leading-snug group-hover:text-[#FFC72C] transition-colors">{{ Str::limit($thesis->title, 60) }}</h4>
                                <p class="text-xs text-gray-600 mb-2">{{ $thesis->author }}</p>
                                <p class="text-xs text-gray-500 mb-3">{{ Str::limit($thesis->department, 30) }} • {{ $thesis->year_completed }}</p>
                                <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                    <span class="text-xs text-gray-500">{{ $thesis->approved_at->diffForHumans() }}</span>
                                    <svg class="h-4 w-4 text-gray-400 group-hover:text-[#FFC72C] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </a>
                            @endforeach

                            <!-- Dissertations -->
                            @foreach($approvedDissertations as $dissertation)
                            <a href="{{ route('dissertation.show', $dissertation->id) }}" 
                               class="research-item group bg-white rounded-xl p-5 border border-gray-200 hover:border-[#FFC72C] hover:shadow-lg transition-all duration-300"
                               data-search-text="{{ strtolower($dissertation->title . ' ' . $dissertation->author . ' ' . $dissertation->department . ' ' . ($dissertation->program ?? '') . ' ' . ($dissertation->keywords ?? '')) }}">
                                <div class="flex items-center mb-3">
                                    <div class="w-10 h-10 bg-[#26225C] bg-opacity-10 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="h-5 w-5 text-[#26225C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                    </div>
                                    <span class="text-xs font-medium px-3 py-1 rounded-full bg-[#FFC72C] bg-opacity-20 text-[#26225C] border border-[#FFC72C] border-opacity-30">Dissertation</span>
                                </div>
                                <h4 class="text-sm font-semibold text-[#26225C] mb-2 line-clamp-2 leading-snug group-hover:text-[#FFC72C] transition-colors">{{ Str::limit($dissertation->title, 60) }}</h4>
                                <p class="text-xs text-gray-600 mb-2">{{ $dissertation->author }}</p>
                                <p class="text-xs text-gray-500 mb-3">{{ Str::limit($dissertation->department, 30) }} • {{ $dissertation->year_completed }}</p>
                                <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                    <span class="text-xs text-gray-500">{{ $dissertation->approved_at->diffForHumans() }}</span>
                                    <svg class="h-4 w-4 text-gray-400 group-hover:text-[#FFC72C] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                    <div class="text-center py-16 bg-white rounded-xl border border-gray-200">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No approved research yet</h3>
                        <p class="text-sm text-gray-500">Submit your research for review by administrators</p>
                        </div>
                    @endif
            </section>
            </div>

        </div>
    </div>

    <script>
        // Skeleton Loader Management
        document.addEventListener('DOMContentLoaded', function() {
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

        // Search/Filter Functionality
        let searchTimeout;
        
        function filterResearch() {
            const searchInput = document.getElementById('researchSearchInput');
            const clearBtn = document.getElementById('clearSearchBtn');
            const searchForm = document.getElementById('searchForm');
            const searchTerm = searchInput.value.trim();
            const searchLower = searchTerm.toLowerCase();
            
            // Show/hide clear button
            if (searchTerm.length > 0) {
                clearBtn.classList.remove('hidden');
                clearBtn.classList.add('flex');
            } else {
                clearBtn.classList.add('hidden');
                clearBtn.classList.remove('flex');
            }
            
            // Clear previous timeout
            clearTimeout(searchTimeout);
            
            // Client-side filtering for instant feedback
            const researchItems = document.querySelectorAll('.research-item');
            let visibleCount = 0;
            
            researchItems.forEach(item => {
                const searchText = item.getAttribute('data-search-text') || '';
                
                if (searchTerm === '' || searchText.includes(searchLower)) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Show "No results" message if needed
            showNoResultsMessage(visibleCount === 0 && searchTerm.length > 0);
            
            // Submit form to server after user stops typing (for accurate server-side search)
            searchTimeout = setTimeout(function() {
                if (searchTerm.length >= 2 || searchTerm.length === 0) {
                    searchForm.submit();
                }
            }, 800); // Wait 800ms after user stops typing
        }

        function clearSearch() {
            const searchInput = document.getElementById('researchSearchInput');
            const clearBtn = document.getElementById('clearSearchBtn');
            const searchForm = document.getElementById('searchForm');
            
            searchInput.value = '';
            clearBtn.classList.add('hidden');
            clearBtn.classList.remove('flex');
            
            // Show all items immediately
            const researchItems = document.querySelectorAll('.research-item');
            researchItems.forEach(item => {
                item.style.display = '';
            });
            
            showNoResultsMessage(false);
            
            // Submit form to clear server-side search
            searchForm.submit();
        }

        function showNoResultsMessage(show) {
            let noResultsMsg = document.getElementById('noResultsMessage');
            
            if (show && !noResultsMsg) {
                // Create no results message
                noResultsMsg = document.createElement('div');
                noResultsMsg.id = 'noResultsMessage';
                noResultsMsg.className = 'col-span-full text-center py-16 bg-white rounded-xl border border-gray-200';
                noResultsMsg.innerHTML = `
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No research found</h3>
                    <p class="text-sm text-gray-500">Try adjusting your search terms</p>
                `;
                
                // Find the first grid container and append the message
                const firstGrid = document.querySelector('.grid.grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-3');
                if (firstGrid) {
                    firstGrid.appendChild(noResultsMsg);
                }
            } else if (!show && noResultsMsg) {
                noResultsMsg.remove();
            }
        }

        // Initialize search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('researchSearchInput');
            const searchForm = document.getElementById('searchForm');
            
            if (searchInput) {
                // Search on input (with debounce)
                searchInput.addEventListener('input', filterResearch);
                
                // Submit form on Enter key
                searchInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        clearTimeout(searchTimeout);
                        searchForm.submit();
                    }
                });
            }
            
            // If there's a search query, show results count
            @if(!empty($searchQuery))
            const resultCount = document.querySelectorAll('.research-item:not([style*="display: none"])').length;
            if (resultCount === 0) {
                showNoResultsMessage(true);
            }
            @endif
        });
    </script>
</x-app-layout>
