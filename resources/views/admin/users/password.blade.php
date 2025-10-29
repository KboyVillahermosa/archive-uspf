<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <h2 class="text-xl font-semibold mb-4">Change Password for {{ $user->name }}</h2>

        <div class="message-container my-4 text-red-500 text-sm text-center"></div>

        <form id="password-form" class="space-y-5" method="PUT" action="{{ route('admin.users.update', ['user' => $user, 'type' => 'password']) }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="type" value="password">

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                <input type="password" name="password" id="password" placeholder="Enter new password" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm new password" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex items-center justify-center gap-3 pt-5">
                <button type="submit" id="submit-btn" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Submit
                </button>
                <a href="{{ route('admin.users.show', $user) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('password-form')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const submitBtn = document.getElementById('submit-btn');
        const originalText = submitBtn.innerHTML;
        const messageContainer = document.querySelector('.message-container');
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<svg class="animate-spin h-4 w-4 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Updating...';
        
        // Clear previous messages
        if (messageContainer) {
            messageContainer.innerHTML = '';
            messageContainer.style.display = 'none';
        }
        
        // Create FormData
        const formData = new FormData(form);
        const action = form.action;
        
        fetch(action, {
            method: 'POST',
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
                    window.toastr.success(data.message || 'Password updated successfully!');
                } else {
                    alert(data.message || 'Password updated successfully!');
                }
                // Reload page after short delay
                setTimeout(() => {
                    window.location.href = '{{ route("admin.users.show", $user) }}';
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
                    window.toastr.error('Failed to update password. Please try again.');
                } else {
                    alert('Failed to update password. Please try again.');
                }
            }
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });
</script>

