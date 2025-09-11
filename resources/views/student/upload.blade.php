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
                    <form id="student-upload-form" method="POST" action="{{ route('student.store') }}" enctype="multipart/form-data" class="space-y-6">
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
                               <select name="program" id="program" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Program</option>
                                    <!-- CCS Programs -->
                                    <option value="BSIT" {{ old('program') == 'BSIT' ? 'selected' : '' }}>Bachelor of Science in Information Technology</option>
                                    <option value="BSCS" {{ old('program') == 'BSCS' ? 'selected' : '' }}>Bachelor of Science in Computer Science</option>
                                    
                                    <!-- CEA Programs -->
                                    <option value="BSA-Arch" {{ old('program') == 'BSA-Arch' ? 'selected' : '' }}>Bachelor of Science in Architecture</option>
                                    <option value="BSCE" {{ old('program') == 'BSCE' ? 'selected' : '' }}>Bachelor of Science in Civil Engineering</option>
                                    <option value="BSGE" {{ old('program') == 'BSGE' ? 'selected' : '' }}>Bachelor of Science in Geodetic Engineering</option>
                                    
                                    <!-- CHS Programs -->
                                    <option value="BSN" {{ old('program') == 'BSN' ? 'selected' : '' }}>Bachelor of Science in Nursing</option>
                                    <option value="BSP" {{ old('program') == 'BSP' ? 'selected' : '' }}>Bachelor of Science in Pharmacy</option>
                                    
                                    <!-- CSW Programs -->
                                    <option value="CSW" {{ old('program') == 'CSW' ? 'selected' : '' }}>College of Social Work</option>
                                    
                                    <!-- CTEAS Programs -->
                                    <option value="BEED" {{ old('program') == 'BEED' ? 'selected' : '' }}>Bachelor of Elementary Education</option>
                                    <option value="BSED-Secondary" {{ old('program') == 'BSED-Secondary' ? 'selected' : '' }}>Bachelor of Secondary Education</option>
                                    <option value="BA-ELS" {{ old('program') == 'BA-ELS' ? 'selected' : '' }}>Bachelor of Arts in English Language Studies</option>
                                    <option value="BA-LCS" {{ old('program') == 'BA-LCS' ? 'selected' : '' }}>Bachelor of Arts in Literature and Cultural Studies</option>
                                    <option value="BA-Music" {{ old('program') == 'BA-Music' ? 'selected' : '' }}>Bachelor of Arts in Music</option>
                                    <option value="BA-PoliSci" {{ old('program') == 'BA-PoliSci' ? 'selected' : '' }}>Bachelor of Arts in Political Science</option>
                                    
                                    <!-- SBA Programs -->
                                    <option value="BSTM" {{ old('program') == 'BSTM' ? 'selected' : '' }}>Bachelor of Science in Tourism Management</option>
                                    <option value="BSHM" {{ old('program') == 'BSHM' ? 'selected' : '' }}>Bachelor of Science in Hospitality Management</option>
                                    <option value="BSA-Acct" {{ old('program') == 'BSA-Acct' ? 'selected' : '' }}>Bachelor of Science in Accountancy</option>
                                    <option value="BSBA" {{ old('program') == 'BSBA' ? 'selected' : '' }}>Bachelor of Science in Business Administration</option>
                                    
                                    <!-- Graduate School Programs -->
                                    <option value="EdD" {{ old('program') == 'EdD' ? 'selected' : '' }}>Doctor of Education major in Educational Management</option>
                                    <option value="MSW" {{ old('program') == 'MSW' ? 'selected' : '' }}>Master of Science in Social Work</option>
                                    <option value="MBA" {{ old('program') == 'MBA' ? 'selected' : '' }}>Master of Business Administration</option>
                                    <option value="MAEd-EM" {{ old('program') == 'MAEd-EM' ? 'selected' : '' }}>Master of Arts in Education major in Educational Management</option>
                                    <option value="MAEd-CI" {{ old('program') == 'MAEd-CI' ? 'selected' : '' }}>Master of Arts in Education major in Curriculum and Instruction</option>
                                    <option value="MAEd-EE" {{ old('program') == 'MAEd-EE' ? 'selected' : '' }}>Master of Arts in Education major in Elementary Education</option>
                                    <option value="MAEd-ECE" {{ old('program') == 'MAEd-ECE' ? 'selected' : '' }}>Master of Arts in Education major in Early Childhood Education</option>
                                    <option value="MAEd-ME" {{ old('program') == 'MAEd-ME' ? 'selected' : '' }}>Master of Arts in Education major in Math Education</option>
                                    <option value="MAEd-SE" {{ old('program') == 'MAEd-SE' ? 'selected' : '' }}>Master of Arts in Education major in Science Education</option>
                                    <option value="MAEd-ELT" {{ old('program') == 'MAEd-ELT' ? 'selected' : '' }}>Master of Arts in Education major in English Language Teaching</option>
                                    <option value="MAEd-PE" {{ old('program') == 'MAEd-PE' ? 'selected' : '' }}>Master of Arts in Education major in Physical Education</option>
                                    <option value="MAEd-SpEd" {{ old('program') == 'MAEd-SpEd' ? 'selected' : '' }}>Master of Arts in Education major in Special Education</option>
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

                        <!-- Research Citations Section -->
                        <div class="space-y-4 border-t pt-6">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium text-gray-900">Research Citations (Optional)</h3>
                                <button type="button" id="add-citation-btn" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors text-sm">
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

        // Force AJAX form submission for student upload
        document.getElementById('student-upload-form').addEventListener('submit', function(e) {
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
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
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
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
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

        // Update form submission to handle citations
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Disable submit button and show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Submitting...
            `;
            
            // Create FormData and handle citations
            const formData = new FormData(form);
            
            // Submit the form
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Save citations after successful research submission
                    saveCitations(data.research_id, 'student');
                    
                    if (typeof window.showSuccessNotification === 'function') {
                        window.showSuccessNotification(
                            'Student research submitted successfully! It is now pending approval.',
                            '{{ route("research.history") }}'
                        );
                    } else {
                        alert('Student research submitted successfully! Redirecting to research history...');
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
