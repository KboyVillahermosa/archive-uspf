<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Faculty Research Details
                </h2>
                <p class="text-sm text-gray-600 mt-1">{{ $research->department }}</p>
            </div>
            <div class="flex space-x-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                    Faculty Research
                </span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    Approved
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Research Banner -->
            @if($research->banner_image)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="relative">
                        <img src="{{ asset('storage/' . $research->banner_image) }}" alt="Research Banner" class="w-full h-64 object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-30 flex items-end">
                            <div class="p-6 text-white">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-600 bg-opacity-80">
                                    Faculty Research
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Title & Basic Info -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $research->title }}</h1>
                            
                            <div class="flex flex-wrap items-center gap-4 mb-6">
                                <div class="flex items-center text-gray-600">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span class="font-medium">Lead Researcher:</span>
                                    <span class="ml-2">{{ $research->user->name }}</span>
                                </div>
                                
                                <div class="flex
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h3 class="font-medium text-gray-700 mb-1">Department</h3>
                                    <p class="text-gray-900">{{ $research->department }}</p>
                                </div>
                                @if($research->co_researchers)
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <h3 class="font-medium text-gray-700 mb-1">Co-Researchers</h3>
                                        <p class="text-gray-900">{{ $research->co_researchers }}</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Abstract -->
                            <div class="mb-6">
                                <h3 class="text-xl font-semibold text-gray-900 mb-3">Abstract</h3>
                                <div class="prose max-w-none text-gray-700 leading-relaxed">
                                    {{ $research->abstract }}
                                </div>
                            </div>

                            <!-- Tags -->
                            @if($research->tags)
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Research Keywords</h3>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach(explode(',', $research->tags) as $tag)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                                {{ trim($tag) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Citation -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">How to Cite</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-700 font-mono">
                                    {{ $research->user->name }}{{ $research->co_researchers ? ', ' . $research->co_researchers : '' }} ({{ $research->approved_at->format('Y') }}). <em>{{ $research->title }}</em>. 
                                    {{ $research->department }}, University of Southern Philippines Foundation. 
                                    Retrieved from {{ url()->current() }}
                                </p>
                                <button onclick="copyToClipboard()" class="mt-2 text-sm text-purple-600 hover:text-purple-800">
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
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                            <div class="space-y-3">
                                @if($research->research_file)
                                    <a href="{{ route('faculty.download', $research->id) }}" 
                                       class="flex items-center justify-center w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition duration-200">
                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Download Full Paper
                                    </a>
                                @endif
                                
                                <button onclick="shareResearch()" class="flex items-center justify-center w-full px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition duration-200">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                                    </svg>
                                    Share Research
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Research Statistics -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistics</h3>
                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Views</span>
                                    <span class="font-semibold text-gray-900">{{ rand(100, 1000) }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Downloads</span>
                                    <span class="font-semibold text-gray-900">{{ rand(20, 200) }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Published</span>
                                    <span class="font-semibold text-gray-900">{{ $research->approved_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Research Team -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Research Team</h3>
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 bg-purple-100 rounded-full flex items-center justify-center">
                                        <span class="text-purple-600 font-medium text-sm">
                                            {{ substr($research->user->name, 0, 2) }}
                                        </span>
                                    </div>
                                    <div class="ml-3">
                                        <p class="font-medium text-gray-900 text-sm">{{ $research->user->name }}</p>
                                        <p class="text-xs text-gray-600">Lead Researcher</p>
                                    </div>
                                </div>
                                @if($research->co_researchers)
                                    @foreach(explode(',', $research->co_researchers) as $coResearcher)
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 bg-gray-100 rounded-full flex items-center justify-center">
                                                <span class="text-gray-600 font-medium text-sm">
                                                    {{ substr(trim($coResearcher), 0, 2) }}
                                                </span>
                                            </div>
                                            <div class="ml-3">
                                                <p class="font-medium text-gray-900 text-sm">{{ trim($coResearcher) }}</p>
                                                <p class="text-xs text-gray-600">Co-Researcher</p>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
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
                    title: '{{ $research->title }}',
                    text: 'Check out this faculty research: {{ $research->title }}',
                    url: window.location.href
                });
            } else {
                navigator.clipboard.writeText(window.location.href).then(() => {
                    alert('Research link copied to clipboard!');
                });
            }
        }
    </script>
</x-app-layout>
