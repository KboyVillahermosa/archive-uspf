<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($role) ? __('Edit Role') : __('Create Role') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto space-y-6">
            <div class="flex items-center justify-between mb-4">
                <a href="{{ route('admin.roles.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Roles
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form id="role-form" method="{{ isset($role) ? 'PUT' : 'POST' }}" action="{{ isset($role) ? route('admin.roles.update', $role) : route('admin.roles.store') }}">
                        @csrf
                        @if(isset($role))
                            @method('PUT')
                        @endif

                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Role Name</label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   placeholder="e.g., Content Manager" 
                                   required 
                                   value="{{ old('name', isset($role) ? ucfirst(str_replace('_', ' ', $role->name)) : '') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="mt-1 text-xs text-gray-500">The role name will be converted to lowercase with underscores (e.g., "Content Manager" → "content_manager")</p>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Permissions</label>
                            <div class="border border-gray-200 rounded-lg p-4 max-h-96 overflow-y-auto">
                                @if($allPermissions->count() > 0)
                                    @foreach($allPermissions as $group => $permissions)
                                        <div class="mb-4 pb-4 {{ !$loop->last ? 'border-b border-gray-200' : '' }}">
                                            <h4 class="text-sm font-semibold text-gray-700 mb-2 capitalize">{{ str_replace('-', ' ', $group) }}</h4>
                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                                                @foreach($permissions as $permission)
                                                    <label class="flex items-center space-x-2 cursor-pointer hover:bg-gray-50 p-2 rounded">
                                                        <input type="checkbox" 
                                                               name="permissions[]" 
                                                               value="{{ $permission->name }}"
                                                               {{ (isset($role) && $role->hasPermissionTo($permission->name)) || in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}
                                                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                                        <span class="text-sm text-gray-700">{{ $permission->name }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-sm text-gray-500">No permissions available. Permissions are usually created through seeders.</p>
                                @endif
                            </div>
                            <p class="mt-2 text-xs text-gray-500">Select the permissions that users with this role will have.</p>
                        </div>

                        <div class="flex items-center justify-end space-x-3 pt-5 border-t border-gray-200">
                            <a href="{{ route('admin.roles.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                                Cancel
                            </a>
                            <button type="submit" id="submit-btn" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                {{ isset($role) ? 'Update Role' : 'Create Role' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.getElementById('role-form')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const submitBtn = document.getElementById('submit-btn');
        const originalText = submitBtn.innerHTML;
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<svg class="animate-spin h-4 w-4 inline-block mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> {{ isset($role) ? "Updating..." : "Creating..." }}';
        
        // Create FormData
        const formData = new FormData(form);
        const method = form.querySelector('input[name="_method"]')?.value || 'POST';
        const action = form.action;
        
        fetch(action, {
            method: method === 'PUT' ? 'POST' : 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            // Check if response is ok, if not parse error
            if (!response.ok && response.status === 422) {
                return response.json().then(err => {
                    throw {validation: true, errors: err.errors || err, message: err.message || 'Validation failed'};
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                if (typeof window.toastr !== 'undefined') {
                    window.toastr.success(data.message || '{{ isset($role) ? "Role updated successfully!" : "Role created successfully!" }}');
                } else {
                    alert(data.message || '{{ isset($role) ? "Role updated successfully!" : "Role created successfully!" }}');
                }
                // Reload page after short delay
                setTimeout(() => {
                    window.location.href = '{{ route("admin.roles.index") }}';
                }, 1500);
            } else {
                if (typeof window.toastr !== 'undefined') {
                    window.toastr.error(data.message || 'Something went wrong');
                } else {
                    alert('Error: ' + (data.message || 'Something went wrong'));
                }
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            
            // Handle validation errors
            if (error.validation) {
                let errorMessage = error.message || 'Validation failed';
                if (error.errors) {
                    const errorList = Object.values(error.errors).flat().join('<br>');
                    errorMessage = errorList;
                }
                
                if (typeof window.toastr !== 'undefined') {
                    window.toastr.error('Please check the form for errors.');
                } else {
                    alert('Validation Error:\n' + errorMessage);
                }
            } else {
                if (typeof window.toastr !== 'undefined') {
                    window.toastr.error('Failed to {{ isset($role) ? "update" : "create" }} role. Please try again.');
                } else {
                    alert('Failed to {{ isset($role) ? "update" : "create" }} role. Please try again.');
                }
            }
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });
</script>

