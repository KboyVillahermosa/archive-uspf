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
            
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-light text-[#26225C] mb-2">Research History</h1>
                <p class="text-gray-600">Manage and track your research submissions</p>
            </div>

            <!-- Status Summary -->
            <section class="mb-10">
                <!-- Skeleton Loader for Status Summary -->
                <div class="skeleton-container status-summary-skeleton">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @for($i = 0; $i < 4; $i++)
                        <div class="skeleton-card">
                            <div class="flex items-center">
                                <div class="skeleton w-12 h-12 rounded-xl mr-4"></div>
                                <div class="flex-1">
                                    <div class="skeleton skeleton-text w-20 mb-2"></div>
                                    <div class="skeleton skeleton-text w-16"></div>
                                </div>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
                
                <!-- Actual Status Summary -->
                <div class="content-container status-summary-content">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white rounded-xl p-6 border border-gray-200">
                    <div class="flex items-center">
                            <div class="w-12 h-12 bg-yellow-50 rounded-xl flex items-center justify-center mr-4">
                                <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Pending</p>
                                <p class="text-2xl font-light text-[#26225C] mt-1">{{ $pendingCount }}</p>
                        </div>
                    </div>
                </div>

                    <div class="bg-white rounded-xl p-6 border border-gray-200">
                    <div class="flex items-center">
                            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center mr-4">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Approved</p>
                                <p class="text-2xl font-light text-[#26225C] mt-1">{{ $approvedCount }}</p>
                        </div>
                    </div>
                </div>

                    <div class="bg-white rounded-xl p-6 border border-gray-200">
                    <div class="flex items-center">
                            <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center mr-4">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Rejected</p>
                                <p class="text-2xl font-light text-[#26225C] mt-1">{{ $rejectedCount }}</p>
                        </div>
                    </div>
                </div>

                    <div class="bg-white rounded-xl p-6 border border-gray-200">
                    <div class="flex items-center">
                            <div class="w-12 h-12 bg-[#26225C] bg-opacity-10 rounded-xl flex items-center justify-center mr-4">
                                <svg class="h-6 w-6 text-[#26225C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total</p>
                                <p class="text-2xl font-light text-[#26225C] mt-1">{{ $totalCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </section>

            <!-- Research List -->
            <section>
                <!-- Skeleton Loader for Table -->
                <div class="skeleton-container table-skeleton">
                    <div class="mb-6">
                        <div class="skeleton skeleton-title w-48 mb-2"></div>
                        <div class="skeleton skeleton-text w-32"></div>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-[#26225C] to-[#3a3770]">
                                    <tr>
                                        <th class="px-6 py-4"><div class="skeleton h-4 w-24"></div></th>
                                        <th class="px-6 py-4"><div class="skeleton h-4 w-16"></div></th>
                                        <th class="px-6 py-4"><div class="skeleton h-4 w-20"></div></th>
                                        <th class="px-6 py-4"><div class="skeleton h-4 w-16"></div></th>
                                        <th class="px-6 py-4"><div class="skeleton h-4 w-20"></div></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @for($i = 0; $i < 5; $i++)
                                    <tr>
                                        <td class="px-6 py-5">
                                            <div class="skeleton skeleton-text w-64 mb-2"></div>
                                            <div class="skeleton skeleton-text w-32"></div>
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="skeleton h-6 w-20 rounded-full"></div>
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="skeleton skeleton-text w-24"></div>
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="skeleton h-6 w-16 rounded-full"></div>
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="skeleton skeleton-text w-20"></div>
                                        </td>
                                    </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Actual Research List -->
                <div class="content-container table-content">
                <div class="mb-6">
                    <h2 class="text-2xl font-light text-[#26225C] mb-1">Research Submissions</h2>
                    <p class="text-sm text-gray-500">{{ $allResearch->count() }} research items</p>
                </div>

                @if($allResearch->count() > 0)
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <div class="overflow-x-auto">
                            <table class="w-full divide-y divide-gray-200 text-xs table-auto">
                                <thead class="bg-gradient-to-r from-[#26225C] to-[#3a3770] border-b border-[#FFC72C]">
                                <tr>
                                        <th class="px-2 py-1.5 text-left text-xs font-semibold text-white uppercase">ID</th>
                                        <th class="px-2 py-1.5 text-left text-xs font-semibold text-white uppercase">Type</th>
                                        <th class="px-2 py-1.5 text-left text-xs font-semibold text-white uppercase">Title</th>
                                        <th class="px-2 py-1.5 text-left text-xs font-semibold text-white uppercase">Department</th>
                                        <th class="px-2 py-1.5 text-left text-xs font-semibold text-white uppercase">Date</th>
                                        <th class="px-2 py-1.5 text-center text-xs font-semibold text-white uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($allResearch as $research)
                                        @php
                                            $user = auth()->user();
                                            $canApprove = false;
                                            $canDelete = false;
                                            
                                            if ($research->type === 'student') {
                                                $canApprove = $user->hasRole('admin') || $user->hasPermissionTo('approve student-research');
                                                $canDelete = $user->hasRole('admin') || $user->hasPermissionTo('delete student-research') || (isset($research->user_id) && $research->user_id === $user->id);
                                            } elseif ($research->type === 'faculty') {
                                                $canApprove = $user->hasRole('admin') || $user->hasPermissionTo('approve faculty-research');
                                                $canDelete = $user->hasRole('admin') || $user->hasPermissionTo('delete faculty-research') || (isset($research->user_id) && $research->user_id === $user->id);
                                            } elseif ($research->type === 'thesis') {
                                                $canApprove = $user->hasRole('admin') || $user->hasPermissionTo('approve thesis');
                                                $canDelete = $user->hasRole('admin') || (isset($research->user_id) && $research->user_id === $user->id);
                                            } elseif ($research->type === 'dissertation') {
                                                $canApprove = $user->hasRole('admin') || $user->hasPermissionTo('approve dissertations');
                                                $canDelete = $user->hasRole('admin') || (isset($research->user_id) && $research->user_id === $user->id);
                                            }
                                        @endphp
                                        <tr class="hover:bg-[#FFC72C] hover:bg-opacity-5 transition-colors group">
                                        <td class="px-2 py-1.5 text-gray-500 cursor-pointer whitespace-nowrap" onclick="navigateToResearch('{{ $research->type }}', {{ $research->id }}, '{{ $research->status }}')">
                                            #{{ $research->id }}
                                        </td>
                                        <td class="px-2 py-1.5 whitespace-nowrap cursor-pointer" onclick="navigateToResearch('{{ $research->type }}', {{ $research->id }}, '{{ $research->status }}')">
                                            @if($research->type === 'student')
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-[#26225C] bg-opacity-10 text-[#26225C]" title="Student">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                    </svg>
                                                </span>
                                            @elseif($research->type === 'faculty')
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-700" title="Faculty">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                                    </svg>
                                                </span>
                                            @elseif($research->type === 'thesis')
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-green-100 text-green-700" title="Thesis">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                </span>
                                            @elseif($research->type === 'dissertation')
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-red-100 text-red-700" title="Dissertation">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-2 py-1.5 cursor-pointer" onclick="navigateToResearch('{{ $research->type }}', {{ $research->id }}, '{{ $research->status }}')">
                                            <div class="text-xs font-medium text-[#26225C] max-w-xs truncate group-hover:text-[#FFC72C] transition-colors" title="{{ $research->title }}">
                                                {{ $research->title }}
                                            </div>
                                        </td>
                                        <td class="px-2 py-1.5 whitespace-nowrap text-xs text-gray-600 cursor-pointer" onclick="navigateToResearch('{{ $research->type }}', {{ $research->id }}, '{{ $research->status }}')" title="{{ $research->department }}">
                                            <span class="max-w-[120px] truncate block">{{ $research->department }}</span>
                                        </td>
                                        <td class="px-2 py-1.5 whitespace-nowrap text-xs text-gray-500 cursor-pointer" onclick="navigateToResearch('{{ $research->type }}', {{ $research->id }}, '{{ $research->status }}')">
                                            {{ $research->created_at ? $research->created_at->format('M d, Y') : 'N/A' }}
                                        </td>
                                        <td class="px-2 py-1.5 whitespace-nowrap text-center" onclick="event.stopPropagation()">
                                            <div class="flex items-center justify-center space-x-1.5">
                                                @if($research->status === 'pending' && $canApprove)
                                                    <a href="{{ route('admin.approve.' . $research->type . '.form', $research->id) }}" class="mp-form text-green-600 hover:text-green-700 transition-colors" data-target="actionModal" title="Approve">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </a>
                                                @endif
                                                @if($canDelete)
                                                    <form action="{{ route('admin.research.delete', ['type' => $research->type, 'id' => $research->id]) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this research? This action cannot be undone.')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-700 transition-colors" title="Delete">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif
                                                @if(!$canApprove && !$canDelete)
                                                    <span class="text-xs text-gray-400">-</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                        @if($allResearch->hasPages())
                        <div class="px-3 py-2 border-t border-[#FFC72C] border-opacity-30 bg-gradient-to-r from-[#26225C] to-[#3a3770] bg-opacity-5">
                        <div class="flex justify-center">
                            {{ $allResearch->links() }}
                            </div>
                        </div>
                        @endif
                    </div>
                @else
                    <div class="bg-white rounded-xl border border-gray-200 text-center py-16 px-8">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-medium text-[#26225C] mb-2">No research submitted yet</h3>
                        <p class="text-gray-600 mb-8 max-w-md mx-auto">Get started by submitting your first research project to begin building your academic portfolio.</p>
                        <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4">
                            <a href="{{ route('student.upload') }}" class="inline-flex items-center px-6 py-3 bg-[#26225C] hover:bg-[#3a3770] text-white font-medium rounded-xl transition-colors">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                Submit Student Research
                            </a>
                            <a href="{{ route('faculty.upload') }}" class="inline-flex items-center px-6 py-3 bg-[#26225C] hover:bg-[#3a3770] text-white font-medium rounded-xl transition-colors">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                </svg>
                                Submit Faculty Research
                            </a>
                        </div>
                    </div>
                @endif
                </div>
            </section>

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

    <!-- Rejection Reason Modal -->
    <div id="rejectionModal" class="fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border-0 w-full max-w-md shadow-xl rounded-xl bg-white">
            <div class="mt-3 text-center">
                <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-[#26225C] mb-2">Rejection Reason</h3>
                <div class="mt-4 px-6 py-4">
                    <p id="rejectionReasonText" class="text-sm text-gray-600 leading-relaxed"></p>
                </div>
                <div class="items-center px-6 py-4">
                    <button onclick="closeRejectionModal()" class="w-full px-6 py-3 bg-[#26225C] hover:bg-[#3a3770] text-white font-medium rounded-xl transition-colors">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function navigateToResearch(type, id, status) {
            // Navigate to edit page if pending, show if approved, else show warning
            const routes = {
                'student': {
                    show: '{{ route("student.show", ":id") }}',
                    edit: '{{ route("student.edit", ":id") }}'
                },
                'faculty': {
                    show: '{{ route("faculty.show", ":id") }}',
                    edit: '{{ route("faculty.edit", ":id") }}'
                },
                'thesis': {
                    show: '{{ route("thesis.show", ":id") }}',
                    edit: '{{ route("thesis.edit", ":id") }}'
                },
                'dissertation': {
                    show: '{{ route("dissertation.show", ":id") }}',
                    edit: '{{ route("dissertation.edit", ":id") }}'
                }
            };

            if (status === 'approved') {
                if (routes[type]) {
                    const url = routes[type].show.replace(':id', id);
                    window.location.href = url;
                }
            } else if (status === 'pending') {
                if (routes[type]) {
                    const url = routes[type].edit.replace(':id', id);
                    window.location.href = url;
                }
            } else {
                // Show a message for non-approved research using the consistent notification system
                let message = '';
                if (status === 'rejected') {
                    message = 'This research has been rejected and cannot be viewed.';
                }
                showWarningNotification(message);
            }
        }

        function showRejectionReason(reason) {
            document.getElementById('rejectionReasonText').textContent = reason;
            document.getElementById('rejectionModal').classList.remove('hidden');
        }

        function closeRejectionModal() {
            document.getElementById('rejectionModal').classList.add('hidden');
        }
        
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
            
            // Modal initialization for action modal
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
