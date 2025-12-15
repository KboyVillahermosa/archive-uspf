<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            <!-- Header -->
            <div class="mb-10">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-[#26225C] to-[#3a3770] rounded-xl flex items-center justify-center">
                        <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                        <h1 class="text-4xl font-light text-[#26225C] mb-1">Submit Doctoral Dissertation</h1>
                        <p class="text-gray-600">Complete all fields for proper documentation and classification</p>
                        </div>
                    </div>
                </div>

            <form id="dissertation-upload-form" method="POST" action="{{ route('dissertations.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Main Form Content -->
                    <div class="lg:col-span-2 space-y-8">
                        <!-- Research Details Section -->
                        <div>
                            <div class="mb-6 pb-4 border-b border-[#FFC72C]">
                                <h2 class="text-2xl font-light text-[#26225C] mb-1">Research Information</h2>
                                <p class="text-sm text-gray-500">Provide essential details about your dissertation</p>
                            </div>
                            
                            <div class="space-y-6">
                                <!-- Title -->
                                <div id="field-title">
                                    <label for="title" class="block text-sm font-semibold text-[#26225C] mb-2">
                                        Research Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" id="title" required 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#26225C] focus:border-[#FFC72C] transition-all bg-white"
                                placeholder="Enter the full title of your research"
                                value="{{ isset($editMode) && $editMode && isset($dissertation) ? $dissertation->title : old('title') }}">
                            @error('title') 
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Author and Year -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="author" class="block text-sm font-semibold text-[#26225C] mb-2">
                                            Authors <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="author" id="author" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#26225C] focus:border-[#FFC72C] transition-all bg-white"
                                    placeholder="Enter your full name"
                                    value="{{ isset($editMode) && $editMode && isset($dissertation) ? $dissertation->author : old('author') }}">
                                @error('author') 
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                                    <div>
                                        <label for="year_completed" class="block text-sm font-semibold text-[#26225C] mb-2">
                                            Year Completed <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="year_completed" id="year_completed" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#26225C] focus:border-[#FFC72C] transition-all bg-white"
                                    min="1900" max="{{ date('Y') + 5 }}" value="{{ isset($editMode) && $editMode && isset($dissertation) ? $dissertation->year_completed : old('year_completed', date('Y')) }}">
                                @error('year_completed') 
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Department and Program -->
                                <div id="field-department" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="department" class="block text-sm font-semibold text-[#26225C] mb-2">
                                            Department <span class="text-red-500">*</span>
                                </label>
                                <select name="department" id="department" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#26225C] focus:border-[#FFC72C] transition-all bg-white">
                                        <option value="">Select Department</option>
                                    </select>
                                @error('department') 
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                                    <div>
                                        <label for="program" class="block text-sm font-semibold text-[#26225C] mb-2">
                                            Program <span class="text-red-500">*</span>
                                </label>
                                <select name="program" id="program" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#26225C] focus:border-[#FFC72C] transition-all bg-white">
                                        <option value="">Select Program</option>
                                    </select>
                                @error('program') 
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Adviser -->
                                <div id="field-adviser">
                                    <label for="adviser_search" class="block text-sm font-semibold text-[#26225C] mb-2">
                                        Adviser <span class="text-gray-400 text-xs font-normal">(Optional)</span>
                                    </label>
                                    <div class="relative">
                                        <input 
                                            type="text" 
                                            id="adviser_search" 
                                            placeholder="Search for faculty adviser..." 
                                            autocomplete="off"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#26225C] focus:border-[#FFC72C] transition-all bg-white"
                                        >
                                        <div id="adviser_results" class="absolute z-10 w-full bg-white border border-gray-300 rounded-xl mt-1 max-h-60 overflow-y-auto hidden shadow-lg"></div>
                                    </div>
                                    <input type="hidden" name="adviser_id" id="adviser_id" value="{{ old('adviser_id') }}">
                                    <div id="adviser_selected" class="mt-3 hidden">
                                        <div class="flex items-center justify-between p-3 bg-green-50 border border-green-200 rounded-xl">
                                            <div>
                                                <p class="font-medium text-[#26225C]" id="adviser_name"></p>
                                                <p class="text-sm text-gray-600 mt-1" id="adviser_email"></p>
                                            </div>
                                            <button type="button" onclick="clearAdviser()" class="text-[#26225C] hover:text-red-600 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1.5">Select a faculty member as your research adviser</p>
                                    @error('adviser_id') 
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                        <!-- Keywords -->
                                <div>
                                    <label for="keywords" class="block text-sm font-semibold text-[#26225C] mb-2">
                                        Keywords <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="keywords" id="keywords" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#26225C] focus:border-[#FFC72C] transition-all bg-white"
                                        placeholder="keyword1, keyword2, keyword3"
                                value="{{ isset($editMode) && $editMode && isset($dissertation) ? $dissertation->keywords : old('keywords') }}">
                                    <p class="text-xs text-gray-500 mt-1.5">Separate keywords with commas</p>
                            @error('keywords') 
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Abstract -->
                                <div id="field-abstract">
                                    <label for="abstract" class="block text-sm font-semibold text-[#26225C] mb-2">
                                        Abstract <span class="text-red-500">*</span>
                            </label>
                            <textarea name="abstract" id="abstract" rows="8" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#26225C] focus:border-[#FFC72C] transition-all resize-none bg-white"
                                placeholder="Provide a comprehensive summary of your doctoral dissertation research (300-500 words recommended)">{{ isset($editMode) && $editMode && isset($dissertation) ? $dissertation->abstract : old('abstract') }}</textarea>
                                    <p class="text-xs text-gray-500 mt-1.5">Recommended: 300-500 words</p>
                            @error('abstract') 
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                                </div>
                            </div>
                        </div>

                        <!-- File Upload Section -->
                        <div>
                            <div class="mb-6 pb-4 border-b border-[#FFC72C]">
                                <h2 class="text-2xl font-light text-[#26225C] mb-1">Upload Files</h2>
                                <p class="text-sm text-gray-500">Upload your dissertation document</p>
                            </div>
                            
                            <div class="space-y-6">
                                <!-- Abstract PDF Upload -->
                                <div id="field-abstract_file">
                                    <label class="block text-sm font-semibold text-[#26225C] mb-2">
                                        Abstract PDF <span class="text-red-500">*</span>
                            </label>
                                    <div class="border-2 border-dashed border-[#FFC72C] rounded-xl p-10 text-center bg-[#FFC72C] bg-opacity-5 hover:bg-opacity-10 transition-all cursor-pointer group">
                                <input type="file" name="abstract_file" id="abstract_file" accept=".pdf" required class="hidden">
                                <label for="abstract_file" class="cursor-pointer">
                                            <div class="w-20 h-20 bg-[#26225C] rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                                                <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                            </div>
                                            <p class="text-base text-[#26225C] font-semibold mb-1">
                                                Click to upload or drag and drop
                                    </p>
                                            <p class="text-sm text-gray-600">PDF (Max 10MB)</p>
                                </label>
                            </div>
                            @error('abstract_file') 
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                                </div>

                                <!-- Research File Upload -->
                                <div id="field-document_file">
                                    <label class="block text-sm font-semibold text-[#26225C] mb-2">
                                        Full Documentation PDF <span class="text-red-500">*</span>
                            </label>
                                    <div class="border-2 border-dashed border-[#FFC72C] rounded-xl p-10 text-center bg-[#FFC72C] bg-opacity-5 hover:bg-opacity-10 transition-all cursor-pointer group">
                                <input type="file" name="document_file" id="document_file" accept=".pdf" required class="hidden">
                                <label for="document_file" class="cursor-pointer">
                                            <div class="w-20 h-20 bg-[#26225C] rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                                                <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                            </div>
                                            <p class="text-base text-[#26225C] font-semibold mb-1">
                                                Click to upload or drag and drop
                                    </p>
                                            <p class="text-sm text-gray-600">PDF (Max 10MB)</p>
                                </label>
                            </div>
                            @error('document_file') 
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Research Citations Section -->
                        <div>
                            <div class="mb-6 pb-4 border-b border-[#FFC72C]">
                            <div class="flex items-center justify-between">
                                    <div>
                                        <h2 class="text-2xl font-light text-[#26225C] mb-1">Research Citations</h2>
                                        <p class="text-sm text-gray-500">Tag research works that you've referenced</p>
                                    </div>
                                    <button type="button" id="add-citation-btn" class="px-5 py-2.5 bg-[#26225C] hover:bg-[#3a3770] text-white rounded-xl transition-colors text-sm font-semibold flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    Add Citation
                                </button>
                                </div>
                            </div>
                            
                            <div id="citations-container" class="space-y-4">
                                <!-- Citations will be added here dynamically -->
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="lg:col-span-1">
                        <div class="sticky top-8 space-y-6">
                            <!-- Progress/Info Card -->
                            <div class="bg-white border border-gray-200 rounded-xl p-6">
                                <h3 class="text-lg font-semibold text-[#26225C] mb-4">Submission Checklist</h3>
                                <div class="space-y-3">
                                    <button type="button" onclick="scrollToField('title')" class="w-full flex items-center space-x-3 hover:bg-gray-50 p-2 rounded-lg transition-colors text-left group">
                                        <div class="w-6 h-6 rounded-full border-2 border-[#FFC72C] flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                            <div class="w-3 h-3 bg-[#FFC72C] rounded-full"></div>
                                        </div>
                                        <span class="text-sm text-gray-700 group-hover:text-[#26225C] transition-colors">Research title and author</span>
                                    </button>
                                    <button type="button" onclick="scrollToField('department')" class="w-full flex items-center space-x-3 hover:bg-gray-50 p-2 rounded-lg transition-colors text-left group">
                                        <div class="w-6 h-6 rounded-full border-2 border-[#FFC72C] flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                            <div class="w-3 h-3 bg-[#FFC72C] rounded-full"></div>
                                        </div>
                                        <span class="text-sm text-gray-700 group-hover:text-[#26225C] transition-colors">Department and program</span>
                                    </button>
                                    <button type="button" onclick="scrollToField('abstract')" class="w-full flex items-center space-x-3 hover:bg-gray-50 p-2 rounded-lg transition-colors text-left group">
                                        <div class="w-6 h-6 rounded-full border-2 border-[#FFC72C] flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                            <div class="w-3 h-3 bg-[#FFC72C] rounded-full"></div>
                                        </div>
                                        <span class="text-sm text-gray-700 group-hover:text-[#26225C] transition-colors">Abstract (300-500 words)</span>
                                    </button>
                                    <button type="button" onclick="scrollToField('document_file')" class="w-full flex items-center space-x-3 hover:bg-gray-50 p-2 rounded-lg transition-colors text-left group">
                                        <div class="w-6 h-6 rounded-full border-2 border-[#FFC72C] flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                            <div class="w-3 h-3 bg-[#FFC72C] rounded-full"></div>
                                        </div>
                                        <span class="text-sm text-gray-700 group-hover:text-[#26225C] transition-colors">Abstract PDF</span>
                                    </button>
                                    <button type="button" onclick="scrollToField('document_file')" class="w-full flex items-center space-x-3 hover:bg-gray-50 p-2 rounded-lg transition-colors text-left group">
                                        <div class="w-6 h-6 rounded-full border-2 border-[#FFC72C] flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                            <div class="w-3 h-3 bg-[#FFC72C] rounded-full"></div>
                                        </div>
                                        <span class="text-sm text-gray-700 group-hover:text-[#26225C] transition-colors">Full Documentation PDF</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Help Card -->
                            <div class="bg-gradient-to-br from-[#26225C] to-[#3a3770] rounded-xl p-6 text-white">
                                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mb-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold mb-2">Need Help?</h3>
                                <p class="text-sm text-white text-opacity-90 mb-4">Make sure all required fields are filled and your dissertation file is properly formatted.</p>
                                <p class="text-xs text-white text-opacity-75">Your submission will be reviewed by administrators before being published.</p>
                        </div>

                        <!-- Submit Button -->
                            <button type="submit" class="w-full bg-[#26225C] hover:bg-[#3a3770] text-white py-4 px-6 rounded-xl transition-all font-semibold flex items-center justify-center gap-2 text-base shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Submit Dissertation
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Scroll to field function
        function scrollToField(fieldId) {
            const fieldElement = document.getElementById(`field-${fieldId}`);
            if (fieldElement) {
                fieldElement.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'center' 
                });
                // Add a highlight effect
                fieldElement.classList.add('ring-2', 'ring-[#FFC72C]', 'ring-opacity-50');
                setTimeout(() => {
                    fieldElement.classList.remove('ring-2', 'ring-[#FFC72C]', 'ring-opacity-50');
                }, 2000);
                // Focus on the input if it exists
                const inputElement = document.getElementById(fieldId);
                if (inputElement) {
                    setTimeout(() => {
                        inputElement.focus();
                    }, 500);
                }
            }
        }

        // Load departments on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadDepartments();
        });

        // Function to load departments from API
        async function loadDepartments() {
            try {
                const response = await fetch('/api/departments', {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                const departments = await response.json();
                
                const departmentSelect = document.getElementById('department');
                departmentSelect.innerHTML = '<option value="">Select Department</option>';
                
                departments.forEach(department => {
                    const option = document.createElement('option');
                    option.value = department.id;
                    option.textContent = department.name;
                    departmentSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Error loading departments:', error);
                if (typeof toastr !== 'undefined') {
                toastr.error('Failed to load departments');
                }
            }
        }

        // Function to load programs based on selected department
        async function loadPrograms(departmentId) {
            try {
                const response = await fetch(`/api/departments/${departmentId}/programs`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                const programs = await response.json();
                
                const programSelect = document.getElementById('program');
                programSelect.innerHTML = '<option value="">Select Program</option>';
                
                programs.forEach(program => {
                    const option = document.createElement('option');
                    option.value = program.id;
                    option.textContent = program.name;
                    programSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Error loading programs:', error);
                if (typeof toastr !== 'undefined') {
                toastr.error('Failed to load programs');
                }
            }
        }

        // Handle department selection change
        document.getElementById('department').addEventListener('change', function() {
            const departmentId = this.value;
            if (departmentId) {
                loadPrograms(departmentId);
            } else {
                // Clear programs if no department selected
                const programSelect = document.getElementById('program');
                programSelect.innerHTML = '<option value="">Select Program</option>';
            }
        });

        // File upload preview for abstract file
        document.getElementById('abstract_file').addEventListener('change', function(e) {
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
                        <p class="text-sm text-gray-500 mb-4">Abstract PDF ready for upload</p>
                        <button type="button" onclick="clearFile('abstract_file')" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition duration-200 text-sm font-medium">
                            Change file
                        </button>
                    </div>
                `;
            }
        });

        // File upload preview for document file
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
            }
        });

        function clearFile(inputId) {
            document.getElementById(inputId).value = '';
            location.reload();
        }

        // Citation functionality
        let citationCount = 0;
        const citations = [];

        document.getElementById('add-citation-btn').addEventListener('click', function() {
            addCitationForm();
        });

        function addCitationForm() {
            citationCount++;
            const container = document.getElementById('citations-container');
            
            const citationDiv = document.createElement('div');
            citationDiv.className = 'border border-gray-200 rounded-lg p-4 bg-gray-50';
            citationDiv.id = `citation-${citationCount}`;
            
            citationDiv.innerHTML = `
                <div class="flex items-start justify-between mb-3">
                    <h4 class="font-medium text-gray-900">Reference #${citationCount}</h4>
                    <button type="button" onclick="removeCitation(${citationCount})" class="text-red-600 hover:text-red-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Search Research to Cite</label>
                        <div class="relative">
                            <input type="text" id="search-${citationCount}" placeholder="Type to search approved research..." 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#26225C]">
                            <div id="results-${citationCount}" class="absolute z-10 w-full bg-white border border-gray-300 rounded-md mt-1 max-h-60 overflow-y-auto hidden"></div>
                        </div>
                        <input type="hidden" id="selected-research-${citationCount}" name="citations[${citationCount}][research_id]">
                        <input type="hidden" id="selected-type-${citationCount}" name="citations[${citationCount}][research_type]">
                        <div id="selected-display-${citationCount}" class="mt-2 hidden">
                            <div class="bg-blue-50 border border-blue-200 rounded-md p-3">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-blue-900" id="selected-title-${citationCount}"></p>
                                        <p class="text-sm text-blue-700" id="selected-authors-${citationCount}"></p>
                                    </div>
                                    <button type="button" onclick="clearSelection(${citationCount})" class="text-blue-600 hover:text-blue-800">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">How did you use this research? (Optional)</label>
                        <textarea name="citations[${citationCount}][context]" rows="2" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#26225C]"
                            placeholder="Briefly describe how this research helped your work..."></textarea>
                    </div>
                </div>
            `;
            
            container.appendChild(citationDiv);
            setupCitationSearch(citationCount);
        }

        function setupCitationSearch(count) {
            const searchInput = document.getElementById(`search-${count}`);
            const resultsDiv = document.getElementById(`results-${count}`);
            let searchTimeout;

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const query = this.value.trim();
                
                if (query.length < 2) {
                    resultsDiv.classList.add('hidden');
                    return;
                }
                
                searchTimeout = setTimeout(() => {
                    fetch(`/citations/search?q=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(data => {
                            displaySearchResults(count, data);
                        })
                        .catch(error => {
                            console.error('Search error:', error);
                        });
                }, 300);
            });
        }

        function displaySearchResults(count, results) {
            const resultsDiv = document.getElementById(`results-${count}`);
            
            if (results.length === 0) {
                resultsDiv.innerHTML = '<div class="p-3 text-gray-500 text-sm">No approved research found</div>';
                resultsDiv.classList.remove('hidden');
                return;
            }
            
            resultsDiv.innerHTML = results.map(item => `
                <div class="p-3 hover:bg-gray-50 cursor-pointer border-b border-gray-100 last:border-b-0" 
                     onclick="selectResearch(${count}, ${item.id}, '${item.type}', '${item.title.replace(/'/g, "\\'")}', '${item.authors.replace(/'/g, "\\'")}')">
                    <div class="font-medium text-gray-900">${item.title}</div>
                    <div class="text-sm text-gray-600">${item.authors}</div>
                    <div class="text-xs text-blue-600 mt-1">${item.type.charAt(0).toUpperCase() + item.type.slice(1)} Research</div>
                </div>
            `).join('');
            
            resultsDiv.classList.remove('hidden');
        }

        function selectResearch(count, id, type, title, authors) {
            document.getElementById(`selected-research-${count}`).value = id;
            document.getElementById(`selected-type-${count}`).value = type;
            document.getElementById(`selected-title-${count}`).textContent = title;
            document.getElementById(`selected-authors-${count}`).textContent = authors;
            document.getElementById(`search-${count}`).value = '';
            document.getElementById(`results-${count}`).classList.add('hidden');
            document.getElementById(`selected-display-${count}`).classList.remove('hidden');
        }

        function clearSelection(count) {
            document.getElementById(`selected-research-${count}`).value = '';
            document.getElementById(`selected-type-${count}`).value = '';
            document.getElementById(`selected-display-${count}`).classList.add('hidden');
        }

        function removeCitation(count) {
            document.getElementById(`citation-${count}`).remove();
        }

        // Adviser search functionality
        const adviserSearchInput = document.getElementById('adviser_search');
        const adviserResultsDiv = document.getElementById('adviser_results');
        const adviserIdInput = document.getElementById('adviser_id');
        const adviserSelectedDiv = document.getElementById('adviser_selected');
        let adviserSearchTimeout;

        if (adviserSearchInput) {
            adviserSearchInput.addEventListener('input', function() {
                clearTimeout(adviserSearchTimeout);
                const query = this.value.trim();
                
                if (query.length < 2) {
                    adviserResultsDiv.classList.add('hidden');
                    return;
                }
                
                adviserSearchTimeout = setTimeout(() => {
                    fetch(`/api/faculty?search=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(data => {
                            displayAdviserResults(data);
                        })
                        .catch(error => {
                            console.error('Adviser search error:', error);
                        });
                }, 300);
            });

            document.addEventListener('click', function(e) {
                if (!adviserSearchInput.contains(e.target) && !adviserResultsDiv.contains(e.target)) {
                    adviserResultsDiv.classList.add('hidden');
                }
            });
        }

        function displayAdviserResults(faculty) {
            if (faculty.length === 0) {
                adviserResultsDiv.innerHTML = '<div class="p-4 text-gray-500 text-sm text-center">No faculty found</div>';
                adviserResultsDiv.classList.remove('hidden');
                return;
            }
            
            adviserResultsDiv.innerHTML = faculty.map(f => `
                <div class="p-4 hover:bg-gray-50 cursor-pointer border-b border-gray-100 last:border-b-0 transition-colors" 
                     onclick="selectAdviser(${f.id}, '${f.name.replace(/'/g, "\\'")}', '${f.email.replace(/'/g, "\\'")}')">
                    <div class="font-medium text-[#26225C]">${f.name}</div>
                    <div class="text-sm text-gray-600 mt-1">${f.email}</div>
                    ${f.department ? `<div class="text-xs text-[#FFC72C] mt-1 font-medium">${f.department}</div>` : ''}
                </div>
            `).join('');
            
            adviserResultsDiv.classList.remove('hidden');
        }

        function selectAdviser(id, name, email) {
            adviserIdInput.value = id;
            document.getElementById('adviser_name').textContent = name;
            document.getElementById('adviser_email').textContent = email;
            adviserSearchInput.value = '';
            adviserResultsDiv.classList.add('hidden');
            adviserSelectedDiv.classList.remove('hidden');
        }

        function clearAdviser() {
            adviserIdInput.value = '';
            adviserSearchInput.value = '';
            adviserSelectedDiv.classList.add('hidden');
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
                    // Save citations after successful research submission
                    saveCitations(data.research_id, 'dissertation');
                    
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

        function saveCitations(researchId, researchType) {
            const citationElements = document.querySelectorAll('[id^="citation-"]');
            const title = document.getElementById('title').value;
            
            citationElements.forEach(element => {
                const citationId = element.id.split('-')[1];
                const researchIdField = document.getElementById(`selected-research-${citationId}`);
                const researchTypeField = document.getElementById(`selected-type-${citationId}`);
                const contextField = element.querySelector('textarea');
                
                if (researchIdField && researchIdField.value) {
                    const citationData = {
                        citing_research_title: title,
                        citing_research_type: researchType,
                        cited_research_id: researchIdField.value,
                        cited_research_type: researchTypeField.value,
                        citation_context: contextField ? contextField.value : ''
                    };
                    
                    fetch('/citations', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(citationData)
                    }).catch(error => {
                        console.error('Citation save error:', error);
                    });
                }
            });
        }
    </script>
</x-app-layout>
