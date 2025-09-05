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

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Red Header -->
                <div class="bg-red-600 px-8 py-6">
                    <h1 class="text-white text-xl font-semibold">Submit Your Research Project</h1>
                    <p class="text-red-100 text-sm mt-1">Complete all fields for proper documentation and classification</p>
                </div>

                <!-- Form Content -->
                <div class="p-8">
                    <form method="POST" action="{{ route('dissertations.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <!-- Research Title -->
                        <div class="space-y-2">
                            <label for="title" class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Research Title *
                            </label>
                            <input type="text" name="title" id="title" required 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                placeholder="Enter the full title of your research"
                                value="{{ old('title') }}">
                            @error('title') 
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Author and Year -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label for="author" class="flex items-center text-sm font-medium text-gray-700">
                                    <svg class="w-4 h-4 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Authors *
                                </label>
                                <input type="text" name="author" id="author" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                    placeholder="Enter your full name"
                                    value="{{ old('author') }}">
                                @error('author') 
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="year_completed" class="flex items-center text-sm font-medium text-gray-700">
                                    <svg class="w-4 h-4 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Year Completed *
                                </label>
                                <input type="number" name="year_completed" id="year_completed" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                    min="1900" max="{{ date('Y') + 5 }}" value="{{ old('year_completed', date('Y')) }}">
                                @error('year_completed') 
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Department -->
                        <div class="space-y-2">
                            <label for="department" class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                Department *
                            </label>
                            <select name="department" id="department" required 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                <option value="">Select Department</option>
                                <option value="Computer Science" {{ old('department') == 'Computer Science' ? 'selected' : '' }}>Computer Science</option>
                                <option value="Information Technology" {{ old('department') == 'Information Technology' ? 'selected' : '' }}>Information Technology</option>
                                <option value="Engineering" {{ old('department') == 'Engineering' ? 'selected' : '' }}>Engineering</option>
                                <option value="Business" {{ old('department') == 'Business' ? 'selected' : '' }}>Business</option>
                                <option value="Education" {{ old('department') == 'Education' ? 'selected' : '' }}>Education</option>
                                <option value="Medicine" {{ old('department') == 'Medicine' ? 'selected' : '' }}>Medicine</option>
                            </select>
                            @error('department') 
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Keywords -->
                        <div class="space-y-2">
                            <label for="keywords" class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                Keywords *
                            </label>
                            <input type="text" name="keywords" id="keywords" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                placeholder="Enter keywords separated by commas"
                                value="{{ old('keywords') }}">
                            <p class="text-xs text-gray-500">Example: machine learning, artificial intelligence, education, doctoral research</p>
                            @error('keywords') 
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Abstract -->
                        <div class="space-y-2">
                            <label for="abstract" class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Abstract *
                            </label>
                            <textarea name="abstract" id="abstract" rows="8" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 resize-none"
                                placeholder="Provide a comprehensive summary of your doctoral dissertation research (300-500 words recommended)">{{ old('abstract') }}</textarea>
                            @error('abstract') 
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Document Upload -->
                        <div class="space-y-2">
                            <label class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

                        <!-- Submit Button -->
                        <div class="pt-6">
                            <button type="submit" class="w-full bg-red-600 text-white py-3 px-4 rounded-md hover:bg-red-700 transition-colors font-medium flex items-center justify-center">
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

                                    <p class="text-xs text-gray-500 mt-1">🔬 Example: machine learning, artificial intelligence, education, doctoral research</p>
                                    @error('keywords') 
                                        <div class="flex items-center mt-2 text-red-600">
                                            <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="text-sm">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="abstract" class="block text-sm font-semibold text-gray-700">Abstract *</label>
                                    <textarea name="abstract" id="abstract" rows="8" required
                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 transition duration-200 bg-gray-50 focus:bg-white resize-none"
                                        placeholder="Provide a comprehensive summary of your doctoral dissertation research...">{{ old('abstract') }}</textarea>
                                    <div class="flex justify-between items-center">
                                        <p class="text-xs text-gray-500">📝 Provide a detailed summary of your dissertation research (300-500 words recommended for doctoral level)</p>
                                        <span class="text-xs text-gray-400" id="abstract-count">0 words</span>
                                    </div>
                                    @error('abstract') 
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

                        <!-- Step 3: Document Upload -->
                        <div class="space-y-8">
                            <div class="border-l-4 border-red-500 pl-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Step 3: Document Upload</h3>
                                <p class="text-gray-600 text-sm">Upload your dissertation document for review</p>
                            </div>
                            
                            <div class="space-y-4">
                                <label for="document_file" class="block text-sm font-semibold text-gray-700">Dissertation Document *</label>
                                <div class="relative">
                                    <input type="file" name="document_file" id="document_file" accept=".pdf" required class="sr-only">
                                    <label for="document_file" class="flex flex-col items-center justify-center w-full h-48 border-2 border-red-300 border-dashed rounded-xl cursor-pointer bg-red-50 hover:bg-red-100 transition duration-200">
                                        <div class="flex flex-col items-center justify-center pt-8 pb-8">
                                            <div class="w-16 h-16 bg-red-500 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                                </svg>
                                            </div>
                                            <p class="text-lg font-semibold text-gray-700 mb-2">Drop your dissertation file here</p>
                                            <p class="text-sm text-gray-500 mb-4">or click to browse</p>
                                            <div class="bg-white rounded-lg px-4 py-2 shadow-sm">
                                                <p class="text-sm text-red-700 font-medium">📄 PDF files only • Max 50MB</p>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                @error('document_file') 
                                    <div class="flex items-center mt-2 text-red-600">
                                        <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-sm">{{ $message }}</span>
                                    </div>
                                @enderror
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
                            <button type="submit" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg hover:from-red-700 hover:to-red-800 transition duration-200 shadow-lg font-semibold">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Submit Dissertation
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
    </script>
</x-app-layout>
