<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Details') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-2">
                    <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <span class="text-lg font-semibold">{{ $user->name }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    @can('update', $user)
                    <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                    @endcan

                    @can('update', $user)
                    <a href="{{ route('admin.users.password', ['user' => $user]) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Change Password
                    </a>
                    @endcan

                    @can('delete', $user)
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline" id="delete-user-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete
                        </button>
                    </form>
                    @endcan
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="bg-blue-100 text-blue-800 font-semibold border-b border-blue-200 py-4 px-6 text-sm">
                        User Information
                    </div>

                    <div class="p-6">
                        <dl class="space-y-4">
                            <div class="flex justify-between border-b border-gray-200 py-2">
                                <dt class="text-sm font-medium text-gray-600">ID</dt>
                                <dd class="text-sm font-semibold text-gray-900">{{ $user->id }}</dd>
                            </div>

                            <div class="flex justify-between border-b border-gray-200 py-2">
                                <dt class="text-sm font-medium text-gray-600">Name</dt>
                                <dd class="text-sm text-gray-900">{{ $user->name }}</dd>
                            </div>

                            <div class="flex justify-between border-b border-gray-200 py-2">
                                <dt class="text-sm font-medium text-gray-600">Email</dt>
                                <dd class="text-sm text-gray-900">{{ $user->email }}</dd>
                            </div>

                            <div class="flex justify-between border-b border-gray-200 py-2">
                                <dt class="text-sm font-medium text-gray-600">Role</dt>
                                <dd class="text-sm text-gray-900">
                                    @if($user->getRoleNames()->first())
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium
                                            @if($user->getRoleNames()->first() === 'admin') bg-red-100 text-red-800
                                            @elseif($user->getRoleNames()->first() === 'faculty') bg-purple-100 text-purple-800
                                            @else bg-blue-100 text-blue-800 @endif">
                                            {{ ucfirst(str_replace('_', ' ', $user->getRoleNames()->first())) }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">No role assigned</span>
                                    @endif
                                </dd>
                            </div>

                            <div class="flex justify-between border-b border-gray-200 py-2">
                                <dt class="text-sm font-medium text-gray-600">Status</dt>
                                <dd>
                                    @if($user->status === 'active')
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">Active</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-red-100 text-red-800">Inactive</span>
                                    @endif
                                </dd>
                            </div>

                            <div class="flex justify-between py-2">
                                <dt class="text-sm font-medium text-gray-600">Created At</dt>
                                <dd class="text-sm text-gray-900">{{ $user->created_at->format('F d, Y h:i a') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="bg-blue-100 text-blue-800 font-semibold border-b border-blue-200 py-4 px-6 text-sm">
                        Additional Information
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- Basic Info -->
                        <div>
                            <p class="text-sm text-gray-600 mb-4">Last updated: {{ $user->updated_at->format('F d, Y h:i a') }}</p>
                            @if($user->student)
                                <div class="mt-4">
                                    <h4 class="text-sm font-semibold text-gray-800 mb-2">Student Information</h4>
                                    <dl class="space-y-2 text-sm">
                                        <div class="flex justify-between">
                                            <dt class="text-gray-600">ID Number:</dt>
                                            <dd class="text-gray-900">{{ $user->student->id_number ?? 'N/A' }}</dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="text-gray-600">Course:</dt>
                                            <dd class="text-gray-900">{{ $user->student->course_and_year ?? 'N/A' }}</dd>
                                        </div>
                                    </dl>
                                </div>
                            @endif
                        </div>

                        <!-- Research Statistics -->
                        <div class="border-t border-gray-200 pt-4">
                            <h4 class="text-sm font-semibold text-gray-800 mb-3">Research Statistics</h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div class="bg-blue-50 p-3 rounded-lg">
                                    <div class="text-xs text-gray-600 mb-1">Total Submissions</div>
                                    <div class="text-2xl font-bold text-blue-600">{{ $totalSubmissions ?? 0 }}</div>
                                </div>
                                <div class="bg-green-50 p-3 rounded-lg">
                                    <div class="text-xs text-gray-600 mb-1">Approved</div>
                                    <div class="text-2xl font-bold text-green-600">{{ $approvedSubmissions ?? 0 }}</div>
                                </div>
                                <div class="bg-yellow-50 p-3 rounded-lg">
                                    <div class="text-xs text-gray-600 mb-1">Pending</div>
                                    <div class="text-2xl font-bold text-yellow-600">{{ $pendingSubmissions ?? 0 }}</div>
                                </div>
                                <div class="bg-red-50 p-3 rounded-lg">
                                    <div class="text-xs text-gray-600 mb-1">Rejected</div>
                                    <div class="text-2xl font-bold text-red-600">{{ $rejectedSubmissions ?? 0 }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Research Performance -->
                        <div class="border-t border-gray-200 pt-4">
                            <h4 class="text-sm font-semibold text-gray-800 mb-3">Research Performance</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-purple-50 p-3 rounded-lg">
                                    <div class="text-xs text-gray-600 mb-1">Total Views</div>
                                    <div class="text-2xl font-bold text-purple-600">{{ $totalViews ?? 0 }}</div>
                                    <div class="text-xs text-gray-500 mt-1">Across all research</div>
                                </div>
                                <div class="bg-indigo-50 p-3 rounded-lg">
                                    <div class="text-xs text-gray-600 mb-1">Total Downloads</div>
                                    <div class="text-2xl font-bold text-indigo-600">{{ $totalDownloads ?? 0 }}</div>
                                    <div class="text-xs text-gray-500 mt-1">Across all research</div>
                                </div>
                            </div>
                        </div>

                        <!-- Research Breakdown -->
                        <div class="border-t border-gray-200 pt-4">
                            <h4 class="text-sm font-semibold text-gray-800 mb-3">Research Breakdown</h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                                <div>
                                    <div class="text-gray-600">Student Research</div>
                                    <div class="font-semibold text-gray-900">{{ ($studentResearch ?? collect())->count() }}</div>
                                </div>
                                <div>
                                    <div class="text-gray-600">Faculty Research</div>
                                    <div class="font-semibold text-gray-900">{{ ($facultyResearch ?? collect())->count() }}</div>
                                </div>
                                <div>
                                    <div class="text-gray-600">Theses</div>
                                    <div class="font-semibold text-gray-900">{{ ($theses ?? collect())->count() }}</div>
                                </div>
                                <div>
                                    <div class="text-gray-600">Dissertations</div>
                                    <div class="font-semibold text-gray-900">{{ ($dissertations ?? collect())->count() }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Submissions -->
                        @if(isset($recentSubmissions) && $recentSubmissions->count() > 0)
                        <div class="border-t border-gray-200 pt-4">
                            <h4 class="text-sm font-semibold text-gray-800 mb-3">Recent Submissions</h4>
                            <div class="space-y-2">
                                @foreach($recentSubmissions as $submission)
                                <div class="flex items-center justify-between p-2 bg-gray-50 rounded text-sm">
                                    <div class="flex-1">
                                        <div class="font-medium text-gray-900">{{ $submission['title'] }}</div>
                                        <div class="text-xs text-gray-500">{{ $submission['type'] }} • {{ $submission['created_at']->format('M d, Y') }}</div>
                                    </div>
                                    <div>
                                        @if($submission['status'] === 'approved')
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">Approved</span>
                                        @elseif($submission['status'] === 'pending')
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                        @elseif($submission['status'] === 'rejected')
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-red-100 text-red-800">Rejected</span>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- User Activity: Viewed Research -->
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-sm font-semibold text-gray-800">Viewed Research</h4>
                                @if(isset($uniqueViewsCount))
                                <span class="text-xs text-gray-500">({{ $uniqueViewsCount }} unique research items)</span>
                                @endif
                            </div>
                            @if(isset($viewedResearch) && $viewedResearch->count() > 0)
                            <div class="space-y-2 max-h-64 overflow-y-auto">
                                @foreach($viewedResearch as $view)
                                <div class="flex items-center justify-between p-2 bg-blue-50 rounded text-sm hover:bg-blue-100 transition-colors">
                                    <div class="flex-1">
                                        <div class="font-medium text-gray-900">{{ $view['title'] }}</div>
                                        <div class="text-xs text-gray-500">{{ $view['type'] }} • Viewed {{ $view['viewed_at']->diffForHumans() }}</div>
                                    </div>
                                    <div>
                                        @php
                                            $routeName = match($view['research_type']) {
                                                'student' => 'student.show.public',
                                                'faculty' => 'faculty.show.public',
                                                'thesis' => 'thesis.show.public',
                                                'dissertation' => 'dissertation.show.public',
                                                default => 'student.show.public'
                                            };
                                        @endphp
                                        <a href="{{ route($routeName, $view['research_id']) }}" 
                                           target="_blank"
                                           class="text-blue-600 hover:text-blue-800 text-xs">
                                            View →
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <p class="text-sm text-gray-500">No research viewed yet</p>
                            @endif
                        </div>

                        <!-- User Activity: Downloaded Research -->
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-sm font-semibold text-gray-800">Downloaded Research</h4>
                                @if(isset($uniqueDownloadsCount))
                                <span class="text-xs text-gray-500">({{ $uniqueDownloadsCount }} unique research items)</span>
                                @endif
                            </div>
                            @if(isset($downloadedResearch) && $downloadedResearch->count() > 0)
                            <div class="space-y-2 max-h-64 overflow-y-auto">
                                @foreach($downloadedResearch as $download)
                                <div class="p-2 bg-green-50 rounded text-sm hover:bg-green-100 transition-colors">
                                    <div class="flex items-center justify-between mb-1">
                                        <div class="flex-1">
                                            <div class="font-medium text-gray-900">{{ $download['title'] }}</div>
                                            <div class="text-xs text-gray-500">{{ $download['type'] }} • Downloaded {{ $download['downloaded_at']->diffForHumans() }}</div>
                                        </div>
                                        <div>
                                            @php
                                                $routeName = match($download['research_type']) {
                                                    'student' => 'student.show.public',
                                                    'faculty' => 'faculty.show.public',
                                                    'thesis' => 'thesis.show.public',
                                                    'dissertation' => 'dissertation.show.public',
                                                    default => 'student.show.public'
                                                };
                                            @endphp
                                            <a href="{{ route($routeName, $download['research_id']) }}" 
                                               target="_blank"
                                               class="text-green-600 hover:text-green-800 text-xs">
                                                View →
                                            </a>
                                        </div>
                                    </div>
                                    @if($download['purpose'] || $download['notes'])
                                    <div class="mt-2 pt-2 border-t border-green-200">
                                        @if($download['purpose'])
                                        <div class="text-xs text-gray-600">
                                            <span class="font-medium">Purpose:</span> {{ $download['purpose'] }}
                                        </div>
                                        @endif
                                        @if($download['notes'])
                                        <div class="text-xs text-gray-600 mt-1">
                                            <span class="font-medium">Notes:</span> {{ $download['notes'] }}
                                        </div>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            @else
                            <p class="text-sm text-gray-500">No research downloaded yet</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    // Handle delete user form
    document.getElementById('delete-user-form')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const userName = '{{ $user->name }}';
        
        if (!confirm(`Are you sure you want to delete user "${userName}"? This action cannot be undone.`)) {
            return;
        }
        
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalHTML = submitBtn.innerHTML;
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<svg class="animate-spin h-4 w-4 inline-block mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Deleting...';
        
        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                if (typeof window.toastr !== 'undefined') {
                    window.toastr.success(data.message || 'User deleted successfully!');
                } else {
                    alert(data.message || 'User deleted successfully!');
                }
                // Redirect to users list after short delay
                setTimeout(() => {
                    window.location.href = '{{ route("admin.users.index") }}';
                }, 1500);
            } else {
                if (typeof window.toastr !== 'undefined') {
                    window.toastr.error(data.message || 'Failed to delete user');
                } else {
                    alert('Error: ' + (data.message || 'Failed to delete user'));
                }
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHTML;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (typeof window.toastr !== 'undefined') {
                window.toastr.error('Failed to delete user. Please try again.');
            } else {
                alert('Failed to delete user. Please try again.');
            }
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalHTML;
        });
    });
</script>
