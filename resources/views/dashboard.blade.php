<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Welcome back, {{ Auth::user()->name }}! Here's what's happening in your research archive.</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="text-right">
                    <div class="text-sm text-gray-500">Today</div>
                    <div class="text-lg font-semibold text-gray-900">{{ now()->format('M d, Y') }}</div>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Quick Upload Section -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-[#26225C] to-[#1a1840] px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-white mb-2">Upload Research</h3>
                            <p class="text-yellow-200 text-sm">Share your academic work with the community</p>
                        </div>
                        <div class="w-16 h-16 bg-yellow-400 rounded-2xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-[#26225C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <a href="{{ route('student.upload') }}" class="group bg-gradient-to-br from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 p-6 rounded-xl border border-blue-200 hover:border-blue-300 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 group-hover:text-blue-800">Student Research</h4>
                                    <p class="text-xs text-blue-600 font-medium">Undergraduate</p>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 group-hover:text-gray-700">Submit undergraduate research projects and capstone studies</p>
                            <div class="mt-4 flex items-center text-blue-600 text-sm font-medium">
                                <span>Start Upload</span>
                                <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </a>

                        <a href="{{ route('faculty.upload') }}" class="group bg-gradient-to-br from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 p-6 rounded-xl border border-purple-200 hover:border-purple-300 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 group-hover:text-purple-800">Faculty Research</h4>
                                    <p class="text-xs text-purple-600 font-medium">Academic</p>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 group-hover:text-gray-700">Submit faculty research publications and studies</p>
                            <div class="mt-4 flex items-center text-purple-600 text-sm font-medium">
                                <span>Start Upload</span>
                                <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </a>

                        <a href="{{ route('thesis.upload') }}" class="group bg-gradient-to-br from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 p-6 rounded-xl border border-green-200 hover:border-green-300 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 group-hover:text-green-800">Thesis</h4>
                                    <p class="text-xs text-green-600 font-medium">Master's</p>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 group-hover:text-gray-700">Submit master's level thesis and research</p>
                            <div class="mt-4 flex items-center text-green-600 text-sm font-medium">
                                <span>Start Upload</span>
                                <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </a>

                        <a href="{{ route('dissertations.upload') }}" class="group bg-gradient-to-br from-red-50 to-red-100 hover:from-red-100 hover:to-red-200 p-6 rounded-xl border border-red-200 hover:border-red-300 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 group-hover:text-red-800">Dissertation</h4>
                                    <p class="text-xs text-red-600 font-medium">Doctoral</p>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 group-hover:text-gray-700">Submit doctoral level dissertation and research</p>
                            <div class="mt-4 flex items-center text-red-600 text-sm font-medium">
                                <span>Start Upload</span>
                                <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Research by Department Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-50 to-blue-50 px-8 py-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Research by Department</h3>
                            <p class="text-gray-600 text-sm">Explore research organized by academic departments and colleges</p>
                        </div>
                        <div class="text-right">
                            @php
                                $totalResearch = $approvedStudentResearch->count() + $approvedFacultyResearch->count() + $approvedThesis->count() + $approvedDissertations->count();
                                $activeDepartments = collect([
                                    'College of Engineering and Architecture',
                                    'College of Computer Studies', 
                                    'College of Health Sciences',
                                    'College of Social Work',
                                    'College of Teacher Education, Arts and Sciences',
                                    'School of Business and Accountancy',
                                    'Graduate School'
                                ])->filter(function($dept) use ($approvedStudentResearch, $approvedFacultyResearch, $approvedThesis, $approvedDissertations) {
                                    return $approvedStudentResearch->where('department', $dept)->count() > 0 ||
                                           $approvedFacultyResearch->where('department', $dept)->count() > 0 ||
                                           $approvedThesis->where('department', $dept)->count() > 0 ||
                                           $approvedDissertations->where('department', $dept)->count() > 0;
                                })->count();
                            @endphp
                            <div class="text-3xl font-bold text-indigo-600">{{ $totalResearch }}</div>
                            <div class="text-sm text-gray-600 font-medium">Total Research</div>
                            <div class="text-xs text-gray-500 mt-1">{{ $activeDepartments }} Active Departments</div>
                        </div>
                    </div>
                </div>
                
                <div class="p-8">
                    <a href="{{ route('research.by-department') }}" class="block w-full">
                        <div class="bg-gradient-to-r from-indigo-50 to-blue-50 border border-indigo-200 rounded-2xl p-8 hover:from-indigo-100 hover:to-blue-100 hover:border-indigo-300 transition-all duration-300 hover:shadow-xl group">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="p-4 bg-indigo-500 rounded-2xl group-hover:bg-indigo-600 group-hover:scale-110 transition-all duration-300">
                                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-6">
                                        <h4 class="text-xl font-bold text-gray-900 group-hover:text-indigo-800 transition-colors">Browse by Department</h4>
                                        <p class="text-gray-600 mt-2">View all research organized by academic departments and colleges</p>
                                        
                                        <!-- Quick Stats -->
                                        <div class="flex items-center space-x-6 mt-4">
                                            @if($approvedStudentResearch->count() > 0)
                                                <div class="flex items-center text-sm text-blue-600 font-medium">
                                                    <div class="w-3 h-3 bg-blue-400 rounded-full mr-2"></div>
                                                    {{ $approvedStudentResearch->count() }} Student
                                                </div>
                                            @endif
                                            @if($approvedFacultyResearch->count() > 0)
                                                <div class="flex items-center text-sm text-purple-600 font-medium">
                                                    <div class="w-3 h-3 bg-purple-400 rounded-full mr-2"></div>
                                                    {{ $approvedFacultyResearch->count() }} Faculty
                                                </div>
                                            @endif
                                            @if($approvedThesis->count() > 0)
                                                <div class="flex items-center text-sm text-green-600 font-medium">
                                                    <div class="w-3 h-3 bg-green-400 rounded-full mr-2"></div>
                                                    {{ $approvedThesis->count() }} Thesis
                                                </div>
                                            @endif
                                            @if($approvedDissertations->count() > 0)
                                                <div class="flex items-center text-sm text-red-600 font-medium">
                                                    <div class="w-3 h-3 bg-red-400 rounded-full mr-2"></div>
                                                    {{ $approvedDissertations->count() }} Dissertations
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center text-indigo-600 group-hover:text-indigo-800 transition-colors">
                                    <span class="text-lg font-semibold mr-3">Explore</span>
                                    <svg class="h-6 w-6 transform group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Most Recent -->
            @if(isset($mostRecent) && $mostRecent->count())
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-8 py-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Most Recent</h3>
                            <p class="text-gray-600 text-sm">Latest research submissions to the archive</p>
                        </div>
                        <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($mostRecent as $item)
                            @php
                                $type = $item->type ?? 'student';
                                $badgeClasses = [
                                    'student' => 'text-blue-600 bg-blue-100 border-blue-200',
                                    'faculty' => 'text-purple-600 bg-purple-100 border-purple-200',
                                    'thesis' => 'text-green-600 bg-green-100 border-green-200',
                                    'dissertation' => 'text-red-600 bg-red-100 border-red-200',
                                ][$type] ?? 'text-gray-600 bg-gray-100 border-gray-200';

                                $routeName = match($type) {
                                    'student' => 'student.show',
                                    'faculty' => 'faculty.show',
                                    'thesis' => 'thesis.show',
                                    'dissertation' => 'dissertation.show',
                                    default => 'student.show',
                                };
                            @endphp

                            <a href="{{ route($routeName, $item->id) }}" class="group block bg-white p-6 rounded-xl border border-gray-200 hover:shadow-xl hover:border-gray-300 transition-all duration-300 hover:-translate-y-1">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-xs font-semibold px-3 py-1 rounded-full border {{ $badgeClasses }}">{{ ucfirst($type) }}</span>
                                    <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">{{ optional($item->approved_at)->diffForHumans() }}</span>
                                </div>
                                <h4 class="font-semibold text-gray-900 mb-3 group-hover:text-gray-700 transition-colors">{{ Str::limit($item->title, 60) }}</h4>
                                <div class="flex items-center text-gray-500 text-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                    <span>View Details</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Most Viewed -->
            @if(isset($mostViewed) && $mostViewed->count())
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-orange-50 to-amber-50 px-8 py-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Most Viewed</h3>
                            <p class="text-gray-600 text-sm">Popular research papers and studies</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($mostViewed as $item)
                            @php
                                $type = $item->type ?? 'student';
                                $badgeClasses = [
                                    'student' => 'text-blue-600 bg-blue-100 border-blue-200',
                                    'faculty' => 'text-purple-600 bg-purple-100 border-purple-200',
                                    'thesis' => 'text-green-600 bg-green-100 border-green-200',
                                    'dissertation' => 'text-red-600 bg-red-100 border-red-200',
                                ][$type] ?? 'text-gray-600 bg-gray-100 border-gray-200';

                                $routeName = match($type) {
                                    'student' => 'student.show',
                                    'faculty' => 'faculty.show',
                                    'thesis' => 'thesis.show',
                                    'dissertation' => 'dissertation.show',
                                    default => 'student.show',
                                };
                            @endphp

                            <a href="{{ route($routeName, $item->id) }}" class="group block bg-white p-6 rounded-xl border border-gray-200 hover:shadow-xl hover:border-gray-300 transition-all duration-300 hover:-translate-y-1">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-xs font-semibold px-3 py-1 rounded-full border {{ $badgeClasses }}">{{ ucfirst($type) }}</span>
                                    <div class="flex items-center text-orange-600 text-sm font-medium">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        {{ (int)($item->views ?? 0) }} views
                                    </div>
                                </div>
                                <h4 class="font-semibold text-gray-900 mb-3 group-hover:text-gray-700 transition-colors">{{ Str::limit($item->title, 60) }}</h4>
                                <div class="flex items-center text-gray-500 text-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                    <span>View Details</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Most Popular -->
            @if(isset($mostPopular) && $mostPopular->count())
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-pink-50 to-rose-50 px-8 py-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Most Popular</h3>
                            <p class="text-gray-600 text-sm">Top downloaded and viewed research</p>
                        </div>
                        <div class="w-12 h-12 bg-pink-500 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($mostPopular as $item)
                            @php
                                $type = $item->type ?? 'student';
                                $badgeClasses = [
                                    'student' => 'text-blue-600 bg-blue-100 border-blue-200',
                                    'faculty' => 'text-purple-600 bg-purple-100 border-purple-200',
                                    'thesis' => 'text-green-600 bg-green-100 border-green-200',
                                    'dissertation' => 'text-red-600 bg-red-100 border-red-200',
                                ][$type] ?? 'text-gray-600 bg-gray-100 border-gray-200';

                                $routeName = match($type) {
                                    'student' => 'student.show',
                                    'faculty' => 'faculty.show',
                                    'thesis' => 'thesis.show',
                                    'dissertation' => 'dissertation.show',
                                    default => 'student.show',
                                };

                                $views = (int) ($item->views ?? 0);
                                $downloads = (int) ($item->downloads ?? 0);
                            @endphp

                            <a href="{{ route($routeName, $item->id) }}" class="group block bg-white p-6 rounded-xl border border-gray-200 hover:shadow-xl hover:border-gray-300 transition-all duration-300 hover:-translate-y-1">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-xs font-semibold px-3 py-1 rounded-full border {{ $badgeClasses }}">{{ ucfirst($type) }}</span>
                                    <div class="flex items-center space-x-3 text-sm">
                                        <div class="flex items-center text-pink-600 font-medium">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            {{ $downloads }}
                                        </div>
                                        <div class="flex items-center text-gray-500 font-medium">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            {{ $views }}
                                        </div>
                                    </div>
                                </div>
                                <h4 class="font-semibold text-gray-900 mb-3 group-hover:text-gray-700 transition-colors">{{ Str::limit($item->title, 60) }}</h4>
                                <div class="flex items-center text-gray-500 text-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                    <span>View Details</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Recent Approved Research Section -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-slate-50 to-gray-50 px-8 py-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Recent Approved Research</h3>
                            <p class="text-gray-600 text-sm">Latest research approved by administrators</p>
                        </div>
                        <div class="w-12 h-12 bg-slate-500 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="p-8">
                    @if($approvedStudentResearch->count() > 0 || $approvedFacultyResearch->count() > 0 || $approvedThesis->count() > 0 || $approvedDissertations->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Student Research -->
                            @foreach($approvedStudentResearch as $research)
                                <a href="{{ route('student.show', $research->id) }}" class="group block bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-xl border border-blue-200 hover:shadow-xl hover:from-blue-100 hover:to-blue-200 hover:border-blue-300 transition-all duration-300 hover:-translate-y-1">
                                    <div class="flex items-center mb-4">
                                        <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                        </div>
                                        <span class="text-xs font-semibold text-blue-600 bg-blue-100 px-3 py-1 rounded-full border border-blue-200">Student Research</span>
                                    </div>
                                    <h4 class="font-semibold text-gray-900 mb-3 group-hover:text-blue-800 transition-colors">{{ Str::limit($research->title, 50) }}</h4>
                                    <p class="text-sm text-gray-600 mb-2">By: {{ Str::limit($research->authors, 40) }}</p>
                                    <p class="text-xs text-gray-500 mb-3">{{ $research->department }} • {{ $research->program }}</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-blue-600 font-medium bg-blue-100 px-2 py-1 rounded-full">Approved {{ $research->approved_at->diffForHumans() }}</span>
                                        <svg class="h-4 w-4 text-blue-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </a>
                            @endforeach

                            <!-- Faculty Research -->
                            @foreach($approvedFacultyResearch as $research)
                                <a href="{{ route('faculty.show', $research->id) }}" class="group block bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-xl border border-purple-200 hover:shadow-xl hover:from-purple-100 hover:to-purple-200 hover:border-purple-300 transition-all duration-300 hover:-translate-y-1">
                                    <div class="flex items-center mb-4">
                                        <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                            </svg>
                                        </div>
                                        <span class="text-xs font-semibold text-purple-600 bg-purple-100 px-3 py-1 rounded-full border border-purple-200">Faculty Research</span>
                                    </div>
                                    <h4 class="font-semibold text-gray-900 mb-3 group-hover:text-purple-800 transition-colors">{{ Str::limit($research->title, 50) }}</h4>
                                    <p class="text-sm text-gray-600 mb-2">Lead: {{ $research->user->name }}</p>
                                    @if($research->co_researchers)
                                        <p class="text-xs text-gray-500 mb-2">Co-researchers: {{ Str::limit($research->co_researchers, 40) }}</p>
                                    @endif
                                    <p class="text-xs text-gray-500 mb-3">{{ $research->department }}</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-purple-600 font-medium bg-purple-100 px-2 py-1 rounded-full">Approved {{ $research->approved_at->diffForHumans() }}</span>
                                        <svg class="h-4 w-4 text-purple-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </a>
                            @endforeach

                            <!-- Thesis -->
                            @foreach($approvedThesis as $thesis)
                                <a href="{{ route('thesis.show', $thesis->id) }}" class="group block bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-xl border border-green-200 hover:shadow-xl hover:from-green-100 hover:to-green-200 hover:border-green-300 transition-all duration-300 hover:-translate-y-1">
                                    <div class="flex items-center mb-4">
                                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <span class="text-xs font-semibold text-green-600 bg-green-100 px-3 py-1 rounded-full border border-green-200">Thesis</span>
                                    </div>
                                    <h4 class="font-semibold text-gray-900 mb-3 group-hover:text-green-800 transition-colors">{{ Str::limit($thesis->title, 50) }}</h4>
                                    <p class="text-sm text-gray-600 mb-2">By: {{ $thesis->author }}</p>
                                    <p class="text-xs text-gray-500 mb-3">{{ $thesis->department }} • {{ $thesis->year_completed }}</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-green-600 font-medium bg-green-100 px-2 py-1 rounded-full">Approved {{ $thesis->approved_at->diffForHumans() }}</span>
                                        <svg class="h-4 w-4 text-green-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </a>
                            @endforeach

                            <!-- Dissertations -->
                            @foreach($approvedDissertations as $dissertation)
                                <a href="{{ route('dissertation.show', $dissertation->id) }}" class="group block bg-gradient-to-br from-red-50 to-red-100 p-6 rounded-xl border border-red-200 hover:shadow-xl hover:from-red-100 hover:to-red-200 hover:border-red-300 transition-all duration-300 hover:-translate-y-1">
                                    <div class="flex items-center mb-4">
                                        <div class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <span class="text-xs font-semibold text-red-600 bg-red-100 px-3 py-1 rounded-full border border-red-200">Dissertation</span>
                                    </div>
                                    <h4 class="font-semibold text-gray-900 mb-3 group-hover:text-red-800 transition-colors">{{ Str::limit($dissertation->title, 50) }}</h4>
                                    <p class="text-sm text-gray-600 mb-2">By: {{ $dissertation->author }}</p>
                                    <p class="text-xs text-gray-500 mb-3">{{ $dissertation->department }} • {{ $dissertation->year_completed }}</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-red-600 font-medium bg-red-100 px-2 py-1 rounded-full">Approved {{ $dissertation->approved_at->diffForHumans() }}</span>
                                        <svg class="h-4 w-4 text-red-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        
                        <!-- View All Link -->
                        <div class="mt-8 text-center">
                            <a href="#" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-[#26225C] font-semibold rounded-xl transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                                View All Research
                            </a>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No approved research yet</h3>
                            <p class="text-gray-600 mb-4">Submit your research for review by the admin</p>
                            <a href="#" class="inline-flex items-center px-4 py-2 bg-[#26225C] hover:bg-[#1a1840] text-white font-medium rounded-lg transition-colors duration-200">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Upload Research
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleDepartment(slug) {
            const content = document.getElementById('content-' + slug);
            const icon = document.getElementById('icon-' + slug);
            
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                content.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }
    </script>
</x-app-layout>
