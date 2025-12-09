<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-light text-[#26225C] tracking-tight">
                    {{ __('Research by Department') }}
                </h2>
                <p class="text-sm text-gray-500 mt-2 font-normal">Browse research organized by academic departments and colleges</p>
            </div>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-[#FFC72C] hover:bg-[#FFD700] text-[#26225C] font-medium rounded-lg transition-all duration-200">
                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Research Type Overview -->
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-[#FFC72C] bg-gradient-to-r from-[#26225C] to-[#3a3770]">
                    <h3 class="text-lg font-medium text-white">Research Overview</h3>
                    <p class="text-sm text-yellow-100 mt-0.5">Total research by type</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-white border border-gray-200 rounded-lg p-5 hover:border-[#26225C] hover:shadow-sm transition-all duration-200">
                    <div class="flex items-center">
                                <div class="w-12 h-12 bg-[#26225C] bg-opacity-10 rounded-lg flex items-center justify-center mr-4">
                                    <svg class="h-6 w-6 text-[#26225C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Student Research</p>
                                    <p class="text-2xl font-light text-[#26225C] mt-1">{{ $approvedStudentResearch->count() }}</p>
                        </div>
                    </div>
                </div>

                        <div class="bg-white border border-gray-200 rounded-lg p-5 hover:border-[#26225C] hover:shadow-sm transition-all duration-200">
                    <div class="flex items-center">
                                <div class="w-12 h-12 bg-[#26225C] bg-opacity-10 rounded-lg flex items-center justify-center mr-4">
                                    <svg class="h-6 w-6 text-[#26225C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Faculty Research</p>
                                    <p class="text-2xl font-light text-[#26225C] mt-1">{{ $approvedFacultyResearch->count() }}</p>
                        </div>
                    </div>
                </div>

                        <div class="bg-white border border-gray-200 rounded-lg p-5 hover:border-[#26225C] hover:shadow-sm transition-all duration-200">
                    <div class="flex items-center">
                                <div class="w-12 h-12 bg-[#26225C] bg-opacity-10 rounded-lg flex items-center justify-center mr-4">
                                    <svg class="h-6 w-6 text-[#26225C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Thesis</p>
                                    <p class="text-2xl font-light text-[#26225C] mt-1">{{ $approvedThesis->count() }}</p>
                        </div>
                    </div>
                </div>

                        <div class="bg-white border border-gray-200 rounded-lg p-5 hover:border-[#26225C] hover:shadow-sm transition-all duration-200">
                    <div class="flex items-center">
                                <div class="w-12 h-12 bg-[#26225C] bg-opacity-10 rounded-lg flex items-center justify-center mr-4">
                                    <svg class="h-6 w-6 text-[#26225C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Dissertations</p>
                                    <p class="text-2xl font-light text-[#26225C] mt-1">{{ $approvedDissertations->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Department Research Sections -->
            @php
                $departments = [
                    'College of Engineering and Architecture' => [
                        'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'
                    ],
                    'College of Computer Studies' => [
                        'icon' => 'M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z'
                    ],
                    'College of Health Sciences' => [
                        'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'
                    ],
                    'College of Social Work' => [
                        'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z'
                    ],
                    'College of Teacher Education, Arts and Sciences' => [
                        'icon' => 'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z'
                    ],
                    'School of Business and Accountancy' => [
                        'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
                    ],
                    'Graduate School' => [
                        'icon' => 'M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z'
                    ]
                ];
                
                $departmentStats = [];
                foreach ($departments as $dept => $config) {
                    $studentCount = $approvedStudentResearch->where('department', $dept)->count();
                    $facultyCount = $approvedFacultyResearch->where('department', $dept)->count();
                    $thesisCount = $approvedThesis->where('department', $dept)->count();
                    $dissertationCount = $approvedDissertations->where('department', $dept)->count();
                    $total = $studentCount + $facultyCount + $thesisCount + $dissertationCount;
                    
                    if ($total > 0) {
                        $departmentStats[$dept] = [
                            'config' => $config,
                            'total' => $total,
                            'student' => $studentCount,
                            'faculty' => $facultyCount,
                            'thesis' => $thesisCount,
                            'dissertation' => $dissertationCount,
                            'research' => collect()
                                ->merge($approvedStudentResearch->where('department', $dept))
                                ->merge($approvedFacultyResearch->where('department', $dept))
                                ->merge($approvedThesis->where('department', $dept))
                                ->merge($approvedDissertations->where('department', $dept))
                                ->sortByDesc('approved_at')
                        ];
                    }
                }
            @endphp

            @if(count($departmentStats) > 0)
                <div class="space-y-6">
                    @foreach($departmentStats as $department => $stats)
                        <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                            <!-- Department Header -->
                            <div class="px-6 py-4 border-b border-[#FFC72C] bg-gradient-to-r from-[#26225C] to-[#3a3770]">
                                    <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $stats['config']['icon'] }}"></path>
                                                </svg>
                                            </div>
                                            <div>
                                            <h3 class="text-xl font-medium text-white">{{ $department }}</h3>
                                            <p class="text-sm text-yellow-100 mt-0.5">{{ $stats['total'] }} research publications</p>
                                            </div>
                                        </div>
                                        <button type="button" 
                                            onclick="toggleDepartment('{{ Str::slug($department) }}')"
                                        class="text-white hover:text-yellow-200 transition-colors bg-white bg-opacity-10 rounded-lg p-2 hover:bg-opacity-20">
                                        <svg id="icon-{{ Str::slug($department) }}" class="h-5 w-5 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    <!-- Research Type Counts -->
                                <div class="mt-4 flex items-center space-x-4">
                                    @if($stats['student'] > 0)
                                        <div class="flex items-center text-sm text-yellow-100">
                                            <span class="font-medium">{{ $stats['student'] }}</span>
                                            <span class="ml-1.5">Student</span>
                                        </div>
                                    @endif
                                    @if($stats['faculty'] > 0)
                                        <div class="flex items-center text-sm text-yellow-100">
                                            <span class="font-medium">{{ $stats['faculty'] }}</span>
                                            <span class="ml-1.5">Faculty</span>
                                        </div>
                                    @endif
                                    @if($stats['thesis'] > 0)
                                        <div class="flex items-center text-sm text-yellow-100">
                                            <span class="font-medium">{{ $stats['thesis'] }}</span>
                                            <span class="ml-1.5">Thesis</span>
                                        </div>
                                    @endif
                                    @if($stats['dissertation'] > 0)
                                        <div class="flex items-center text-sm text-yellow-100">
                                            <span class="font-medium">{{ $stats['dissertation'] }}</span>
                                            <span class="ml-1.5">Dissertations</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Research List -->
                            <div id="content-{{ Str::slug($department) }}" class="hidden">
                                <div class="p-6">
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach($stats['research'] as $research)
                                            @php
                                                $type = '';
                                                $route = '';
                                                $typeColor = '';
                                                
                                                if(isset($research->authors)) {
                                                    $type = 'Student Research';
                                                    $route = route('student.show', $research->id);
                                                    $author = $research->authors;
                                                    $typeColor = 'bg-[#26225C] bg-opacity-10 text-[#26225C] border-[#FFC72C] border-opacity-30';
                                                } elseif(isset($research->co_researchers)) {
                                                    $type = 'Faculty Research';
                                                    $route = route('faculty.show', $research->id);
                                                    $author = $research->user->name;
                                                    $typeColor = 'bg-[#26225C] bg-opacity-10 text-[#26225C] border-[#FFC72C] border-opacity-30';
                                                } elseif(isset($research->author) && isset($research->keywords)) {
                                                    if(Str::contains($research->keywords, 'doctoral') || $research->year_completed > 2020) {
                                                        $type = 'Dissertation';
                                                        $route = route('dissertation.show', $research->id);
                                                        $typeColor = 'bg-[#26225C] bg-opacity-10 text-[#26225C] border-[#FFC72C] border-opacity-30';
                                                    } else {
                                                        $type = 'Thesis';
                                                        $route = route('thesis.show', $research->id);
                                                        $typeColor = 'bg-[#26225C] bg-opacity-10 text-[#26225C] border-[#FFC72C] border-opacity-30';
                                                    }
                                                    $author = $research->author;
                                                } else {
                                                    $type = 'Thesis';
                                                    $route = route('thesis.show', $research->id);
                                                    $author = $research->author ?? 'Unknown';
                                                    $typeColor = 'bg-[#26225C] bg-opacity-10 text-[#26225C] border-[#FFC72C] border-opacity-30';
                                                }
                                            @endphp
                                            
                                            <a href="{{ $route }}" class="group block bg-white border border-gray-200 rounded-lg p-5 hover:border-[#FFC72C] hover:shadow-sm transition-all duration-200">
                                                <div class="flex items-center justify-between mb-3">
                                                    <span class="text-xs font-medium px-2 py-1 rounded border {{ $typeColor }}">{{ $type }}</span>
                                                    <span class="text-xs text-gray-400">{{ $research->approved_at->format('M j, Y') }}</span>
                                                </div>
                                                <h4 class="text-sm font-semibold text-[#26225C] mb-2 line-clamp-2 leading-snug">{{ $research->title }}</h4>
                                                <p class="text-xs text-gray-600 mb-3 line-clamp-1">By: {{ Str::limit($author, 50) }}</p>
                                                @if(isset($research->abstract))
                                                    <p class="text-xs text-gray-500 line-clamp-2 mb-3">{{ Str::limit($research->abstract, 100) }}</p>
                                                @endif
                                                <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                                    <span class="text-xs text-gray-500">View details</span>
                                                    <svg class="h-4 w-4 text-gray-400 group-hover:text-[#26225C] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                    </svg>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-base font-medium text-gray-900 mb-1">No Research Available</h3>
                    <p class="text-sm text-gray-500 mb-6">Research will appear here once approved by administrators</p>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-[#FFC72C] hover:bg-[#FFD700] text-[#26225C] font-medium rounded-lg transition-all duration-200">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Dashboard
                    </a>
                </div>
            @endif
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

        // Auto-expand first department if available
        document.addEventListener('DOMContentLoaded', function() {
            const firstIcon = document.querySelector('[id^="icon-"]');
            if (firstIcon) {
                const slug = firstIcon.id.replace('icon-', '');
                toggleDepartment(slug);
            }
        });
    </script>
</x-app-layout>
