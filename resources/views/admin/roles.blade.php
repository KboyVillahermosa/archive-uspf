<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Roles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Roles & Permissions</h3>
                <a href="{{ route('admin.users.index') }}" class="px-3 py-2 text-sm bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded">Back to Users</a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($roles as $role)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="text-lg font-semibold text-gray-800">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</h4>
                                    <span class="text-xs text-gray-500">{{ $role->permissions->count() }} permissions</span>
                                </div>
                                
                                @if($role->permissions->count() > 0)
                                    <div class="space-y-1">
                                        @foreach($role->permissions->take(5) as $permission)
                                            <span class="inline-block px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded mr-1 mb-1">
                                                {{ $permission->name }}
                                            </span>
                                        @endforeach
                                        @if($role->permissions->count() > 5)
                                            <p class="text-xs text-gray-500 mt-2">+{{ $role->permissions->count() - 5 }} more</p>
                                        @endif
                                    </div>
                                @else
                                    <p class="text-xs text-gray-500">No permissions assigned</p>
                                @endif

                                <div class="mt-4 pt-3 border-t border-gray-200">
                                    <p class="text-xs text-gray-600">
                                        Users with this role: <span class="font-semibold">{{ $role->users->count() }}</span>
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8">
                                <p class="text-gray-500">No roles found. Run the RoleSeeder to create roles.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-blue-800 mb-2">About Roles & Permissions</h4>
                <p class="text-sm text-blue-700">
                    Roles are managed through the Spatie Permission package. To modify roles or permissions, update the <code class="bg-blue-100 px-1 rounded">RoleSeeder</code> and run <code class="bg-blue-100 px-1 rounded">php artisan db:seed --class=RoleSeeder</code>.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>

