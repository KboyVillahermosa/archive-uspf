<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            

            <!-- Quick Actions -->
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

            <!-- Research Archive Quick Link -->
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

            <!-- Research Grid - Combined Sections -->
            <section class="mb-12">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-light text-[#26225C] mb-1">Research Library</h2>
                        <p class="text-sm text-gray-500">Recently added and popular research</p>
                    </div>
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
                            <a href="{{ route($routeName, $item->id) }}" class="group bg-white rounded-xl p-5 border border-gray-200 hover:border-[#FFC72C] hover:shadow-lg transition-all duration-300">
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

            <!-- Approved Research -->
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
                            <a href="{{ route('student.show', $research->id) }}" class="group bg-white rounded-xl p-5 border border-gray-200 hover:border-[#FFC72C] hover:shadow-lg transition-all duration-300">
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
                            <a href="{{ route('faculty.show', $research->id) }}" class="group bg-white rounded-xl p-5 border border-gray-200 hover:border-[#FFC72C] hover:shadow-lg transition-all duration-300">
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
                            <a href="{{ route('thesis.show', $thesis->id) }}" class="group bg-white rounded-xl p-5 border border-gray-200 hover:border-[#FFC72C] hover:shadow-lg transition-all duration-300">
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
                            <a href="{{ route('dissertation.show', $dissertation->id) }}" class="group bg-white rounded-xl p-5 border border-gray-200 hover:border-[#FFC72C] hover:shadow-lg transition-all duration-300">
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
</x-app-layout>
