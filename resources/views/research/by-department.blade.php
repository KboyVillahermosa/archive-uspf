<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-light text-[#26225C] mb-2">Research by Department</h1>
                        <p class="text-gray-600">Browse research organized by academic departments</p>
                    </div>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-5 py-2.5 bg-[#FFC72C] hover:bg-[#e0b026] text-[#26225C] font-medium rounded-xl transition-colors">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Dashboard
                    </a>
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
                <div class="space-y-10">
                    @foreach($departmentStats as $department => $stats)
                        <div>
                            <!-- Department Title -->
                            <div class="mb-6">
                                <div class="flex items-center space-x-3 mb-2">
                                    <div class="w-10 h-10 bg-[#26225C] bg-opacity-10 rounded-lg flex items-center justify-center">
                                        <svg class="h-6 w-6 text-[#26225C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $stats['config']['icon'] }}"></path>
                                            </svg>
                                    </div>
                                    <h2 class="text-2xl font-light text-[#26225C]">{{ $department }}</h2>
                                </div>
                                <div class="flex items-center space-x-4 text-sm text-gray-600 ml-13">
                                    <span class="font-medium">{{ $stats['total'] }}</span>
                                    <span>research publications</span>
                                    @if($stats['student'] > 0)
                                        <span class="text-gray-400">•</span>
                                        <span>{{ $stats['student'] }} Student</span>
                                    @endif
                                    @if($stats['faculty'] > 0)
                                        <span class="text-gray-400">•</span>
                                        <span>{{ $stats['faculty'] }} Faculty</span>
                                    @endif
                                    @if($stats['thesis'] > 0)
                                        <span class="text-gray-400">•</span>
                                        <span>{{ $stats['thesis'] }} Thesis</span>
                                    @endif
                                    @if($stats['dissertation'] > 0)
                                        <span class="text-gray-400">•</span>
                                        <span>{{ $stats['dissertation'] }} Dissertations</span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Research Table -->
                            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gradient-to-r from-[#26225C] to-[#3a3770]">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Type</th>
                                                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Title</th>
                                                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Author</th>
                                                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Date</th>
                                                <th class="px-6 py-3 text-center text-xs font-semibold text-white uppercase tracking-wider">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-100">
                                        @foreach($stats['research'] as $research)
                                            @php
                                                $type = '';
                                                $route = '';
                                                    $typeBadge = '';
                                                $typeColor = '';
                                                
                                                if(isset($research->authors)) {
                                                    $type = 'Student';
                                                    $route = route('student.show', $research->id);
                                                    $author = $research->authors;
                                                    $typeBadge = 'S';
                                                        $typeColor = 'bg-[#26225C] bg-opacity-10 text-[#26225C]';
                                                } elseif(isset($research->co_researchers)) {
                                                    $type = 'Faculty';
                                                    $route = route('faculty.show', $research->id);
                                                    $author = $research->user->name ?? 'Unknown';
                                                    $typeBadge = 'F';
                                                        $typeColor = 'bg-purple-100 text-purple-700';
                                                } elseif(isset($research->author) && isset($research->keywords)) {
                                                    if(Str::contains($research->keywords, 'doctoral') || ($research->year_completed ?? 0) > 2020) {
                                                        $type = 'Dissertation';
                                                        $route = route('dissertation.show', $research->id);
                                                        $typeBadge = 'D';
                                                            $typeColor = 'bg-red-100 text-red-700';
                                                    } else {
                                                        $type = 'Thesis';
                                                        $route = route('thesis.show', $research->id);
                                                        $typeBadge = 'T';
                                                            $typeColor = 'bg-green-100 text-green-700';
                                                    }
                                                    $author = $research->author;
                                                } else {
                                                    $type = 'Thesis';
                                                    $route = route('thesis.show', $research->id);
                                                    $author = $research->author ?? 'Unknown';
                                                    $typeBadge = 'T';
                                                        $typeColor = 'bg-green-100 text-green-700';
                                                }
                                            @endphp
                                            
                                                <tr class="hover:bg-gray-50 transition-colors">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="inline-flex items-center px-2.5 py-1 rounded text-xs font-medium {{ $typeColor }}">
                                                        {{ $type }}
                                                    </span>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div class="text-sm font-medium text-[#26225C] max-w-md">
                                                            <a href="{{ $route }}" class="hover:text-[#FFC72C] transition-colors">
                                                                {{ $research->title }}
                                                            </a>
                                                </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-600">{{ Str::limit($author, 40) }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-500">
                                                            {{ $research->approved_at ? $research->approved_at->format('M d, Y') : 'N/A' }}
                                                </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                                        <a href="{{ $route }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-[#26225C] bg-[#FFC72C] bg-opacity-20 hover:bg-opacity-30 rounded-lg transition-colors">
                                                            View
                                            </a>
                                                    </td>
                                                </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-xl border border-gray-200 p-16 text-center">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-[#26225C] mb-2">No Research Available</h3>
                    <p class="text-sm text-gray-600 mb-8 max-w-md mx-auto">Research will appear here once approved by administrators</p>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-3 bg-[#FFC72C] hover:bg-[#e0b026] text-[#26225C] font-medium rounded-xl transition-colors">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Dashboard
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
