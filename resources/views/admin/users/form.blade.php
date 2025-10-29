<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <h2 class="text-xl font-semibold mb-4">{{ isset($user) ? 'Edit User' : 'Create User' }}</h2>

        <div class="message-container my-4 text-red-500 text-sm text-center"></div>

        <form id="user-form" class="space-y-5" method="{{ isset($user) ? 'PUT' : 'POST' }}" action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}">
            @csrf
            @if(isset($user))
                @method('PUT')
            @endif

            @if(!isset($user))
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" name="name" id="name" placeholder="Enter name" required value="{{ old('name') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" placeholder="Enter email" required value="{{ old('email') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            @else
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" name="name" id="name" placeholder="Enter name" required value="{{ old('name', $user->name) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter email" required value="{{ old('email', $user->email) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            @endif

            @if(!isset($user))
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter password" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm password" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="active" {{ (isset($user) && $user->status === 'active') || old('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ (isset($user) && $user->status === 'inactive') || old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select name="role" id="role" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">None</option>
                        @if(isset($roles) && $roles->count() > 0)
                            @foreach($roles as $roleItem)
                            <option value="{{ $roleItem->name }}" {{ (isset($user) && $user->hasRole($roleItem->name)) || old('role') === $roleItem->name ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $roleItem->name)) }}</option>
                            @endforeach
                        @endif
                    </select>
                    @if(!isset($roles) || $roles->count() == 0)
                        <p class="mt-1 text-xs text-gray-500">No roles available. <a href="{{ route('admin.roles.index') }}" class="text-blue-600 hover:underline">Create a role first</a></p>
                    @endif
                </div>
            </div>

            <div class="flex items-center justify-center gap-3 pt-5">
                <button type="submit" id="submit-btn" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Submit
                </button>
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('user-form')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const submitBtn = document.getElementById('submit-btn');
        const originalText = submitBtn.innerHTML;
        const messageContainer = document.querySelector('.message-container');
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<svg class="animate-spin h-4 w-4 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Submitting...';
        
        // Clear previous messages
        if (messageContainer) {
            messageContainer.innerHTML = '';
            messageContainer.style.display = 'none';
        }
        
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
                    window.toastr.success(data.message || '{{ isset($user) ? "User updated successfully!" : "User created successfully!" }}');
                } else {
                    alert(data.message || '{{ isset($user) ? "User updated successfully!" : "User created successfully!" }}');
                }
                // Reload page after short delay to show updated roles
                setTimeout(() => {
                    @if(isset($user))
                        window.location.href = '{{ route("admin.users.show", $user) }}';
                    @else
                        window.location.href = '{{ route("admin.users.index") }}';
                    @endif
                }, 1500);
            } else {
                // Handle validation errors
                let errorMessage = data.message || 'An error occurred';
                if (data.errors) {
                    const errorList = Object.values(data.errors).flat().join('<br>');
                    errorMessage = errorList;
                }
                
                if (messageContainer) {
                    messageContainer.innerHTML = errorMessage;
                    messageContainer.style.display = 'block';
                }
                
                if (typeof window.toastr !== 'undefined') {
                    window.toastr.error(data.message || 'Something went wrong');
                } else {
                    alert('Error: ' + errorMessage);
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
                
                if (messageContainer) {
                    messageContainer.innerHTML = errorMessage;
                    messageContainer.style.display = 'block';
                }
                
                if (typeof window.toastr !== 'undefined') {
                    window.toastr.error('Please check the form for errors.');
                } else {
                    alert('Validation Error:\n' + errorMessage);
                }
            } else {
                if (typeof window.toastr !== 'undefined') {
                    window.toastr.error('Failed to {{ isset($user) ? "update" : "create" }} user. Please try again.');
                } else {
                    alert('Failed to {{ isset($user) ? "update" : "create" }} user. Please try again.');
                }
            }
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });
</script>

