<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            <!-- Header -->
            <div class="mb-10">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-[#26225C] to-[#3a3770] rounded-xl flex items-center justify-center">
                        <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                </svg>
                            </div>
                            <div>
                        <h1 class="text-4xl font-light text-[#26225C] mb-1">Submit Faculty Research</h1>
                        <p class="text-gray-600">Share your academic research and publications with the university community</p>
                    </div>
                    </div>
                </div>

            <form id="faculty-upload-form" method="POST" action="{{ route('faculty.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Main Form Content -->
                    <div class="lg:col-span-2 space-y-8">
                        <!-- Research Details Section -->
                        <div>
                            <div class="mb-6 pb-4 border-b border-[#FFC72C]">
                                <h2 class="text-2xl font-light text-[#26225C] mb-1">Research Information</h2>
                                <p class="text-sm text-gray-500">Provide essential details about your research</p>
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
                                value="{{ isset($editMode) && $editMode && isset($research) ? $research->title : old('title') }}">
                            @error('title') 
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Co-Researchers -->
                                <div>
                                    <label for="co_researchers" class="block text-sm font-semibold text-[#26225C] mb-2">
                                        Authors <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="co_researchers" id="co_researchers" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#26225C] focus:border-[#FFC72C] transition-all bg-white"
                                        placeholder="Dr. John Doe, Prof. Jane Smith, Dr. Alex Johnson"
                                value="{{ isset($editMode) && $editMode && isset($research) ? $research->co_researchers : old('co_researchers') }}">
                                    <p class="text-xs text-gray-500 mt-1.5">Separate multiple authors with commas</p>
                            @error('co_researchers') 
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Department -->
                                <div id="field-department">
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

                        <!-- Abstract -->
                                <div id="field-abstract">
                                    <label for="abstract" class="block text-sm font-semibold text-[#26225C] mb-2">
                                        Abstract <span class="text-red-500">*</span>
                            </label>
                                    <textarea name="abstract" id="abstract" rows="8" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#26225C] focus:border-[#FFC72C] transition-all resize-none bg-white"
                                placeholder="Provide a comprehensive summary of your faculty research (300-400 words recommended)">{{ isset($editMode) && $editMode && isset($research) ? $research->abstract : old('abstract') }}</textarea>
                                    <p class="text-xs text-gray-500 mt-1.5">Recommended: 300-400 words</p>
                            @error('abstract') 
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Keywords -->
                                <div>
                                    <label for="tags" class="block text-sm font-semibold text-[#26225C] mb-2">
                                        Keywords <span class="text-gray-400 text-xs font-normal">(Optional)</span>
                            </label>
                            <input type="text" name="tags" id="tags"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#26225C] focus:border-[#FFC72C] transition-all bg-white"
                                        placeholder="keyword1, keyword2, keyword3"
                                value="{{ isset($editMode) && $editMode && isset($research) ? $research->tags : old('tags') }}">
                                    <p class="text-xs text-gray-500 mt-1.5">Separate keywords with commas</p>
                                </div>
                            </div>
                        </div>

                        <!-- File Upload Section -->
                        <div>
                            <div class="mb-6 pb-4 border-b border-[#FFC72C]">
                                <h2 class="text-2xl font-light text-[#26225C] mb-1">Upload Files</h2>
                                <p class="text-sm text-gray-500">Upload your research documents and banner image</p>
                            </div>
                            
                            <div class="space-y-6">
                                <!-- Banner Image -->
                                <div>
                                    <label class="block text-sm font-semibold text-[#26225C] mb-2">
                                        Banner Image <span class="text-gray-400 text-xs font-normal">(Optional)</span>
                            </label>
                                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center bg-gray-50 hover:border-[#FFC72C] hover:bg-gray-100 transition-all cursor-pointer">
                                <input type="file" name="banner_image" id="banner_image" accept="image/*" class="hidden">
                                <label for="banner_image" class="cursor-pointer">
                                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                            <p class="text-sm text-gray-600 mb-1">
                                                <span class="font-medium text-[#26225C]">Click to upload</span> or drag and drop
                                    </p>
                                    <p class="text-xs text-gray-500">Recommended: 1200 x 400px (3:1 ratio)</p>
                                </label>
                            </div>
                        </div>

                        <!-- Research File Upload -->
                                <div id="field-research_file">
                                    <label class="block text-sm font-semibold text-[#26225C] mb-2">
                                        Research File <span class="text-red-500">*</span>
                            </label>
                                    <div class="border-2 border-dashed border-[#FFC72C] rounded-xl p-10 text-center bg-[#FFC72C] bg-opacity-5 hover:bg-opacity-10 transition-all cursor-pointer group">
                                <input type="file" name="research_file" id="research_file" accept=".pdf,.doc,.docx" required class="hidden">
                                <label for="research_file" class="cursor-pointer">
                                            <div class="w-20 h-20 bg-[#26225C] rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                                                <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                            </div>
                                            <p class="text-base text-[#26225C] font-semibold mb-1">
                                                Click to upload or drag and drop
                                        </p>
                                            <p class="text-sm text-gray-600">PDF, DOC, DOCX (Max 10MB)</p>
                                        </label>
                                    </div>
                                    @error('research_file') 
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
                                        <span class="text-sm text-gray-700 group-hover:text-[#26225C] transition-colors">Research title and authors</span>
                                    </button>
                                    <button type="button" onclick="scrollToField('department')" class="w-full flex items-center space-x-3 hover:bg-gray-50 p-2 rounded-lg transition-colors text-left group">
                                        <div class="w-6 h-6 rounded-full border-2 border-[#FFC72C] flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                            <div class="w-3 h-3 bg-[#FFC72C] rounded-full"></div>
                                        </div>
                                        <span class="text-sm text-gray-700 group-hover:text-[#26225C] transition-colors">Department selected</span>
                                    </button>
                                    <button type="button" onclick="scrollToField('abstract')" class="w-full flex items-center space-x-3 hover:bg-gray-50 p-2 rounded-lg transition-colors text-left group">
                                        <div class="w-6 h-6 rounded-full border-2 border-[#FFC72C] flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                            <div class="w-3 h-3 bg-[#FFC72C] rounded-full"></div>
                                        </div>
                                        <span class="text-sm text-gray-700 group-hover:text-[#26225C] transition-colors">Abstract (300-400 words)</span>
                                    </button>
                                    <button type="button" onclick="scrollToField('research_file')" class="w-full flex items-center space-x-3 hover:bg-gray-50 p-2 rounded-lg transition-colors text-left group">
                                        <div class="w-6 h-6 rounded-full border-2 border-[#FFC72C] flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                            <div class="w-3 h-3 bg-[#FFC72C] rounded-full"></div>
                                        </div>
                                        <span class="text-sm text-gray-700 group-hover:text-[#26225C] transition-colors">Research file (PDF/DOC)</span>
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
                                <p class="text-sm text-white text-opacity-90 mb-4">Make sure all required fields are filled and your research file is properly formatted.</p>
                                <p class="text-xs text-white text-opacity-75">Your submission will be reviewed by administrators before being published.</p>
                        </div>

                        <!-- Submit Button -->
                            <button type="submit" class="w-full bg-[#26225C] hover:bg-[#3a3770] text-white py-4 px-6 rounded-xl transition-all font-semibold flex items-center justify-center gap-2 text-base shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Submit Research
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

        // Word count for abstract
        document.getElementById('abstract').addEventListener('input', function(e) {
            const words = e.target.value.trim().split(/\s+/).filter(word => word.length > 0).length;
            const countElement = document.getElementById('abstract-count');
            if (countElement) {
                countElement.textContent = words + ' words';
            }
        });

        // File upload preview for research file
        document.getElementById('research_file').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const label = e.target.nextElementSibling.querySelector('div');
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
                    // Save citations after successful research submission
                    saveCitations(data.research_id, 'faculty');
                    
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
