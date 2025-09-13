<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Submit Doctoral Dissertation') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Complete all fields for proper documentation and classification</p>
            </div>
        </div>
    </x-slot>

    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-full max-h-screen mx-auto">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Form Content -->
                <div class="px-6 pb-6">
                    <form id="dissertation-upload-form" method="POST" action="{{ route('dissertations.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <div class="max-h-screen flex flex-vertical justify-between">
                            <!-- Left Column -->
                            <div class="h-full space-y-6 mr-6 flex-1">
                                <!-- Research Title -->
                                <div class="space-y-2">
                                    <label for="title" class="flex items-center text-sm font-medium text-gray-700">
                                        <svg class="w-4 h-4 mr-2 text-[#26225C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Research Title *
                                    </label>
                                    <input type="text" name="title" id="title" required 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#26225C] focus:border-[#26225C]"
                                        placeholder="Enter the full title of your research"
                                        value="{{ isset($editMode) && $editMode && isset($dissertation) ? $dissertation->title : old('title') }}">
                                    @error('title') 
                                        <p class="text-red-600 text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Author and Year -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label for="author" class="flex items-center text-sm font-medium text-gray-700">
                                            <svg class="w-4 h-4 mr-2 text-[#26225C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            Authors *
                                        </label>
                                        <input type="text" name="author" id="author" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#26225C] focus:border-[#26225C]"
                                            placeholder="Enter your full name"
                                            value="{{ isset($editMode) && $editMode && isset($dissertation) ? $dissertation->author : old('author') }}">
                                        @error('author') 
                                            <p class="text-red-600 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="space-y-2">
                                        <label for="year_completed" class="flex items-center text-sm font-medium text-gray-700">
                                            <svg class="w-4 h-4 mr-2 text-[#26225C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            Year Completed *
                                        </label>
                                        <input type="number" name="year_completed" id="year_completed" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#26225C] focus:border-[#26225C]"
                                            min="1900" max="{{ date('Y') + 5 }}" value="{{ isset($editMode) && $editMode && isset($dissertation) ? $dissertation->year_completed : old('year_completed', date('Y')) }}">
                                        @error('year_completed') 
                                            <p class="text-red-600 text-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Department -->
                                <div class="space-y-2">
                                    <label for="department" class="flex items-center text-sm font-medium text-gray-700">
                                        <svg class="w-4 h-4 mr-2 text-[#26225C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        Department *
                                    </label>
                                <select name="department" id="department" required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Select Department</option>
                                            <option value="College of Engineering and Architecture" {{ (isset($editMode) && $editMode && isset($dissertation) && $dissertation->department == 'College of Engineering and Architecture') ? 'selected' : (old('department') == 'College of Engineering and Architecture' ? 'selected' : '') }}>College of Engineering and Architecture</option>
                                            <option value="College of Computer Studies" {{ (isset($editMode) && $editMode && isset($dissertation) && $dissertation->department == 'College of Computer Studies') ? 'selected' : (old('department') == 'College of Computer Studies' ? 'selected' : '') }}>College of Computer Studies</option>
                                            <option value="College of Health Sciences" {{ (isset($editMode) && $editMode && isset($dissertation) && $dissertation->department == 'College of Health Sciences') ? 'selected' : (old('department') == 'College of Health Sciences' ? 'selected' : '') }}>College of Health Sciences</option>
                                            <option value="College of Social Work" {{ (isset($editMode) && $editMode && isset($dissertation) && $dissertation->department == 'College of Social Work') ? 'selected' : (old('department') == 'College of Social Work' ? 'selected' : '') }}>College of Social Work</option>
                                            <option value="College of Teacher Education, Arts and Sciences" {{ (isset($editMode) && $editMode && isset($dissertation) && $dissertation->department == 'College of Teacher Education, Arts and Sciences') ? 'selected' : (old('department') == 'College of Teacher Education, Arts and Sciences' ? 'selected' : '') }}>College of Teacher Education, Arts and Sciences</option>
                                            <option value="School of Business and Accountancy" {{ (isset($editMode) && $editMode && isset($dissertation) && $dissertation->department == 'School of Business and Accountancy') ? 'selected' : (old('department') == 'School of Business and Accountancy' ? 'selected' : '') }}>School of Business and Accountancy</option>
                                            <option value="Graduate School" {{ (isset($editMode) && $editMode && isset($dissertation) && $dissertation->department == 'Graduate School') ? 'selected' : (old('department') == 'Graduate School' ? 'selected' : '') }}>Graduate School</option>
                                        </select>
                                    @error('department') 
                                        <p class="text-red-600 text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Keywords -->
                                <div class="space-y-2">
                                    <label for="keywords" class="flex items-center text-sm font-medium text-gray-700">
                                        <svg class="w-4 h-4 mr-2 text-[#26225C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        Keywords *
                                    </label>
                                    <input type="text" name="keywords" id="keywords" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#26225C] focus:border-[#26225C]"
                                        placeholder="Enter keywords separated by commas"
                                        value="{{ isset($editMode) && $editMode && isset($dissertation) ? $dissertation->keywords : old('keywords') }}">
                                    <p class="text-xs text-gray-500">Example: machine learning, artificial intelligence, education, doctoral research</p>
                                    @error('keywords') 
                                        <p class="text-red-600 text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Abstract -->
                                <div class="space-y-2">
                                    <label for="abstract" class="flex items-center text-sm font-medium text-gray-700">
                                        <svg class="w-4 h-4 mr-2 text-[#26225C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Abstract *
                                    </label>
                                    <textarea name="abstract" id="abstract" rows="8" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#26225C] focus:border-[#26225C] resize-none"
                                        placeholder="Provide a comprehensive summary of your doctoral dissertation research (300-500 words recommended)">{{ isset($editMode) && $editMode && isset($dissertation) ? $dissertation->abstract : old('abstract') }}</textarea>
                                    @error('abstract') 
                                        <p class="text-red-600 text-sm">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <!-- Right Column -->
                            <div>
                                <!-- Document Upload -->
                                <div class="space-y-2">
                                    <label class="flex items-center text-sm font-medium text-gray-700">
                                        <svg class="w-4 h-4 mr-2 text-[#26225C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Research File *
                                    </label>
                                    <div class="border-2 border-dashed border-red-300 rounded-lg p-8 text-center bg-red-50 hover:bg-red-100 transition-colors">
                                        <input type="file" name="document_file" id="document_file" accept=".pdf" required class="hidden">
                                        <label for="document_file" class="cursor-pointer">
                                            <svg class="mx-auto h-16 w-16 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <p class="mt-4 text-lg text-gray-700">
                                                <span class="font-medium text-red-600 hover:text-red-500">Drag & Drop your file here or click to browse</span>
                                            </p>
                                            <p class="text-sm text-gray-500 mt-2">Accepted formats: PDF, DOC, DOCX</p>
                                        </label>
                                    </div>
                                    @error('document_file') 
                                        <p class="text-red-600 text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Research Citations Section -->
                                <div class="space-y-4 border-t pt-6">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg font-medium text-gray-900">Research Citations (Optional)</h3>
                                        <button type="button" id="add-citation-btn" class="bg-[#FFC72C] text-[#26225C] px-4 py-2 rounded-md hover:bg-[#FFD700] transition-colors text-sm">
                                            Add Citation
                                        </button>
                                    </div>
                                    <p class="text-sm text-gray-500">Tag research works that you've referenced in your dissertation</p>
                                    
                                    <div id="citations-container" class="space-y-3">
                                        <!-- Citations will be added here dynamically -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- button -->
                        <div>
                            <!-- Submit Button -->
                            <div class="pt-6">
                                <button type="submit" class="w-full bg-[#FFC72C] text-[#26225C] py-3 px-4 rounded-md hover:bg-[#FFD700] transition-colors font-medium flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                    Submit Research Project
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Word count for abstract
        document.getElementById('abstract').addEventListener('input', function(e) {
            const words = e.target.value.trim().split(/\s+/).filter(word => word.length > 0).length;
            document.getElementById('abstract-count').textContent = words + ' words';
        });

        // File upload preview
        document.getElementById('document_file').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const label = e.target.nextElementSibling;
                label.innerHTML = `
                    <div class="flex flex-col items-center justify-center pt-8 pb-8">
                        <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="text-lg font-semibold text-gray-700 mb-2">✅ ${file.name}</p>
                        <p class="text-sm text-gray-500 mb-4">File ready for upload</p>
                        <button type="button" onclick="clearFile('document_file')" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition duration-200 text-sm font-medium">
                            Change file
                        </button>
                    </div>
                `;
                label.className = label.className.replace('border-red-300 bg-red-50 hover:bg-red-100', 'border-green-300 bg-green-50 hover:bg-green-100');
            }
        });

        function clearFile(inputId) {
            document.getElementById(inputId).value = '';
            location.reload();
        }

        // Citation functionality
        document.getElementById('add-citation-btn').addEventListener('click', function() {
            const container = document.getElementById('citations-container');
            const index = container.children.length;

            const citationDiv = document.createElement('div');
            citationDiv.className = 'flex flex-col sm:flex-row items-start sm:items-center bg-red-50 p-4 rounded-lg border border-red-300';
            citationDiv.innerHTML = `
                <div class="flex-1 min-w-0">
                    <label for="citation_${index}" class="text-sm font-medium text-gray-700">Citation ${index + 1}</label>
                    <input type="text" name="citations[]" id="citation_${index}" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                        placeholder="Enter citation details">
                </div>
                <button type="button" onclick="removeCitation(this)" class="mt-3 sm:mt-0 sm:ml-3 bg-[#FFC72C] text-[#26225C] px-4 py-2 rounded-md hover:bg-[#FFD700] transition-colors text-sm">
                    Remove
                </button>
            `;
            container.appendChild(citationDiv);
        });

        function removeCitation(button) {
            button.closest('div').remove();
        }

        // Force AJAX form submission for dissertation upload
        document.getElementById('dissertation-upload-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Submitting...`;
            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    if (typeof window.toastr !== 'undefined') {
                        window.toastr.success(data.message);
                        setTimeout(() => {
                            window.location.href = '{{ route("research.history") }}';
                        }, 1500);
                    } else {
                        alert(data.message + ' Redirecting to research history...');
                        setTimeout(() => {
                            window.location.href = '{{ route("research.history") }}';
                        }, 1000);
                    }
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
                if (typeof window.toastr !== 'undefined') {
                    window.toastr.error('Failed to submit research');
                } else {
                    alert('Failed to submit research');
                }
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });
    </script>
</x-app-layout>
