<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Submit Faculty Research Project') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Share your academic research and publications with the university community</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Purple Header -->
                <div class="bg-purple-600 px-8 py-6">
                    <h1 class="text-white text-xl font-semibold">Submit Your Research Project</h1>
                    <p class="text-purple-100 text-sm mt-1">Complete all fields for proper documentation and classification</p>
                </div>

                <!-- Form Content -->
                <div class="p-8">
                    <form id="faculty-upload-form" method="POST" action="{{ route('faculty.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <!-- Research Title -->
                        <div class="space-y-2">
                            <label for="title" class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Research Title *
                            </label>
                            <input type="text" name="title" id="title" required 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                placeholder="Enter the full title of your research"
                                value="{{ old('title') }}">
                            @error('title') 
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Co-Researchers -->
                        <div class="space-y-2">
                            <label for="co_researchers" class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                                Authors *
                            </label>
                            <input type="text" name="co_researchers" id="co_researchers" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                placeholder="Enter all faculty researchers (comma separated)"
                                value="{{ old('co_researchers') }}">
                            <p class="text-xs text-gray-500">Example: Dr. John Doe, Prof. Jane Smith, Dr. Alex Johnson</p>
                            @error('co_researchers') 
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Department -->
                        <div class="space-y-2">
                            <label for="department" class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                Department *
                            </label>
                           <select name="department" id="department" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Department</option>
                                    <option value="College of Engineering and Architecture" {{ old('department') == 'College of Engineering and Architecture' ? 'selected' : '' }}>College of Engineering and Architecture</option>
                                    <option value="College of Computer Studies" {{ old('department') == 'College of Computer Studies' ? 'selected' : '' }}>College of Computer Studies</option>
                                    <option value="College of Health Sciences" {{ old('department') == 'College of Health Sciences' ? 'selected' : '' }}>College of Health Sciences</option>
                                    <option value="College of Social Work" {{ old('department') == 'College of Social Work' ? 'selected' : '' }}>College of Social Work</option>
                                    <option value="College of Teacher Education, Arts and Sciences" {{ old('department') == 'College of Teacher Education, Arts and Sciences' ? 'selected' : '' }}>College of Teacher Education, Arts and Sciences</option>
                                    <option value="School of Business and Accountancy" {{ old('department') == 'School of Business and Accountancy' ? 'selected' : '' }}>School of Business and Accountancy</option>
                                    <option value="Graduate School" {{ old('department') == 'Graduate School' ? 'selected' : '' }}>Graduate School</option>
                                </select>
                            @error('department') 
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Abstract -->
                        <div class="space-y-2">
                            <label for="abstract" class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Abstract *
                            </label>
                            <textarea name="abstract" id="abstract" rows="6" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 resize-none"
                                placeholder="Provide a comprehensive summary of your faculty research (300-400 words recommended)">{{ old('abstract') }}</textarea>
                            @error('abstract') 
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                            <p id="abstract-count" class="text-xs text-gray-500 mt-1">0 words</p>
                        </div>

                        <!-- Keywords -->
                        <div class="space-y-2">
                            <label for="tags" class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                Research Keywords (Optional)
                            </label>
                            <input type="text" name="tags" id="tags"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                placeholder="Enter keywords separated by commas"
                                value="{{ old('tags') }}">
                        </div>

                      <!-- Banner Image Upload -->
                        <div class="space-y-2">
                            <label class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                Banner Image
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center bg-gray-50 hover:bg-gray-100 transition-colors">
                                <input type="file" name="banner_image" id="banner_image" accept="image/*" class="hidden">
                                <label for="banner_image" class="cursor-pointer">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-600">
                                        <span class="font-medium text-blue-600 hover:text-blue-500">Drag & Drop an image here or click to browse</span>
                                    </p>
                                    <p class="text-xs text-gray-500">Recommended: 1200 x 400px (3:1 ratio)</p>
                                </label>
                            </div>
                        </div>
                        <!-- Research File Upload -->
                        <div class="space-y-2">
                            <label class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Research File *
                            </label>
                            <div id="research_file_container" class="border-2 border-dashed border-purple-300 rounded-lg p-8 text-center bg-purple-50 hover:bg-purple-100 transition-colors">
                                <input type="file" name="research_file" id="research_file" accept=".pdf,.doc,.docx" required class="hidden">
                                <label for="research_file" class="cursor-pointer">
                                    <div id="research_file_content">
                                        <svg class="mx-auto h-16 w-16 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="mt-4 text-lg text-gray-700">
                                            <span class="font-medium text-purple-600 hover:text-purple-500">Drag & Drop your file here or click to browse</span>
                                        </p>
                                        <p class="text-sm text-gray-500 mt-2">Accepted formats: PDF, DOC, DOCX</p>
                                    </div>
                                </label>
                            </div>
                            @error('research_file') 
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Research Citations Section -->
                        <div class="space-y-4 border-t pt-6">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium text-gray-900">Research Citations (Optional)</h3>
                                <button type="button" id="add-citation-btn" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition-colors text-sm">
                                    Add Citation
                                </button>
                            </div>
                            <p class="text-sm text-gray-500">Tag research works that you've referenced in your project</p>
                            
                            <div id="citations-container" class="space-y-3">
                                <!-- Citations will be added here dynamically -->
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-6">
                            <button type="submit" class="w-full bg-purple-600 text-white py-3 px-4 rounded-md hover:bg-purple-700 transition-colors font-medium flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Submit Research Project
                            </button>
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

        // File upload preview for research file
        document.getElementById('research_file').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const container = document.getElementById('research_file_container');
                const content = document.getElementById('research_file_content');
                
                content.innerHTML = `
                    <div class="flex flex-col items-center justify-center pt-8 pb-8">
                        <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="text-lg font-semibold text-gray-700 mb-2">✅ ${file.name}</p>
                        <p class="text-sm text-gray-500 mb-4">File ready for upload</p>
                        <button type="button" onclick="clearFile('research_file')" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition duration-200 text-sm font-medium">
                            Change file
                        </button>
                    </div>
                `;
                container.className = container.className.replace('border-purple-300 bg-purple-50 hover:bg-purple-100', 'border-green-300 bg-green-50 hover:bg-green-100');
            }
        });

         // File upload preview for banner image
        document.getElementById('banner_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const label = e.target.nextElementSibling;
                const reader = new FileReader();
                reader.onload = function(e) {
                    label.innerHTML = `
                        <div class="relative w-full h-full">
                            <img src="${e.target.result}" alt="Preview" class="w-full h-full object-cover rounded-lg">
                            <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center rounded-lg">
                                <button type="button" onclick="clearFile('banner_image')" class="bg-white text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-100 transition duration-200 text-sm font-medium">
                                    Change image
                                </button>
                            </div>
                        </div>
                    `;
                };
                reader.readAsDataURL(file);
            }
        });

        function clearFile(inputId) {
            document.getElementById(inputId).value = '';
            location.reload();
        }

        // Force AJAX form submission for faculty upload
        document.getElementById('faculty-upload-form').addEventListener('submit', function(e) {
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

        // Citation functionality
        document.getElementById('add-citation-btn').addEventListener('click', function() {
            const container = document.getElementById('citations-container');
            const index = container.children.length;
            
            const citationHtml = `
                <div class="flex items-center space-x-4" id="citation-${index}">
                    <input type="text" name="citations[]" required
                        class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                        placeholder="Enter citation (e.g., Doe, J. (2020). Title of the research. Journal Name, Volume(Issue), Page range.)">
                    <button type="button" onclick="removeCitation(${index})" class="text-red-600 hover:text-red-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', citationHtml);
        });

        window.removeCitation = function(index) {
            const citationElement = document.getElementById(`citation-${index}`);
            if (citationElement) {
                citationElement.remove();
            }
        }

        // [Same citation JavaScript code as student upload but with faculty type]
    </script>
</x-app-layout>
