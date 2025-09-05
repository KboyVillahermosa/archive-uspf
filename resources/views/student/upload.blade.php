<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Submit Student Research') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Share your undergraduate research project with the academic community
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Blue Header -->
                <div class="bg-blue-600 px-8 py-6">
                    <h1 class="text-white text-xl font-semibold">Submit Your Research Project</h1>
                    <p class="text-blue-100 text-sm mt-1">Complete all fields for proper documentation and classification
                    </p>
                </div>

                <!-- Form Content -->
                <div class="p-8">
                    <form method="POST" action="{{ route('student.store') }}" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf
                        
                        <!-- Research Title -->
                        <div class="space-y-2">
                            <label for="title" class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                Research Title *
                            </label>
                            <input type="text" name="title" id="title" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Enter the full title of your research"
                                value="{{ old('title') }}">
                            @error('title') 
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Authors -->
                        <div class="space-y-2">
                            <label for="authors" class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                    </path>
                                </svg>
                                Authors *
                            </label>
                            <input type="text" name="authors" id="authors" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Enter all authors (comma separated)"
                                value="{{ old('authors') }}">
                            <p class="text-xs text-gray-500">Example: John Doe, Jane Smith, Alex Johnson</p>
                            @error('authors') 
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Department and Program -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label for="department" class="flex items-center text-sm font-medium text-gray-700">
                                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                    Department *
                                </label>
                                <select name="department" id="department" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Department</option>
                                    <option value="Computer Science" {{ old('department') == 'Computer Science' ? 'selected' : '' }}>
                                        Computer Science</option>
                                    <option value="Information Technology" {{ old('department') == 'Information Technology' ? 'selected' : '' }}>
                                        Information Technology</option>
                                    <option value="Engineering" {{ old('department') == 'Engineering' ? 'selected' : '' }}>
                                        Engineering</option>
                                    <option value="Business" {{ old('department') == 'Business' ? 'selected' : '' }}>
                                        Business</option>
                                </select>
                                @error('department') 
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="program" class="flex items-center text-sm font-medium text-gray-700">
                                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z">
                                        </path>
                                    </svg>
                                    Program *
                                </label>
                                <select name="program" id="program" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Program</option>
                                    <option value="BSIT" {{ old('program') == 'BSIT' ? 'selected' : '' }}>BSIT
                                    </option>
                                    <option value="BSCS" {{ old('program') == 'BSCS' ? 'selected' : '' }}>BSCS
                                    </option>
                                    <option value="BSE" {{ old('program') == 'BSE' ? 'selected' : '' }}>BSE
                                    </option>
                                    <option value="BSA" {{ old('program') == 'BSA' ? 'selected' : '' }}>BSA
                                    </option>
                                </select>
                                @error('program') 
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Abstract -->
                        <div class="space-y-2">
                            <label for="abstract" class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                Abstract *
                            </label>
                            <textarea name="abstract" id="abstract" rows="6" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                                placeholder="Provide a concise summary of your research (250-300 words recommended)">{{ old('abstract') }}</textarea>
                            @error('abstract') 
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Keywords -->
                        <div class="space-y-2">
                            <label for="tags" class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                    </path>
                                </svg>
                                Keywords (Optional)
                            </label>
                            <input type="text" name="tags" id="tags"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
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
                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                Research File *
                            </label>
                            <div class="border-2 border-dashed border-blue-300 rounded-lg p-8 text-center bg-blue-50 hover:bg-blue-100 transition-colors">
                                <input type="file" name="research_file" id="research_file" accept=".pdf" required class="hidden">
                                <label for="research_file" class="cursor-pointer">
                                    <svg class="mx-auto h-16 w-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="mt-4 text-lg text-gray-700">
                                        <span class="font-medium text-blue-600 hover:text-blue-500">Drag & Drop your file here or click to browse</span>
                                    </p>
                                    <p class="text-sm text-gray-500 mt-2">Accepted formats: PDF, DOC, DOCX</p>
                                </label>
                            </div>
                            @error('research_file') 
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-6">
                            <button type="submit"
                                class="w-full bg-blue-600 text-white py-3 px-4 rounded-md hover:bg-blue-700 transition-colors font-medium flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Submit Research Project
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

                                    </p>
                                    @error('tags') 
                                        <div class="flex items-center mt-2 text-red-600">
                                            <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="text-sm">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: File Upload -->
                        <div class="space-y-8">
                            <div class="border-l-4 border-blue-500 pl-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Step 3: File Upload</h3>
                                <p class="text-gray-600 text-sm">Upload your research document and optional banner image</p>
                            </div>
                            
                            <div class="grid grid-cols-1 gap-8">
                                <div class="space-y-4">
                                    <label for="banner_image" class="block text-sm font-semibold text-gray-700">Banner Image
                                        <span class="text-gray-400 font-normal">(Optional)</span>
                                    </label>
                                    <div class="relative">
                                        <input type="file" name="banner_image" id="banner_image" accept="image/*"
                                            class="sr-only">
                                        <label for="banner_image"
                                            class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition duration-200">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                <p class="text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                                <p class="text-xs text-gray-400">PNG, JPG up to 10MB</p>
                                            </div>
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-500">🖼️ Recommended: 1200 x 400px (3:1 ratio) for optimal display
                                    </p>
                                    @error('banner_image') 
                                        <div class="flex items-center mt-2 text-red-600">
                                            <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="text-sm">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>

                                <div class="space-y-4">
                                    <label for="research_file" class="block text-sm font-semibold text-gray-700">Research Document
                                        *</label>
                                    <div class="relative">
                                        <input type="file" name="research_file" id="research_file" accept=".pdf" required class="sr-only">
                                        <label for="research_file"
                                            class="flex flex-col items-center justify-center w-full h-48 border-2 border-blue-300 border-dashed rounded-xl cursor-pointer bg-blue-50 hover:bg-blue-100 transition duration-200">
                                            <div class="flex flex-col items-center justify-center pt-8 pb-8">
                                                <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mb-4">
                                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <p class="text-lg font-semibold text-gray-700 mb-2">Drop your research file here
                                                </p>
                                                <p class="text-sm text-gray-500 mb-4">or click to browse</p>
                                                <div class="bg-white rounded-lg px-4 py-2 shadow-sm">
                                                    <p class="text-sm text-blue-700 font-medium">📄 PDF files only • Max 20MB</p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                    @error('research_file') 
                                        <div class="flex items-center mt-2 text-red-600">
                                            <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="text-sm">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-8 border-t border-gray-200">
                            <a href="{{ route('dashboard') }}"
                                class="inline-flex items-center px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200 font-semibold">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Cancel
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition duration-200 shadow-lg font-semibold">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
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
                        <button type="button" onclick="clearFile('research_file')" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition duration-200 text-sm font-medium">
                            Change file
                        </button>
                    </div>
                `;
                label.className = label.className.replace('border-blue-300 bg-blue-50 hover:bg-blue-100', 'border-green-300 bg-green-50 hover:bg-green-100');
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
    </script>
</x-app-layout>
