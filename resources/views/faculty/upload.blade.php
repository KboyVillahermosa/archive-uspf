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
                    <form method="POST" action="{{ route('faculty.store') }}" enctype="multipart/form-data" class="space-y-6">
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
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                <option value="">Select Department</option>
                                <option value="Computer Science" {{ old('department') == 'Computer Science' ? 'selected' : '' }}>Computer Science</option>
                                <option value="Information Technology" {{ old('department') == 'Information Technology' ? 'selected' : '' }}>Information Technology</option>
                                <option value="Engineering" {{ old('department') == 'Engineering' ? 'selected' : '' }}>Engineering</option>
                                <option value="Business" {{ old('department') == 'Business' ? 'selected' : '' }}>Business</option>
                                <option value="Education" {{ old('department') == 'Education' ? 'selected' : '' }}>Education</option>
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
                                <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Banner Image
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center bg-gray-50 hover:bg-gray-100 transition-colors">
                                <input type="file" name="banner_image" id="banner_image" accept="image/*" class="hidden">
                                <label for="banner_image" class="cursor-pointer">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-600">
                                        <span class="font-medium text-purple-600 hover:text-purple-500">Drag & Drop an image here or click to browse</span>
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
                            <div class="border-2 border-dashed border-purple-300 rounded-lg p-8 text-center bg-purple-50 hover:bg-purple-100 transition-colors">
                                <input type="file" name="research_file" id="research_file" accept=".pdf" required class="hidden">
                                <label for="research_file" class="cursor-pointer">
                                    <svg class="mx-auto h-16 w-16 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="mt-4 text-lg text-gray-700">
                                        <span class="font-medium text-purple-600 hover:text-purple-500">Drag & Drop your file here or click to browse</span>
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

                                        <div class="flex items-center mt-2 text-red-600">
                                            <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="text-sm">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: File Upload -->
                        <div class="space-y-8">
                            <div class="border-l-4 border-purple-500 pl-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Step 3: File Upload</h3>
                                <p class="text-gray-600 text-sm">Upload your research publication and optional banner image</p>
                            </div>
                            
                            <div class="grid grid-cols-1 gap-8">
                                <div class="space-y-4">
                                    <label for="banner_image" class="block text-sm font-semibold text-gray-700">Banner Image <span class="text-gray-400 font-normal">(Optional)</span></label>
                                    <div class="relative">
                                        <input type="file" name="banner_image" id="banner_image" accept="image/*" class="sr-only">
                                        <label for="banner_image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition duration-200">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <p class="text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                                <p class="text-xs text-gray-400">PNG, JPG up to 10MB</p>
                                            </div>
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-500">🖼️ Recommended: 1200 x 400px (3:1 ratio) for professional presentation</p>
                                    @error('banner_image') 
                                        <div class="flex items-center mt-2 text-red-600">
                                            <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="text-sm">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>

                                <div class="space-y-4">
                                    <label for="research_file" class="block text-sm font-semibold text-gray-700">Research Publication *</label>
                                    <div class="relative">
                                        <input type="file" name="research_file" id="research_file" accept=".pdf" required class="sr-only">
                                        <label for="research_file" class="flex flex-col items-center justify-center w-full h-48 border-2 border-purple-300 border-dashed rounded-xl cursor-pointer bg-purple-50 hover:bg-purple-100 transition duration-200">
                                            <div class="flex flex-col items-center justify-center pt-8 pb-8">
                                                <div class="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center mb-4">
                                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                                    </svg>
                                                </div>
                                                <p class="text-lg font-semibold text-gray-700 mb-2">Drop your research publication here</p>
                                                <p class="text-sm text-gray-500 mb-4">or click to browse</p>
                                                <div class="bg-white rounded-lg px-4 py-2 shadow-sm">
                                                    <p class="text-sm text-purple-700 font-medium">📄 PDF files only • Max 30MB</p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                    @error('research_file') 
                                        <div class="flex items-center mt-2 text-red-600">
                                            <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="text-sm">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-8 border-t border-gray-200">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200 font-semibold">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg hover:from-purple-700 hover:to-purple-800 transition duration-200 shadow-lg font-semibold">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Submit Faculty Research
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

        // File upload preview
        document.getElementById('research_file').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const dropZone = e.target.parentElement;
                dropZone.innerHTML = `
                    <div class="space-y-4">
                        <div class="flex justify-center">
                            <svg class="h-16 w-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-lg font-medium text-gray-700">✅ ${file.name}</p>
                            <p class="text-sm text-gray-500">File ready for upload</p>
                        </div>
                        <button type="button" onclick="this.parentElement.parentElement.parentElement.querySelector('input').value=''; location.reload();" class="text-sm text-purple-600 hover:text-purple-800">Change file</button>
                    </div>
                `;
            }
        });
    </script>
</x-app-layout>
