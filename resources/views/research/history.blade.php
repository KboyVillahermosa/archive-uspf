<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('My Research History') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Track the status of your submitted research projects</p>
            </div>
            <div class="flex space-x-3">
                @if(auth()->user()->hasPermissionTo('create student-research') || auth()->user()->hasRole('admin'))
                <a href="{{ route('student.upload') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-xl transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Submit Student Research
                </a>
                @endif
                @if(auth()->user()->hasPermissionTo('create faculty-research') || auth()->user()->hasRole('admin'))
                <a href="{{ route('faculty.upload') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white font-semibold rounded-xl transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Submit Faculty Research
                </a>
                @endif
                @php
                    $canCreateThesisHistory = false;
                    try {
                        $canCreateThesisHistory = auth()->user()->hasPermissionTo('create thesis');
                    } catch (\Exception $e) {
                        $canCreateThesisHistory = false;
                    }
                @endphp
                @if($canCreateThesisHistory || auth()->user()->hasRole('admin'))
                <a href="{{ route('thesis.upload') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold rounded-xl transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Submit Thesis
                </a>
                @endif
                @php
                    $canCreateDissertationsHistory = false;
                    try {
                        $canCreateDissertationsHistory = auth()->user()->hasPermissionTo('create dissertations');
                    } catch (\Exception $e) {
                        $canCreateDissertationsHistory = false;
                    }
                @endphp
                @if($canCreateDissertationsHistory || auth()->user()->hasRole('admin'))
                <a href="{{ route('dissertations.upload') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold rounded-xl transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Submit Dissertation
                </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Status Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
                    <div class="flex items-center">
                        <div class="p-3 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl mr-4 group-hover:scale-110 transition-transform duration-300">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Pending</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $pendingCount }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
                    <div class="flex items-center">
                        <div class="p-3 bg-gradient-to-br from-green-500 to-green-600 rounded-xl mr-4 group-hover:scale-110 transition-transform duration-300">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Approved</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $approvedCount }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
                    <div class="flex items-center">
                        <div class="p-3 bg-gradient-to-br from-red-500 to-red-600 rounded-xl mr-4 group-hover:scale-110 transition-transform duration-300">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Rejected</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $rejectedCount }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
                    <div class="flex items-center">
                        <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl mr-4 group-hover:scale-110 transition-transform duration-300">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $totalCount }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Research List -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-slate-50 to-gray-50 px-8 py-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Research Submissions</h3>
                            <p class="text-gray-600 text-sm">Manage and track your research projects</p>
                        </div>
                        <div class="w-12 h-12 bg-slate-500 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                @if($allResearch->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-slate-50 to-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Title</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Department</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Submitted</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($allResearch as $research)
                                    <tr class="hover:bg-gradient-to-r hover:from-gray-50 hover:to-blue-50 cursor-pointer transition-all duration-300 group" 
                                        onclick="navigateToResearch('{{ $research->type }}', {{ $research->id }}, '{{ $research->status }}')">
                                        <td class="px-6 py-5">
                                            <div class="text-sm font-semibold text-gray-900 max-w-xs truncate group-hover:text-gray-700 transition-colors">
                                                {{ $research->title }}
                                            </div>
                                            @if(isset($research->user_id) && $research->user_id !== auth()->id() && isset($research->user))
                                                <div class="text-xs text-gray-500 mt-1">
                                                    By: {{ $research->user->name }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            @if($research->type === 'student')
                                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-blue-100 text-blue-600 border border-blue-200">
                                                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                    </svg>
                                                    Student Research
                                                </span>
                                            @elseif($research->type === 'faculty')
                                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-purple-100 text-purple-600 border border-purple-200">
                                                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                                    </svg>
                                                    Faculty Research
                                                </span>
                                            @elseif($research->type === 'thesis')
                                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-green-100 text-green-600 border border-green-200">
                                                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                    Master's Thesis
                                                </span>
                                            @elseif($research->type === 'dissertation')
                                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-red-100 text-red-600 border border-red-200">
                                                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                    Doctoral Dissertation
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap text-sm font-medium text-gray-600">
                                            {{ $research->department }}
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            @if($research->status === 'pending')
                                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-yellow-100 text-yellow-600 border border-yellow-200">
                                                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Pending
                                                </span>
                                            @elseif($research->status === 'approved')
                                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-green-100 text-green-600 border border-green-200">
                                                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Approved
                                                </span>
                                            @elseif($research->status === 'rejected')
                                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-red-100 text-red-600 border border-red-200">
                                                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                    Rejected
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-500 font-medium">
                                            {{ $research->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-3">
                                                @if($research->status === 'approved')
                                                    <a href="{{ route($research->type . '.show', $research->id) }}" 
                                                       class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold text-sm transition-colors"
                                                       onclick="event.stopPropagation()">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                        View
                                                    </a>
                                                @endif
                                                @if($research->status === 'rejected' && !empty($research->rejection_reason))
                                                    <button onclick="event.stopPropagation(); showRejectionReason('{{ addslashes($research->rejection_reason) }}')" 
                                                            class="inline-flex items-center text-red-600 hover:text-red-800 font-semibold text-sm transition-colors">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        Reason
                                                    </button>
                                                @elseif($research->status === 'rejected')
                                                    <span class="text-gray-400 text-sm">No reason</span>
                                                @endif
                                                <svg class="h-4 w-4 text-gray-400 group-hover:text-gray-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                                </svg>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-8 py-6 border-t border-gray-100 bg-gradient-to-r from-slate-50 to-gray-50">
                        <div class="flex justify-center">
                            {{ $allResearch->links() }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-16 px-8">
                        <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">No research submitted yet</h3>
                        <p class="text-gray-600 mb-8 max-w-md mx-auto">Get started by submitting your first research project to begin building your academic portfolio.</p>
                        <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4">
                            <a href="{{ route('student.upload') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-xl transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                Submit Student Research
                            </a>
                            <a href="{{ route('faculty.upload') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white font-semibold rounded-xl transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                </svg>
                                Submit Faculty Research
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Rejection Reason Modal -->
    <div id="rejectionModal" class="fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border-0 w-full max-w-md shadow-2xl rounded-2xl bg-white">
            <div class="mt-3 text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-red-100 to-red-200 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Rejection Reason</h3>
                <div class="mt-4 px-6 py-4">
                    <p id="rejectionReasonText" class="text-sm text-gray-600 leading-relaxed"></p>
                </div>
                <div class="items-center px-6 py-4">
                    <button onclick="closeRejectionModal()" class="w-full px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-semibold rounded-xl transition-all duration-300 hover:shadow-lg">
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
    </script>
</x-app-layout>
