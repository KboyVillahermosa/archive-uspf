<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Thesis Details
                </h2>
                <p class="text-sm text-gray-600 mt-1">{{ $thesis->department }} • {{ $thesis->year_completed }}</p>
            </div>
            <div class="flex space-x-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Master's Thesis
                </span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    Approved
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Title & Basic Info -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $thesis->title }}</h1>
                            
                            <div class="flex flex-wrap items-center gap-4 mb-6">
                                <div class="flex items-center text-gray-600">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00
                                    </svg>
                                    <span class="font-medium">Author:</span>
                                    <span class="ml-2">{{ $thesis->author }}</span>
                                </div>
                                
                                <div class="flex items-center text-gray-600">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>Completed {{ $thesis->year_completed }}</span>
                                </div>
                            </div>

                            <!-- Department & Keywords -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h3 class="font-medium text-gray-700 mb-1">Department</h3>
                                    <p class="text-gray-900">{{ $thesis->department }}</p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h3 class="font-medium text-gray-700 mb-1">Academic Level</h3>
                                    <p class="text-gray-900">Master's Degree</p>
                                </div>
                            </div>

                            <!-- Abstract -->
                            <div class="mb-6">
                                <h3 class="text-xl font-semibold text-gray-900 mb-3">Abstract</h3>
                                <div class="prose max-w-none text-gray-700 leading-relaxed">
                                    {{ $thesis->abstract }}
                                </div>
                            </div>

                            <!-- Keywords -->
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-3">Keywords</h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach(explode(',', $thesis->keywords) as $keyword)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            {{ trim($keyword) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Citation -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">How to Cite</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-700 font-mono">
                                    {{ $thesis->author }} ({{ $thesis->year_completed }}). <em>{{ $thesis->title }}</em> (Master's thesis). 
                                    {{ $thesis->department }}, University of Southern Philippines Foundation. 
                                    Retrieved from {{ url()->current() }}
                                </p>
                                <button onclick="copyToClipboard()" class="mt-2 text-sm text-green-600 hover:text-green-800">
                                    Copy Citation
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Quick Actions -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Document Access</h3>
                            <div class="space-y-3">
                                @if($thesis->document_file)
                                    <a href="{{ route('thesis.download', $thesis->id) }}" 
                                       class="flex items-center justify-center w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Download Thesis
                                    </a>
                                @endif
                                
                                <button onclick="shareResearch()" class="flex items-center justify-center w-full px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition duration-200">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                                    </svg>
                                    Share Thesis
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Document Information -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Document Info</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Type</span>
                                    <span class="font-semibold text-gray-900">Master's Thesis</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Year Completed</span>
                                    <span class="font-semibold text-gray-900">{{ $thesis->year_completed }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Department</span>
                                    <span class="font-semibold text-gray-900 text-right text-sm">{{ $thesis->department }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Published</span>
                                    <span class="font-semibold text-gray-900">{{ $thesis->approved_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Author Information -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Author</h3>
                            <div class="flex items-center">
                                <div class="h-12 w-12 bg-green-100 rounded-full flex items-center justify-center">
                                    <span class="text-green-600 font-medium text-lg">
                                        {{ substr($thesis->author, 0, 2) }}
                                    </span>
                                </div>
                                <div class="ml-3">
                                    <p class="font-medium text-gray-900">{{ $thesis->author }}</p>
                                    <p class="text-sm text-gray-600">Master's Graduate</p>
                                    <p class="text-sm text-gray-600">{{ $thesis->department }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Back to Dashboard -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <a href="{{ route('dashboard') }}" 
                               class="flex items-center justify-center w-full px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition duration-200">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Back to Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard() {
            const citation = document.querySelector('.font-mono').textContent;
            navigator.clipboard.writeText(citation).then(() => {
                alert('Citation copied to clipboard!');
            });
        }

        function shareResearch() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $thesis->title }}',
                    text: 'Check out this thesis: {{ $thesis->title }}',
                    url: window.location.href
                });
            } else {
                navigator.clipboard.writeText(window.location.href).then(() => {
                    alert('Thesis link copied to clipboard!');
                });
            }
        }
    </script>
</x-app-layout>
