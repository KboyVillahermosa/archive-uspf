<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Roles & Permissions') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto space-y-6">
            <div class="flex items-center justify-between mb-4">
                <div></div>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('admin.users.index') }}" class="px-3 py-2 text-sm bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded">Back to Users</a>
                    @can('create', App\Models\User::class)
                    <a href="{{ route('admin.roles.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        New Role
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
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($roles as $role)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="text-lg font-semibold text-gray-800">
                                        {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                    </h4>
                                    <div class="flex items-center space-x-2">
                                        @can('viewAny', App\Models\User::class)
                                        <a href="{{ route('admin.roles.edit', $role) }}" class="text-blue-600 hover:text-blue-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        @endcan
                                        @can('viewAny', App\Models\User::class)
                                        <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" class="inline delete-role-form" data-role-name="{{ ucfirst(str_replace('_', ' ', $role->name)) }}">
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
                                </div>
                                
                                <div class="mb-3">
                                    <p class="text-xs text-gray-500 mb-2">
                                        <span class="font-semibold">{{ $role->users_count }}</span> user(s) assigned
                                        <span class="mx-2">•</span>
                                        <span class="font-semibold">{{ $role->permissions->count() }}</span> permission(s)
                                    </p>
                                </div>
                                
                                @if($role->permissions->count() > 0)
                                    <div class="space-y-1 mb-3">
                                        @foreach($role->permissions->take(5) as $permission)
                                            <span class="inline-block px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded mr-1 mb-1">
                                                {{ $permission->name }}
                                            </span>
                                        @endforeach
                                        @if($role->permissions->count() > 5)
                                            <p class="text-xs text-gray-500 mt-2">+{{ $role->permissions->count() - 5 }} more permission(s)</p>
                                        @endif
                                    </div>
                                @else
                                    <p class="text-xs text-gray-500 mb-3">No permissions assigned</p>
                                @endif

                                <div class="pt-3 border-t border-gray-200">
                                    <a href="{{ route('admin.roles.edit', $role) }}" class="text-sm text-blue-600 hover:text-blue-800">
                                        Edit Role & Permissions →
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No roles</h3>
                                <p class="mt-1 text-sm text-gray-500">Get started by creating a new role.</p>
                                @can('create', App\Models\User::class)
                                <div class="mt-6">
                                    <a href="{{ route('admin.roles.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        New Role
                                    </a>
                                </div>
                                @endcan
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
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
                    // Reload page after short delay
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

