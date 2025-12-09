<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @php
            $user = auth()->user();
            $isFaculty = $user->role === 'faculty' || $user->hasRole('faculty');
            $isAdmin = $user->role === 'admin' || $user->hasRole('admin');
                $totalCount = $studentResearch->count() + $facultyResearch->count() + $thesis->count() + $dissertations->count();
        @endphp

            <!-- Header -->
            <div class="mb-8 flex items-center justify-between">
            <div>
                    <h1 class="text-4xl font-light text-[#26225C] mb-2">
                    @if($isFaculty && !$isAdmin)
                            Department Pending Research
                    @else
                            Pending Research Review
                    @endif
                    </h1>
                    <p class="text-gray-600">
                @if($isFaculty && !$isAdmin && $user->department)
                        Showing pending research for {{ $user->department }}
                        @if($user->course) - {{ $user->course }} course/program @endif
                        @else
                            Review and approve pending research submissions
                        @endif
                    </p>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="rounded-2xl shadow-lg bg-gradient-to-r from-[#26225C] to-[#3a3770] text-white relative overflow-hidden">
                    <div class="p-5">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="text-xs uppercase tracking-widest text-white/70 mb-1">Total</div>
                                <div class="text-sm text-white/80 uppercase tracking-[0.15em] mb-2">Pending Items</div>
                                <div class="text-3xl font-semibold mt-2">{{ $totalCount }}</div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="inline-block w-3 h-3 rounded-full bg-[#FFC72C]"></span>
                                <span class="inline-block w-3 h-3 rounded-full bg-[#FFC72C]/50"></span>
            </div>
        </div>
            </div>
                </div>

                <div class="rounded-2xl shadow-lg bg-gradient-to-r from-blue-600 to-blue-800 text-white relative overflow-hidden">
                    <div class="p-5">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="text-xs uppercase tracking-widest text-white/70 mb-1">Student</div>
                                <div class="text-sm text-white/80 uppercase tracking-[0.15em] mb-2">Research</div>
                                <div class="text-3xl font-semibold mt-2">{{ $studentResearch->count() }}</div>
                                        </div>
                            <div class="flex items-center gap-2">
                                <span class="inline-block w-3 h-3 rounded-full bg-white/30"></span>
                                <span class="inline-block w-3 h-3 rounded-full bg-white/20"></span>
                                </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl shadow-lg bg-gradient-to-r from-purple-600 to-purple-800 text-white relative overflow-hidden">
                    <div class="p-5">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="text-xs uppercase tracking-widest text-white/70 mb-1">Faculty</div>
                                <div class="text-sm text-white/80 uppercase tracking-[0.15em] mb-2">Research</div>
                                <div class="text-3xl font-semibold mt-2">{{ $facultyResearch->count() }}</div>
                                        </div>
                            <div class="flex items-center gap-2">
                                <span class="inline-block w-3 h-3 rounded-full bg-white/30"></span>
                                <span class="inline-block w-3 h-3 rounded-full bg-white/20"></span>
                                </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl shadow-lg bg-gradient-to-r from-green-600 to-green-800 text-white relative overflow-hidden">
                    <div class="p-5">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="text-xs uppercase tracking-widest text-white/70 mb-1">Thesis &</div>
                                <div class="text-sm text-white/80 uppercase tracking-[0.15em] mb-2">Dissertations</div>
                                <div class="text-3xl font-semibold mt-2">{{ $thesis->count() + $dissertations->count() }}</div>
                                        </div>
                            <div class="flex items-center gap-2">
                                <span class="inline-block w-3 h-3 rounded-full bg-white/30"></span>
                                <span class="inline-block w-3 h-3 rounded-full bg-white/20"></span>
                                </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Research Table -->
            <div class="table-container overflow-x-auto">
                @if($totalCount > 0)
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-[#26225C] to-[#3a3770] border-b border-[#FFC72C]">
                                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase">Type</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase">Title</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase">Author</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase">Department</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase">Submitted</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-white uppercase">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($studentResearch as $research)
                                <tr class="border-b border-gray-100 hover:bg-[#FFC72C] hover:bg-opacity-5 transition-colors bg-white">
                                    <td class="px-4 py-3">
                                        <span class="text-xs font-semibold text-[#26225C]">Student</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm font-medium text-[#26225C] max-w-xs truncate">{{ Str::limit($research->title, 60) }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm text-gray-600 max-w-xs truncate">{{ Str::limit($research->authors, 40) }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm text-gray-600 max-w-xs truncate">
                                            {{ $research->department }}
                                            @if($research->program)
                                                <span class="text-gray-400">• {{ Str::limit($research->program, 20) }}</span>
            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm text-gray-500">{{ $research->created_at->format('M j, Y') }}</div>
                                        <div class="text-xs text-gray-400">{{ $research->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('admin.approve.student.form', $research->id) }}" class="mp-form inline-flex items-center text-[#26225C] hover:text-[#FFC72C] transition-colors" data-target="actionModal">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                            @foreach($facultyResearch as $research)
                                <tr class="border-b border-gray-100 hover:bg-[#FFC72C] hover:bg-opacity-5 transition-colors bg-white">
                                    <td class="px-4 py-3">
                                        <span class="text-xs font-semibold text-purple-700">Faculty</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm font-medium text-[#26225C] max-w-xs truncate">{{ Str::limit($research->title, 60) }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm text-gray-600 max-w-xs truncate">{{ $research->user->name ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm text-gray-600 max-w-xs truncate">{{ $research->department }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm text-gray-500">{{ $research->created_at->format('M j, Y') }}</div>
                                        <div class="text-xs text-gray-400">{{ $research->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('admin.approve.faculty.form', $research->id) }}" class="mp-form inline-flex items-center text-[#26225C] hover:text-[#FFC72C] transition-colors" data-target="actionModal">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                            @foreach($thesis as $item)
                                <tr class="border-b border-gray-100 hover:bg-[#FFC72C] hover:bg-opacity-5 transition-colors bg-white">
                                    <td class="px-4 py-3">
                                        <span class="text-xs font-semibold text-green-700">Thesis</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm font-medium text-[#26225C] max-w-xs truncate">{{ Str::limit($item->title, 60) }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm text-gray-600 max-w-xs truncate">{{ Str::limit($item->author, 40) }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm text-gray-600 max-w-xs truncate">{{ $item->department }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm text-gray-500">{{ $item->created_at->format('M j, Y') }}</div>
                                        <div class="text-xs text-gray-400">{{ $item->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('admin.approve.thesis.form', $item->id) }}" class="mp-form inline-flex items-center text-[#26225C] hover:text-[#FFC72C] transition-colors" data-target="actionModal">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                            @foreach($dissertations as $dissertation)
                                <tr class="border-b border-gray-100 hover:bg-[#FFC72C] hover:bg-opacity-5 transition-colors bg-white">
                                    <td class="px-4 py-3">
                                        <span class="text-xs font-semibold text-red-700">Dissertation</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm font-medium text-[#26225C] max-w-xs truncate">{{ Str::limit($dissertation->title, 60) }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm text-gray-600 max-w-xs truncate">{{ Str::limit($dissertation->author, 40) }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm text-gray-600 max-w-xs truncate">{{ $dissertation->department }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm text-gray-500">{{ $dissertation->created_at->format('M j, Y') }}</div>
                                        <div class="text-xs text-gray-400">{{ $dissertation->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('admin.approve.dissertation.form', $dissertation->id) }}" class="mp-form inline-flex items-center text-[#26225C] hover:text-[#FFC72C] transition-colors" data-target="actionModal">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-16 bg-white rounded-xl">
                        <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-[#26225C] mb-2">No pending research</h3>
                        <p class="text-sm text-gray-500">All submissions have been reviewed.</p>
                    </div>
                @endif
                    </div>
                </div>
                    </div>

    <!-- Action Modal -->
    <div id="actionModal" class="modal fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 transition-opacity duration-300 ease-in-out" style="display: none;">
        <div class="flex justify-center pt-8 px-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full transform transition-all duration-300 ease-out modal-content-wrapper">
                <div class="modal-content">
                    <!-- Content will be loaded here via AJAX -->
                </div>
            </div>
        </div>
    </div>

    <style>
        .table-container {
            background: white;
            border-radius: 0.75rem;
            overflow: hidden;
        }
        
        .table-container table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table-container thead th {
            font-weight: 600;
            text-align: left;
        }
        
        .table-container tbody tr {
            transition: background-color 0.2s;
        }
        
        .table-container tbody tr:hover {
            background-color: rgba(255, 199, 44, 0.05);
        }
    </style>

    <script>
        // Ensure modal displays properly with smooth transitions
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('actionModal');
            const wrapper = modal?.querySelector('.modal-content-wrapper');
            
            if (modal && wrapper) {
                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                            if (!modal.classList.contains('hidden')) {
                                modal.style.display = 'block';
                                setTimeout(() => {
                                    modal.style.opacity = '1';
                                    wrapper.style.opacity = '1';
                                    wrapper.style.transform = 'translateY(0)';
                                }, 10);
                        } else {
                                modal.style.opacity = '0';
                                wrapper.style.opacity = '0';
                                wrapper.style.transform = 'translateY(-20px)';
                                setTimeout(() => {
                                    modal.style.display = 'none';
                                }, 300);
                            }
                        }
                    });
                });
                observer.observe(modal, { attributes: true, attributeFilter: ['class'] });
                
                wrapper.style.opacity = '0';
                wrapper.style.transform = 'translateY(-20px)';
                wrapper.style.transition = 'opacity 0.3s ease-out, transform 0.3s ease-out';
            }
        });
    </script>
</x-app-layout>
