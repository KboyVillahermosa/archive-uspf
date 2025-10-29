<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex items-center justify-between mb-4">
                <div></div>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('admin.users.template') }}" class="px-3 py-2 text-sm bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded">Download CSV Template</a>
                    @can('create', App\Models\User::class)
                    <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        New User
                    </a>
                    @endcan
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($users as $user)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm text-gray-900 cursor-pointer" onclick="window.location='{{ route('admin.users.show', $user) }}'">{{ $user->id }}</td>
                                        <td class="px-4 py-3 text-sm cursor-pointer" onclick="window.location='{{ route('admin.users.show', $user) }}'">
                                            <div class="flex items-center gap-2">
                                                <div class="w-10 h-10 rounded-full flex items-center justify-center font-semibold text-white bg-blue-500">
                                                    {{ strtoupper(substr($user->name ?? '', 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                                    <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900 cursor-pointer" onclick="window.location='{{ route('admin.users.show', $user) }}'">
                                            {{ $user->name }}
                                        </td>
                                        <td class="px-4 py-3 text-sm cursor-pointer" onclick="window.location='{{ route('admin.users.show', $user) }}'">
                                            @php
                                                $userRole = $user->roles->first();
                                                $roleName = $userRole ? $userRole->name : null;
                                            @endphp
                                            @if($roleName)
                                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium
                                                    @if($roleName === 'admin') bg-red-100 text-red-800
                                                    @elseif($roleName === 'faculty') bg-purple-100 text-purple-800
                                                    @else bg-blue-100 text-blue-800 @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $roleName)) }}
                                                </span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm cursor-pointer" onclick="window.location='{{ route('admin.users.show', $user) }}'">
                                            @if($user->status === 'active')
                                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">Active</span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-red-100 text-red-800">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-500 cursor-pointer" onclick="window.location='{{ route('admin.users.show', $user) }}'">{{ $user->created_at->format('M d, Y') }}</td>
                                        <td class="px-4 py-3 text-sm">
                                            <div class="flex gap-2">
                                                @can('update', $user)
                                                <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:text-blue-900">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                                @endcan
                                                @can('delete', $user)
                                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline delete-user-form" data-user-name="{{ $user->name }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-4 text-center text-sm text-gray-500">No users found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>

            <!-- CSV Import Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">Import Users from CSV</h3>
                    <form id="user-import-form" method="POST" action="{{ route('admin.users.import') }}" enctype="multipart/form-data" class="flex items-center space-x-3">
                        @csrf
                        <input type="file" name="csv_file" accept=".csv" class="border border-gray-300 rounded p-2" required>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Import CSV</button>
                        <span class="text-xs text-gray-500">Format: name,email,password,role</span>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('user-import-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Importing...';
            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success || data.status === 'success') {
                    if (typeof window.toastr !== 'undefined') {
                        window.toastr.success(data.message || 'Import complete!');
                    } else {
                        alert(data.message || 'Import complete!');
                    }
                    setTimeout(() => { window.location.reload(); }, 1200);
                } else {
                    if (typeof window.toastr !== 'undefined') {
                        window.toastr.error(data.message || 'Import failed');
                    } else {
                        alert('Error: ' + (data.message || 'Import failed'));
                    }
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            })
            .catch(error => {
                if (typeof window.toastr !== 'undefined') {
                    window.toastr.error('Failed to import users');
                } else {
                    alert('Failed to import users');
                }
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });

        // Handle delete user forms
        document.querySelectorAll('.delete-user-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const form = this;
                const userName = form.getAttribute('data-user-name');
                
                if (!confirm(`Are you sure you want to delete user "${userName}"? This action cannot be undone.`)) {
                    return;
                }
                
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalHTML = submitBtn.innerHTML;
                
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
                
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
                        // Reload page after short delay
                        setTimeout(() => {
                            window.location.reload();
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
        });
    </script>
</x-app-layout>

