<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-[#26225C]">Roles & Permissions</h1>
            <p class="text-gray-600 mt-1">Manage user roles and their permissions</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Users
            </a>
            @can('create', App\Models\User::class)
            <a href="{{ route('admin.roles.create') }}" class="mp-form flex items-center gap-2 px-6 py-3 bg-[#26225C] hover:bg-[#3a3770] text-white font-semibold rounded-xl transition-all shadow-md hover:shadow-lg" data-target="roleModal">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Role
            </a>
            @endcan
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-4 rounded">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 rounded">
            {{ session('error') }}
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-gradient-to-r from-[#26225C] to-[#3a3770] rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-white/80 uppercase tracking-wider">Total Roles</p>
                    <p class="text-3xl font-bold mt-2">{{ $roles->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-r from-[#FFC72C] to-[#ffd65c] rounded-xl p-6 text-[#26225C] shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-[#26225C]/80 uppercase tracking-wider">Total Users</p>
                    <p class="text-3xl font-bold mt-2">{{ $roles->sum('users_count') }}</p>
                </div>
                <div class="w-12 h-12 bg-[#26225C]/20 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-r from-[#26225C] to-[#3a3770] rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-white/80 uppercase tracking-wider">Total Permissions</p>
                    <p class="text-3xl font-bold mt-2">{{ $allPermissions->flatten()->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Roles Table -->
    <div class="overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-gradient-to-r from-[#26225C] to-[#3a3770] text-white">
                    <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider border-b-2 border-[#FFC72C]">Role Name</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider border-b-2 border-[#FFC72C]">Users</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider border-b-2 border-[#FFC72C]">Permissions</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider border-b-2 border-[#FFC72C]">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($roles as $role)
                <tr class="hover:bg-yellow-50 transition-colors cursor-pointer" onclick="window.location.href='{{ route('admin.roles.edit', $role) }}'">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-r from-[#26225C] to-[#3a3770] flex items-center justify-center text-white font-semibold text-sm">
                                {{ strtoupper(substr(ucfirst(str_replace('_', ' ', $role->name)), 0, 1)) }}
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-semibold text-gray-900">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</div>
                                <div class="text-xs text-gray-500">{{ $role->name }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                            {{ $role->users_count }} user{{ $role->users_count !== 1 ? 's' : '' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-1">
                            @if($role->permissions->count() > 0)
                                @foreach($role->permissions->take(3) as $permission)
                                    <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">{{ $permission->name }}</span>
                                @endforeach
                                @if($role->permissions->count() > 3)
                                    <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">+{{ $role->permissions->count() - 3 }} more</span>
                                @endif
                            @else
                                <span class="px-2 py-1 text-xs bg-gray-100 text-gray-500 rounded italic">No permissions</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center gap-2" onclick="event.stopPropagation()">
                            <a href="{{ route('admin.roles.edit', $role) }}" class="text-[#26225C] hover:text-[#FFC72C] transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            @can('viewAny', App\Models\User::class)
                            <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" class="inline delete-role-form" data-role-name="{{ ucfirst(str_replace('_', ' ', $role->name)) }}" onsubmit="event.stopPropagation(); return confirm('Are you sure you want to delete this role?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 transition-colors">
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
                    <td colspan="4" class="px-6 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No roles</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new role.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Role Modal -->
    <div id="roleModal" class="modal fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 transition-opacity duration-300 ease-in-out" style="display: none;">
        <div class="flex justify-center pt-8 px-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto transform transition-all duration-300 ease-out modal-content-wrapper">
                <div class="modal-content">
                    <!-- Content will be loaded here via AJAX -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // Handle modal click outside to close
        document.getElementById('roleModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
                this.style.display = 'none';
            }
        });

        // Handle delete role forms
        document.querySelectorAll('.delete-role-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const form = this;
                const roleName = form.getAttribute('data-role-name');
                
                if (!confirm(`Are you sure you want to delete role "${roleName}"? This action cannot be undone.`)) {
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
                            window.toastr.success(data.message || 'Role deleted successfully!');
                        } else {
                            alert(data.message || 'Role deleted successfully!');
                        }
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        if (typeof window.toastr !== 'undefined') {
                            window.toastr.error(data.message || 'Failed to delete role');
                        } else {
                            alert('Error: ' + (data.message || 'Failed to delete role'));
                        }
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalHTML;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (typeof window.toastr !== 'undefined') {
                        window.toastr.error('Failed to delete role. Please try again.');
                    } else {
                        alert('Failed to delete role. Please try again.');
                    }
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalHTML;
                });
            });
        });
    </script>
            </div>
        </div>
    </div>
</x-app-layout>
