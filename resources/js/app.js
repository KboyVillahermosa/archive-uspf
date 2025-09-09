import './bootstrap';
import Alpine from 'alpinejs';
import toastr from 'toastr';

// Initialize Alpine.js
window.Alpine = Alpine;
Alpine.start();

// Configure toastr
toastr.options = {
    closeButton: true,
    progressBar: true,
    positionClass: "toast-top-right",
    timeOut: 5000,
    extendedTimeOut: 2000,
    showMethod: 'fadeIn',
    hideMethod: 'fadeOut'
};
window.toastr = toastr;

// Success notification function
window.showSuccessNotification = function(message, redirectUrl = null, delay = 2000) {
    // Create a success notification element
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg shadow-lg z-50 max-w-md';
    notification.innerHTML = `
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="flex-1">
                <p class="font-medium">${message}</p>
                ${redirectUrl ? '<p class="text-sm text-green-600 mt-1">Redirecting to your research history...</p>' : ''}
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-green-400 hover:text-green-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after delay and redirect if needed
    setTimeout(() => {
        if (document.body.contains(notification)) {
            document.body.removeChild(notification);
        }
        if (redirectUrl) {
            window.location.href = redirectUrl;
        }
    }, delay);
};

// Warning notification function
window.showWarningNotification = function(message, duration = 3000) {
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-6 py-4 rounded-lg shadow-lg z-50 max-w-md';
    notification.innerHTML = `
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-3 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
            <div class="flex-1">
                <p class="font-medium">${message}</p>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-yellow-400 hover:text-yellow-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        if (document.body.contains(notification)) {
            document.body.removeChild(notification);
        }
    }, duration);
};

// DOM Content Loaded Event Handler
document.addEventListener("DOMContentLoaded", function () {
    // Modal form click handler
    document.querySelectorAll('.mp-form').forEach(el => {
        el.addEventListener('click', async (event) => {
            event.preventDefault();

            const target = el.getAttribute('data-target') || 'modal';
            const modal = document.getElementById(target);
            const body = modal.querySelector('.modal-content');
            const ref = el.getAttribute('href');

            modal.classList.remove('hidden');

            try {
                if (ref && ref !== '#') {
                    body.innerHTML = `
                        <div class="py-5 text-center text-green-900">
                            <div class="loader"></div>
                        </div>
                    `;

                    const response = await fetch(ref, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });

                    if (!response.ok) {
                        throw new Error('Failed to load content');
                    }

                    const data = await response.text();
                    body.innerHTML = data;
                }

                if (body) {
                    formHandler(body);
                    modal.querySelectorAll('.modal-close').forEach(close => {
                        close.addEventListener('click', () => {
                            modal.classList.add('hidden');
                        });
                    });
                }
            } catch (error) {
                console.error(error);
                toastr.error('Something went wrong');
            }
        });
    });

    // Confirmation click handler
    document.querySelectorAll('.mp-confirm').forEach(el => {
        el.addEventListener('click', async (event) => {
            event.preventDefault();

            const method = el.getAttribute('data-method')?.toUpperCase() || 'GET';
            const target = el.getAttribute('href');
            const confirmMessage = el.getAttribute('data-confirm') || 'Are you sure you want to continue?';

            try {
                const confirmed = confirm(confirmMessage);
                if (!confirmed) return;

                if (target) {
                    const response = await fetch(target, {
                        method: method,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        }
                    });

                    const data = await response.json();

                    if (data.status && data.status === 'success') {
                        toastr.success(data.message || 'Action completed successfully');

                        if (data.redirect) {
                            setTimeout(() => {
                                window.location.href = data.redirect;
                            }, 1000);
                        } else {
                            window.location.reload();
                        }
                    } else {
                        window.toastr.error(data.error || data.message || 'Something went wrong');
                    }
                }
            } catch (error) {
                console.error('Confirmation error:', error);
                toastr.error('Something went wrong. Please try again.');
            }
        });
    });

    // Modal close handler
    document.querySelectorAll('.modal').forEach(el => {
        el.querySelectorAll('.modal-close').forEach(close => {
            close.addEventListener('click', () => {
                el.classList.add('hidden');
            });
        });
    });
});

// Form handler function
function formHandler(el) {
    const form = el.querySelector('.modal-form');

    if (form) {
        const callback = form.getAttribute('data-callback');
        const submit = form.querySelector('button[type="submit"]');
        const message = el.querySelector('.message-container');
        const imageInput = form.querySelector('#image');
        const imageBox = form.querySelector('#uploadBox');
        const imageBtn = form.querySelector('#uploadPrompt');
        const imageBas64 = form.querySelector('#imageBase64');

        // Image upload handling
        if (imageInput && imageBox && imageBtn && imageBas64) {
            imageBox.addEventListener('click', () => imageInput.click());

            imageInput.addEventListener('change', function () {
                const file = this.files[0];
                if (!file || !file.type.startsWith('image/')) return;

                const reader = new FileReader();
                reader.onload = function (e) {
                    const base64 = e.target.result;

                    imageBox.style.backgroundImage = `url('${base64}')`;
                    imageBox.style.backgroundSize = 'cover';
                    imageBox.style.backgroundPosition = 'center';
                    imageBtn.style.display = 'none';

                    // Store base64 string in hidden input
                    let hiddenInput = form.querySelector('#imageBase64');
                    if (!hiddenInput) {
                        hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'image';
                        hiddenInput.id = 'imageBase64';
                        form.appendChild(hiddenInput);
                    }
                    hiddenInput.value = base64;
                };

                reader.readAsDataURL(file);
            });
        }

        // Custom callback handling
        if (callback) {
            const callbackFunction = window[callback];
            if (typeof callbackFunction === 'function') {
                callbackFunction(form);
            }
        }

        // Form submission handler
        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const confirm = form.getAttribute('data-confirm') || 'no';
            if (confirm === 'yes') {
                const confirmMessage = form.getAttribute('data-message') || 'Are you sure you want to continue?';
                if (!window.confirm(confirmMessage)) {
                    return;
                }
            }

            submit.disabled = true;

            try {
                // Always use FormData for form submissions to handle both regular and file inputs
                const formData = new FormData(form);

                const response = await fetch(form.getAttribute('action'), {
                    method: form.getAttribute('method').toUpperCase(),
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.status && data.status === 'success') {
                    const modal = document.querySelector('.modal:not(.hidden)');
                    if (modal) {
                        modal.classList.add('hidden');
                    }
                    toastr.success(data.message || 'Action completed');

                    // Handle file download
                    if (data.download_url) {
                        setTimeout(() => {
                            window.open(data.download_url, '_blank');
                        }, 500);
                    }

                    if (data.redirect) {
                        setTimeout(() => {
                            window.location.href = data.redirect;
                        }, 1000);
                    } else if (!data.download_url) {
                        window.location.reload();
                    }
                } else {
                    const errorMessage = data.error || data.message || 'Something went wrong';
                    if (message) {
                        message.innerHTML = `<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">${errorMessage}</div>`;
                    }
                    toastr.error(errorMessage);
                }
            } catch (error) {
                const errorMessage = error.message || 'Something went wrong';
                toastr.error(errorMessage);
            } finally {
                submit.disabled = false;
            }
        });
    }
}