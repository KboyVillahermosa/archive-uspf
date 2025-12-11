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
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                @if($totalCount > 0)
                    <table class="w-full divide-y divide-gray-200 text-xs table-auto">
                        <thead>
                            <tr class="bg-gradient-to-r from-[#26225C] to-[#3a3770] border-b border-[#FFC72C]">
                                <th class="px-2 py-1.5 text-left text-xs font-semibold text-white uppercase tracking-wider">Type</th>
                                <th class="px-2 py-1.5 text-left text-xs font-semibold text-white uppercase tracking-wider">Title</th>
                                <th class="px-2 py-1.5 text-left text-xs font-semibold text-white uppercase tracking-wider">Author</th>
                                <th class="px-2 py-1.5 text-left text-xs font-semibold text-white uppercase tracking-wider">Department</th>
                                <th class="px-2 py-1.5 text-left text-xs font-semibold text-white uppercase tracking-wider">Submitted</th>
                                <th class="px-2 py-1.5 text-center text-xs font-semibold text-white uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($studentResearch as $research)
                                <tr class="border-b border-gray-100 hover:bg-[#FFC72C] hover:bg-opacity-5 transition-colors bg-white cursor-pointer" onclick="viewResearch('student', {{ $research->id }})">
                                    <td class="px-2 py-1.5 whitespace-nowrap" onclick="event.stopPropagation()">
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">S</span>
                                    </td>
                                    <td class="px-2 py-1.5">
                                        <div class="text-xs font-medium text-[#26225C] max-w-[200px] truncate block" title="{{ $research->title }}">{{ Str::limit($research->title, 50) }}</div>
                                    </td>
                                    <td class="px-2 py-1.5">
                                        <div class="text-xs text-gray-600 max-w-[150px] truncate block" title="{{ $research->authors }}">{{ Str::limit($research->authors, 30) }}</div>
                                    </td>
                                    <td class="px-2 py-1.5">
                                        <div class="text-xs text-gray-600 max-w-[120px] truncate block" title="{{ $research->department }}{{ $research->program ? ' • ' . $research->program : '' }}">
                                            {{ Str::limit($research->department, 20) }}
                                            @if($research->program)
                                                <span class="text-gray-400">• {{ Str::limit($research->program, 15) }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-2 py-1.5 whitespace-nowrap">
                                        <div class="text-xs text-gray-500">{{ $research->created_at->format('M j, Y') }}</div>
                                    </td>
                                    <td class="px-2 py-1.5 text-center" onclick="event.stopPropagation()">
                                        <div class="flex items-center justify-center space-x-1">
                                            <a href="{{ route('admin.approve.student.form', $research->id) }}" class="mp-form inline-flex items-center justify-center w-7 h-7 bg-green-600 hover:bg-green-700 text-white rounded transition-colors" data-target="actionModal" title="Approve" onclick="event.stopPropagation()">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.reject.student.form', $research->id) }}" class="mp-form inline-flex items-center justify-center w-7 h-7 bg-red-600 hover:bg-red-700 text-white rounded transition-colors" data-target="actionModal" title="Reject" onclick="event.stopPropagation()">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.research.delete', ['type' => 'student', 'id' => $research->id]) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this research? This action cannot be undone.')" onclick="event.stopPropagation()">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center justify-center w-7 h-7 bg-gray-600 hover:bg-gray-700 text-white rounded transition-colors" title="Delete">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            @foreach($facultyResearch as $research)
                                <tr class="border-b border-gray-100 hover:bg-[#FFC72C] hover:bg-opacity-5 transition-colors bg-white cursor-pointer" onclick="viewResearch('faculty', {{ $research->id }})">
                                    <td class="px-2 py-1.5 whitespace-nowrap" onclick="event.stopPropagation()">
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">F</span>
                                    </td>
                                    <td class="px-2 py-1.5">
                                        <div class="text-xs font-medium text-[#26225C] max-w-[200px] truncate block" title="{{ $research->title }}">{{ Str::limit($research->title, 50) }}</div>
                                    </td>
                                    <td class="px-2 py-1.5">
                                        <div class="text-xs text-gray-600 max-w-[150px] truncate block" title="{{ $research->user->name ?? 'N/A' }}">{{ Str::limit($research->user->name ?? 'N/A', 30) }}</div>
                                    </td>
                                    <td class="px-2 py-1.5">
                                        <div class="text-xs text-gray-600 max-w-[120px] truncate block" title="{{ $research->department }}">{{ Str::limit($research->department, 20) }}</div>
                                    </td>
                                    <td class="px-2 py-1.5 whitespace-nowrap">
                                        <div class="text-xs text-gray-500">{{ $research->created_at->format('M j, Y') }}</div>
                                    </td>
                                    <td class="px-2 py-1.5 text-center" onclick="event.stopPropagation()">
                                        <div class="flex items-center justify-center space-x-1">
                                            <a href="{{ route('admin.approve.faculty.form', $research->id) }}" class="mp-form inline-flex items-center justify-center w-7 h-7 bg-green-600 hover:bg-green-700 text-white rounded transition-colors" data-target="actionModal" title="Approve" onclick="event.stopPropagation()">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.reject.faculty.form', $research->id) }}" class="mp-form inline-flex items-center justify-center w-7 h-7 bg-red-600 hover:bg-red-700 text-white rounded transition-colors" data-target="actionModal" title="Reject" onclick="event.stopPropagation()">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.research.delete', ['type' => 'faculty', 'id' => $research->id]) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this research? This action cannot be undone.')" onclick="event.stopPropagation()">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center justify-center w-7 h-7 bg-gray-600 hover:bg-gray-700 text-white rounded transition-colors" title="Delete">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            @foreach($thesis as $item)
                                <tr class="border-b border-gray-100 hover:bg-[#FFC72C] hover:bg-opacity-5 transition-colors bg-white cursor-pointer" onclick="viewResearch('thesis', {{ $item->id }})">
                                    <td class="px-2 py-1.5 whitespace-nowrap" onclick="event.stopPropagation()">
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">T</span>
                                    </td>
                                    <td class="px-2 py-1.5">
                                        <div class="text-xs font-medium text-[#26225C] max-w-[200px] truncate block" title="{{ $item->title }}">{{ Str::limit($item->title, 50) }}</div>
                                    </td>
                                    <td class="px-2 py-1.5">
                                        <div class="text-xs text-gray-600 max-w-[150px] truncate block" title="{{ $item->author }}">{{ Str::limit($item->author, 30) }}</div>
                                    </td>
                                    <td class="px-2 py-1.5">
                                        <div class="text-xs text-gray-600 max-w-[120px] truncate block" title="{{ $item->department }}">{{ Str::limit($item->department, 20) }}</div>
                                    </td>
                                    <td class="px-2 py-1.5 whitespace-nowrap">
                                        <div class="text-xs text-gray-500">{{ $item->created_at->format('M j, Y') }}</div>
                                    </td>
                                    <td class="px-2 py-1.5 text-center" onclick="event.stopPropagation()">
                                        <div class="flex items-center justify-center space-x-1">
                                            <a href="{{ route('admin.approve.thesis.form', $item->id) }}" class="mp-form inline-flex items-center justify-center w-7 h-7 bg-green-600 hover:bg-green-700 text-white rounded transition-colors" data-target="actionModal" title="Approve" onclick="event.stopPropagation()">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.reject.thesis.form', $item->id) }}" class="mp-form inline-flex items-center justify-center w-7 h-7 bg-red-600 hover:bg-red-700 text-white rounded transition-colors" data-target="actionModal" title="Reject" onclick="event.stopPropagation()">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.research.delete', ['type' => 'thesis', 'id' => $item->id]) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this research? This action cannot be undone.')" onclick="event.stopPropagation()">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center justify-center w-7 h-7 bg-gray-600 hover:bg-gray-700 text-white rounded transition-colors" title="Delete">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            @foreach($dissertations as $dissertation)
                                <tr class="border-b border-gray-100 hover:bg-[#FFC72C] hover:bg-opacity-5 transition-colors bg-white cursor-pointer" onclick="viewResearch('dissertation', {{ $dissertation->id }})">
                                    <td class="px-2 py-1.5 whitespace-nowrap" onclick="event.stopPropagation()">
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">D</span>
                                    </td>
                                    <td class="px-2 py-1.5">
                                        <div class="text-xs font-medium text-[#26225C] max-w-[200px] truncate block" title="{{ $dissertation->title }}">{{ Str::limit($dissertation->title, 50) }}</div>
                                    </td>
                                    <td class="px-2 py-1.5">
                                        <div class="text-xs text-gray-600 max-w-[150px] truncate block" title="{{ $dissertation->author }}">{{ Str::limit($dissertation->author, 30) }}</div>
                                    </td>
                                    <td class="px-2 py-1.5">
                                        <div class="text-xs text-gray-600 max-w-[120px] truncate block" title="{{ $dissertation->department }}">{{ Str::limit($dissertation->department, 20) }}</div>
                                    </td>
                                    <td class="px-2 py-1.5 whitespace-nowrap">
                                        <div class="text-xs text-gray-500">{{ $dissertation->created_at->format('M j, Y') }}</div>
                                    </td>
                                    <td class="px-2 py-1.5 text-center" onclick="event.stopPropagation()">
                                        <div class="flex items-center justify-center space-x-1">
                                            <a href="{{ route('admin.approve.dissertation.form', $dissertation->id) }}" class="mp-form inline-flex items-center justify-center w-7 h-7 bg-green-600 hover:bg-green-700 text-white rounded transition-colors" data-target="actionModal" title="Approve" onclick="event.stopPropagation()">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.reject.dissertation.form', $dissertation->id) }}" class="mp-form inline-flex items-center justify-center w-7 h-7 bg-red-600 hover:bg-red-700 text-white rounded transition-colors" data-target="actionModal" title="Reject" onclick="event.stopPropagation()">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.research.delete', ['type' => 'dissertation', 'id' => $dissertation->id]) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this research? This action cannot be undone.')" onclick="event.stopPropagation()">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center justify-center w-7 h-7 bg-gray-600 hover:bg-gray-700 text-white rounded transition-colors" title="Delete">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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

        // Function to view research details
        function viewResearch(type, id) {
            if (!id || id === 'null' || id === 'undefined') {
                console.error('No research ID provided');
                return;
            }
            
            let url = '';
            switch(type) {
                case 'student':
                    url = `/research/student/${id}/private`;
                    break;
                case 'faculty':
                    url = `/research/faculty/${id}/private`;
                    break;
                case 'thesis':
                    url = `/research/thesis/${id}/private`;
                    break;
                case 'dissertation':
                    url = `/research/dissertation/${id}/private`;
                    break;
                default:
                    console.error('Unknown research type:', type);
                    return;
            }
            
            window.location.href = url;
        }
    </script>
</x-app-layout>
