<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">User Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                            <p class="text-sm text-gray-900">{{ $user->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <p class="text-sm text-gray-900">{{ $user->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Created At</label>
                            <p class="text-sm text-gray-900">{{ $user->created_at->format('F d, Y h:i a') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Legacy Role</label>
                            <p class="text-sm text-gray-900">{{ ucfirst($user->role ?? 'N/A') }}</p>
                        </div>
                    </div>

                    <form method="PUT" action="{{ route('admin.users.update', $user) }}" id="role-form">
                        @csrf
                        <div class="mb-6">
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Assign Role</label>
                            <select name="role" id="role" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">No Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                    </option>
                                @endforeach
                            </select>
                            @if($errors->has('role'))
                                <p class="mt-1 text-sm text-red-600">{{ $errors->first('role') }}</p>
                            @endif
                        </div>

                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 text-sm bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded">Cancel</a>
                            <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">Update Role</button>
                        </div>
                    </form>

                    @if($user->roles->count() > 0)
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Current Permissions</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach($user->getAllPermissions() as $permission)
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">
                                        {{ $permission->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

