<div class="relative p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="modal-title text-xl font-semibold text-[#26225C]">Create Role</h2>
        <button type="button" class="modal-close w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-md hover:bg-gray-100 transition-all duration-200 hover:scale-110">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <div class="message-container my-4 text-red-500 text-sm text-center"></div>

    <form id="role-form" class="modal-form space-y-4" method="POST" action="{{ route('admin.roles.store') }}" data-callback="" data-confirm="no">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Role Name</label>
            <input type="text" 
                   name="name" 
                   id="name" 
                   placeholder="e.g., Content Manager" 
                   required 
                   value="{{ old('name') }}" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#26225C]">
            <p class="mt-1 text-xs text-gray-500">The role name will be converted to lowercase with underscores (e.g., "Content Manager" → "content_manager")</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Permissions</label>
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
                                               {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-[#26225C] focus:ring-[#26225C]">
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

        <div class="flex items-center justify-center gap-3 mt-6">
            <button type="button" class="modal-close px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded transition-all">
                Cancel
            </button>
            <button type="submit" class="btn-submit px-4 py-2 bg-[#26225C] text-white rounded hover:bg-[#3a3770]">
                Create Role
            </button>
        </div>
    </form>
</div>

