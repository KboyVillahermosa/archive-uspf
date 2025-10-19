<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Research by Department') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Browse research organized by academic departments and colleges</p>
            </div>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-[#26225C] font-semibold rounded-xl transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Department Overview Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
                    <div class="flex items-center">
                        <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl mr-4 group-hover:scale-110 transition-transform duration-300">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Student Research</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $approvedStudentResearch->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
                    <div class="flex items-center">
                        <div class="p-3 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl mr-4 group-hover:scale-110 transition-transform duration-300">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Faculty Research</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $approvedFacultyResearch->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
                    <div class="flex items-center">
                        <div class="p-3 bg-gradient-to-br from-green-500 to-green-600 rounded-xl mr-4 group-hover:scale-110 transition-transform duration-300">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Thesis</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $approvedThesis->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
                    <div class="flex items-center">
                        <div class="p-3 bg-gradient-to-br from-red-500 to-red-600 rounded-xl mr-4 group-hover:scale-110 transition-transform duration-300">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Dissertations</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $approvedDissertations->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Department Research Sections -->
            @php
                $departments = [
                    'College of Engineering and Architecture' => [
                        'color' => 'orange',
                        'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'
                    ],
                    'College of Computer Studies' => [
                        'color' => 'blue',
                        'icon' => 'M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z'
                    ],
                    'College of Health Sciences' => [
                        'color' => 'green',
                        'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'
                    ],
                    'College of Social Work' => [
                        'color' => 'indigo',
                        'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z'
                    ],
                    'College of Teacher Education, Arts and Sciences' => [
                        'color' => 'purple',
                        'icon' => 'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z'
                    ],
                    'School of Business and Accountancy' => [
                        'color' => 'yellow',
                        'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
                    ],
                    'Graduate School' => [
                        'color' => 'gray',
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
                <div class="space-y-8">
                    @foreach($departmentStats as $department => $stats)
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                            <!-- Department Header -->
                            <div class="bg-gradient-to-r from-{{ $stats['config']['color'] }}-600 via-{{ $stats['config']['color'] }}-700 to-{{ $stats['config']['color'] }}-800 px-8 py-8 relative overflow-hidden">
                                <!-- Background Pattern -->
                                <div class="absolute inset-0 opacity-10">
                                    <div class="absolute top-0 right-0 w-32 h-32 bg-white rounded-full -translate-y-16 translate-x-16"></div>
                                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-white rounded-full translate-y-12 -translate-x-12"></div>
                                </div>
                                
                                <div class="relative z-10">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="p-4 bg-white bg-opacity-20 rounded-2xl mr-6 backdrop-blur-sm">
                                                <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stats['config']['icon'] }}"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="text-3xl font-bold text-white mb-2">{{ $department }}</h3>
                                                <p class="text-{{ $stats['config']['color'] }}-100 text-lg font-medium">{{ $stats['total'] }} research publications</p>
                                            </div>
                                        </div>
                                        <button type="button" 
                                            onclick="toggleDepartment('{{ Str::slug($department) }}')"
                                            class="text-white hover:text-{{ $stats['config']['color'] }}-200 transition-all duration-300 hover:scale-110 bg-white bg-opacity-10 rounded-xl p-3 backdrop-blur-sm">
                                            <svg id="icon-{{ Str::slug($department) }}" class="h-8 w-8 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    <!-- Research Type Counts -->
                                    <div class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-4">
                                    @if($stats['student'] > 0)
                                        <div class="text-center bg-white bg-opacity-15 rounded-xl p-5 backdrop-blur-sm hover:bg-opacity-20 transition-all duration-300">
                                            <div class="text-4xl font-bold text-white mb-1">{{ $stats['student'] }}</div>
                                            <div class="text-sm text-{{ $stats['config']['color'] }}-100 font-semibold">Student Research</div>
                                        </div>
                                    @endif
                                    @if($stats['faculty'] > 0)
                                        <div class="text-center bg-white bg-opacity-15 rounded-xl p-5 backdrop-blur-sm hover:bg-opacity-20 transition-all duration-300">
                                            <div class="text-4xl font-bold text-white mb-1">{{ $stats['faculty'] }}</div>
                                            <div class="text-sm text-{{ $stats['config']['color'] }}-100 font-semibold">Faculty Research</div>
                                        </div>
                                    @endif
                                    @if($stats['thesis'] > 0)
                                        <div class="text-center bg-white bg-opacity-15 rounded-xl p-5 backdrop-blur-sm hover:bg-opacity-20 transition-all duration-300">
                                            <div class="text-4xl font-bold text-white mb-1">{{ $stats['thesis'] }}</div>
                                            <div class="text-sm text-{{ $stats['config']['color'] }}-100 font-semibold">Thesis</div>
                                        </div>
                                    @endif
                                    @if($stats['dissertation'] > 0)
                                        <div class="text-center bg-white bg-opacity-15 rounded-xl p-5 backdrop-blur-sm hover:bg-opacity-20 transition-all duration-300">
                                            <div class="text-4xl font-bold text-white mb-1">{{ $stats['dissertation'] }}</div>
                                            <div class="text-sm text-{{ $stats['config']['color'] }}-100 font-semibold">Dissertations</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Research List -->
                            <div id="content-{{ Str::slug($department) }}" class="hidden">
                                <div class="p-8">
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                        @foreach($stats['research'] as $research)
                                            @php
                                                $type = '';
                                                $route = '';
                                                $typeColor = '';
                                                
                                                if(isset($research->authors)) {
                                                    $type = 'Student Research';
                                                    $route = route('student.show', $research->id);
                                                    $author = $research->authors;
                                                    $typeColor = 'blue';
                                                } elseif(isset($research->co_researchers)) {
                                                    $type = 'Faculty Research';
                                                    $route = route('faculty.show', $research->id);
                                                    $author = $research->user->name;
                                                    $typeColor = 'purple';
                                                } elseif(isset($research->author) && isset($research->keywords)) {
                                                    if(Str::contains($research->keywords, 'doctoral') || $research->year_completed > 2020) {
                                                        $type = 'Dissertation';
                                                        $route = route('dissertation.show', $research->id);
                                                        $typeColor = 'red';
                                                    } else {
                                                        $type = 'Thesis';
                                                        $route = route('thesis.show', $research->id);
                                                        $typeColor = 'green';
                                                    }
                                                    $author = $research->author;
                                                } else {
                                                    $type = 'Thesis';
                                                    $route = route('thesis.show', $research->id);
                                                    $author = $research->author ?? 'Unknown';
                                                    $typeColor = 'green';
                                                }
                                            @endphp
                                            
                                            <a href="{{ $route }}" class="group block bg-gradient-to-br from-white to-gray-50 hover:from-gray-50 hover:to-gray-100 p-6 rounded-xl border border-gray-200 hover:border-gray-300 transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
                                                <div class="flex items-start justify-between mb-4">
                                                    <span class="text-xs font-bold text-{{ $typeColor }}-600 bg-{{ $typeColor }}-100 px-3 py-1.5 rounded-full border border-{{ $typeColor }}-200">{{ $type }}</span>
                                                    <span class="text-xs text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full font-medium">{{ $research->approved_at->format('M j, Y') }}</span>
                                                </div>
                                                <h4 class="font-bold text-gray-900 text-base mb-3 group-hover:text-gray-700 transition-colors line-clamp-2">{{ $research->title }}</h4>
                                                <p class="text-sm text-gray-600 mb-3 font-medium">By: {{ Str::limit($author, 50) }}</p>
                                                @if(isset($research->abstract))
                                                    <p class="text-sm text-gray-500 line-clamp-2 mb-4">{{ Str::limit($research->abstract, 120) }}</p>
                                                @endif
                                                <div class="flex items-center justify-between">
                                                    <span class="text-sm text-{{ $typeColor }}-600 font-bold">View Details</span>
                                                    <svg class="h-5 w-5 text-gray-400 group-hover:text-gray-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
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
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-16 text-center">
                    <div class="w-32 h-32 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-8">
                        <svg class="h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">No Research Available</h3>
                    <p class="text-gray-600 mb-8 text-lg">Research will appear here once approved by admin</p>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-[#26225C] font-bold rounded-xl transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        <svg class="h-6 w-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
