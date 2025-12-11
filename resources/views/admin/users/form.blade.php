<div class="relative p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="modal-title text-xl font-semibold text-[#26225C]">{{ isset($user) ? 'Edit User' : 'Create User' }}</h2>
        <button type="button" class="modal-close w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-md hover:bg-gray-100 transition-all duration-200 hover:scale-110">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

        <div class="message-container my-4 text-red-500 text-sm text-center"></div>

    <form id="user-form" class="modal-form space-y-4" method="{{ isset($user) ? 'PUT' : 'POST' }}" action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}" data-callback="" data-confirm="no">
            @csrf
            @if(isset($user))
                @method('PUT')
            @endif

            @if(!isset($user))
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" name="name" id="name" placeholder="Enter name" required value="{{ old('name') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#26225C]">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter email" required value="{{ old('email') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#26225C]">
                </div>
            </div>
            @else
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input type="text" name="name" id="name" placeholder="Enter name" required value="{{ old('name', $user->name) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#26225C]">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" id="email" placeholder="Enter email" required value="{{ old('email', $user->email) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#26225C]">
            </div>
            @endif

            @if(!isset($user))
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter password" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#26225C]">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm password" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#26225C]">
                </div>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" id="status" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#26225C]">
                        <option value="active" {{ (isset($user) && $user->status === 'active') || old('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ (isset($user) && $user->status === 'inactive') || old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select name="role" id="role" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#26225C]">
                        <option value="">None</option>
                        @if(isset($roles) && $roles->count() > 0)
                            @foreach($roles as $roleItem)
                            <option value="{{ $roleItem->name }}" {{ (isset($user) && $user->hasRole($roleItem->name)) || old('role') === $roleItem->name ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $roleItem->name)) }}</option>
                            @endforeach
                        @endif
                    </select>
                    @if(!isset($roles) || $roles->count() == 0)
                    <p class="mt-1 text-xs text-gray-500">No roles available. <a href="{{ route('admin.roles.index') }}" class="text-[#26225C] hover:text-[#FFC72C] hover:underline">Create a role first</a></p>
                    @endif
                </div>
            </div>

            <!-- Department and Course fields -->
            @php
                $currentUser = auth()->user();
                $isCurrentUserFaculty = $currentUser && ($currentUser->hasRole('faculty') || $currentUser->role === 'faculty');
                $isCurrentUserAdmin = $currentUser && ($currentUser->hasRole('admin') || $currentUser->role === 'admin');
            @endphp
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="department" class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                    @if($isCurrentUserFaculty && !$isCurrentUserAdmin)
                        <!-- Faculty can only create users in their department -->
                        <input type="text" name="department" id="department" 
                               value="{{ $currentUser->department }}" 
                               readonly 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-600 cursor-not-allowed">
                        <p class="mt-1 text-xs text-gray-500">You can only create users for your department</p>
                    @else
                        <!-- Admin can set any department -->
                        <input type="text" name="department" id="department" 
                               placeholder="Enter department" 
                               value="{{ old('department', isset($user) ? $user->department : '') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#26225C]">
                    @endif
                </div>

                <div>
                    <label for="course" class="block text-sm font-medium text-gray-700 mb-1">Course/Program</label>
                    @if($isCurrentUserFaculty && !$isCurrentUserAdmin)
                        <!-- Faculty can only create users in their course -->
                        <input type="text" name="course" id="course" 
                               value="{{ $currentUser->course }}" 
                               readonly 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-600 cursor-not-allowed">
                        <p class="mt-1 text-xs text-gray-500">You can only create users for your course/program</p>
                    @else
                        <!-- Admin can set any course -->
                        <input type="text" name="course" id="course" 
                               placeholder="Enter course/program" 
                               value="{{ old('course', isset($user) ? $user->course : '') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#26225C]">
                    @endif
                </div>
            </div>

        <div class="flex items-center justify-center gap-3 mt-6">
            <button type="button" class="modal-close px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded transition-all">
                Cancel
            </button>
            <button type="submit" class="btn-submit px-4 py-2 bg-[#26225C] text-white rounded hover:bg-[#3a3770]">
                    Submit
                </button>
            </div>
        </form>
    </div>
