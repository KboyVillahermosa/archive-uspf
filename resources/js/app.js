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
    timeOut: 3000,
};
window.toastr = toastr;

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
                // Check if form has file inputs - if so, use FormData, otherwise use JSON
                const hasFileInput = form.querySelector('input[type="file"]');
                let requestBody;
                let contentType;

                if (hasFileInput) {
                    // Use FormData for file uploads
                    requestBody = new FormData(form);
                    contentType = {}; // Let browser set multipart/form-data
                } else {
                    // Use JSON for regular forms
                    const formData = new FormData(form);
                    const formObject = {};

                    formData.forEach((value, key) => {
                        if (key.endsWith('[]')) {
                            const fieldName = key.replace('[]', '');
                            if (!formObject[fieldName]) {
                                formObject[fieldName] = [];
                            }
                            formObject[fieldName].push(value);
                        } else {
                            formObject[key] = value;
                        }
                    });

                    requestBody = JSON.stringify(formObject);
                    contentType = { 'Content-Type': 'application/json' };
                }

                const response = await fetch(form.getAttribute('action'), {
                    method: form.getAttribute('method').toUpperCase(),
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        ...contentType
                    },
                    body: requestBody
                });

                const data = await response.json();

                if (data.status && data.status === 'success') {
                    const modal = document.querySelector('.modal:not(.hidden)');
                    if (modal) {
                        modal.classList.add('hidden');
                    }
                    toastr.success(data.message || 'Action completed');

                    if (data.redirect) {
                        setTimeout(() => {
                            window.location.href = data.redirect;
                        }, 1000);
                    } else {
                        window.location.reload();
                    }
                } else {
                    const errorMessage = data.error || data.message || 'Something went wrong';
                    if (message) {
                        message.innerHTML = errorMessage;
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

