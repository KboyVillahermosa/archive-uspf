<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Welcome, {{ Auth::user()->name }}!</h3>
                    
                    @if(Auth::user()->student)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium text-gray-800 mb-3">Student Information</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600">ID Number</p>
                                    <p class="font-medium">{{ Auth::user()->student->id_number }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Full Name</p>
                                    <p class="font-medium">{{ Auth::user()->student->full_name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Birthday</p>
                                    <p class="font-medium">{{ Auth::user()->student->birthday->format('F j, Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Course and Year</p>
                                    <p class="font-medium">{{ Auth::user()->student->course_and_year }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Upload Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">Upload Research</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="{{ route('student.upload') }}" class="group bg-blue-50 hover:bg-blue-100 p-4 rounded-lg border border-blue-200 transition duration-200">
                            <div class="flex items-center mb-2">
                                <svg class="h-6 w-6 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                <h4 class="font-medium text-blue-800">Student Research</h4>
                            </div>
                            <p class="text-sm text-blue-600">Submit undergraduate research projects</p>
                        </a>

                        <a href="{{ route('faculty.upload') }}" class="group bg-purple-50 hover:bg-purple-100 p-4 rounded-lg border border-purple-200 transition duration-200">
                            <div class="flex items-center mb-2">
                                <svg class="h-6 w-6 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                </svg>
                                <h4 class="font-medium text-purple-800">Faculty Research</h4>
                            </div>
                            <p class="text-sm text-purple-600">Submit faculty research publications</p>
                        </a>

                        <a href="{{ route('thesis.upload') }}" class="group bg-green-50 hover:bg-green-100 p-4 rounded-lg border border-green-200 transition duration-200">
                            <div class="flex items-center mb-2">
                                <svg class="h-6 w-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <h4 class="font-medium text-green-800">Thesis</h4>
                            </div>
                            <p class="text-sm text-green-600">Submit master's level thesis</p>
                        </a>

                        <a href="{{ route('dissertations.upload') }}" class="group bg-red-50 hover:bg-red-100 p-4 rounded-lg border border-red-200 transition duration-200">
                            <div class="flex items-center mb-2">
                                <svg class="h-6 w-6 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <h4 class="font-medium text-red-800">Dissertation</h4>
                            </div>
                            <p class="text-sm text-red-600">Submit doctoral level dissertation</p>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Approved Research Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">Recent Approved Research</h3>
                    
                    @if($approvedStudentResearch->count() > 0 || $approvedFacultyResearch->count() > 0 || $approvedThesis->count() > 0 || $approvedDissertations->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Student Research -->
                            @foreach($approvedStudentResearch as $research)
                                <a href="{{ route('student.show', $research->id) }}" class="block bg-blue-50 p-4 rounded-lg border border-blue-200 hover:shadow-lg hover:bg-blue-100 transition duration-300 transform hover:-translate-y-1">
                                    <div class="flex items-center mb-2">
                                        <svg class="h-5 w-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                        <span class="text-xs font-medium text-blue-600 bg-blue-100 px-2 py-1 rounded">Student Research</span>
                                    </div>
                                    <h4 class="font-medium text-gray-900 mb-2 hover:text-blue-800">{{ Str::limit($research->title, 50) }}</h4>
                                    <p class="text-sm text-gray-600 mb-2">By: {{ Str::limit($research->authors, 40) }}</p>
                                    <p class="text-xs text-gray-500 mb-2">{{ $research->department }} • {{ $research->program }}</p>
                                    <p class="text-xs text-gray-400 mb-3">Approved {{ $research->approved_at->diffForHumans() }}</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-blue-600 font-medium">Click to view details</span>
                                        <svg class="h-4 w-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </a>
                            @endforeach

                            <!-- Faculty Research -->
                            @foreach($approvedFacultyResearch as $research)
                                <a href="{{ route('faculty.show', $research->id) }}" class="block bg-purple-50 p-4 rounded-lg border border-purple-200 hover:shadow-lg hover:bg-purple-100 transition duration-300 transform hover:-translate-y-1">
                                    <div class="flex items-center mb-2">
                                        <svg class="h-5 w-5 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                        </svg>
                                        <span class="text-xs font-medium text-purple-600 bg-purple-100 px-2 py-1 rounded">Faculty Research</span>
                                    </div>
                                    <h4 class="font-medium text-gray-900 mb-2 hover:text-purple-800">{{ Str::limit($research->title, 50) }}</h4>
                                    <p class="text-sm text-gray-600 mb-2">Lead: {{ $research->user->name }}</p>
                                    @if($research->co_researchers)
                                        <p class="text-xs text-gray-500 mb-2">Co-researchers: {{ Str::limit($research->co_researchers, 40) }}</p>
                                    @endif
                                    <p class="text-xs text-gray-500 mb-2">{{ $research->department }}</p>
                                    <p class="text-xs text-gray-400 mb-3">Approved {{ $research->approved_at->diffForHumans() }}</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-purple-600 font-medium">Click to view details</span>
                                        <svg class="h-4 w-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </a>
                            @endforeach

                            <!-- Thesis -->
                            @foreach($approvedThesis as $thesis)
                                <a href="{{ route('thesis.show', $thesis->id) }}" class="block bg-green-50 p-4 rounded-lg border border-green-200 hover:shadow-lg hover:bg-green-100 transition duration-300 transform hover:-translate-y-1">
                                    <div class="flex items-center mb-2">
                                        <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span class="text-xs font-medium text-green-600 bg-green-100 px-2 py-1 rounded">Thesis</span>
                                    </div>
                                    <h4 class="font-medium text-gray-900 mb-2 hover:text-green-800">{{ Str::limit($thesis->title, 50) }}</h4>
                                    <p class="text-sm text-gray-600 mb-2">By: {{ $thesis->author }}</p>
                                    <p class="text-xs text-gray-500 mb-2">{{ $thesis->department }} • {{ $thesis->year_completed }}</p>
                                    <p class="text-xs text-gray-400 mb-3">Approved {{ $thesis->approved_at->diffForHumans() }}</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-green-600 font-medium">Click to view details</span>
                                        <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </a>
                            @endforeach

                            <!-- Dissertations -->
                            @foreach($approvedDissertations as $dissertation)
                                <a href="{{ route('dissertation.show', $dissertation->id) }}" class="block bg-red-50 p-4 rounded-lg border border-red-200 hover:shadow-lg hover:bg-red-100 transition duration-300 transform hover:-translate-y-1">
                                    <div class="flex items-center mb-2">
                                        <svg class="h-5 w-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span class="text-xs font-medium text-red-600 bg-red-100 px-2 py-1 rounded">Dissertation</span>
                                    </div>
                                    <h4 class="font-medium text-gray-900 mb-2 hover:text-red-800">{{ Str::limit($dissertation->title, 50) }}</h4>
                                    <p class="text-sm text-gray-600 mb-2">By: {{ $dissertation->author }}</p>
                                    <p class="text-xs text-gray-500 mb-2">{{ $dissertation->department }} • {{ $dissertation->year_completed }}</p>
                                    <p class="text-xs text-gray-400 mb-3">Approved {{ $dissertation->approved_at->diffForHumans() }}</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-red-600 font-medium">Click to view details</span>
                                        <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        
                        <!-- View All Link -->
                        <div class="mt-6 text-center">
                            <a href="#" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition duration-200">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                                View All Research
                            </a>
                        </div>
                    @else
                        <div class="text-center text-gray-500 py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="mt-2 text-sm">No approved research yet</p>
                            <p class="text-xs text-gray-400">Submit your research for review by the admin</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
