<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-[#26225C]">{{ $title ?? 'Abstract PDF' }}</h1>
                        @if(isset($subtitle))
                            <p class="text-sm text-gray-600 mt-1">{{ $subtitle }}</p>
                        @endif
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ $backUrl ?? url()->previous() }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back
                        </a>
                        @if(isset($downloadUrl))
                            <a href="{{ $downloadUrl }}" 
                               class="inline-flex items-center px-4 py-2 bg-[#26225C] hover:bg-[#3a3770] text-white font-medium rounded-lg transition-colors">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Download
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- PDF Viewer Container -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden relative">
                <div class="w-full" style="height: calc(100vh - 200px); min-height: 600px; position: relative;">
                    <iframe 
                        src="{{ $pdfUrl }}#toolbar=1&navpanes=1&scrollbar=1" 
                        class="w-full h-full border-0 {{ isset($blurred) && $blurred ? 'blur-sm' : '' }}"
                        style="min-height: 600px; {{ isset($blurred) && $blurred ? 'filter: blur(8px); pointer-events: none;' : '' }}"
                        title="PDF Viewer"
                        allowfullscreen>
                    </iframe>
                    
                    @if(isset($blurred) && $blurred)
                        <!-- Login Overlay -->
                        <div class="absolute inset-0 flex items-center justify-center bg-white/80 backdrop-blur-sm z-10">
                            <div class="bg-white rounded-xl shadow-2xl p-8 max-w-md mx-4 text-center border-2 border-[#FFC72C]">
                                <div class="mb-6">
                                    <svg class="h-16 w-16 mx-auto text-[#26225C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-[#26225C] mb-3">Login Required</h3>
                                <p class="text-gray-600 mb-6">Please login to view the {{ str_contains($title ?? '', 'Abstract') ? 'abstract PDF' : 'full document' }}. You can view the abstract text on the research detail page without logging in.</p>
                                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-3 bg-[#26225C] hover:bg-[#3a3770] text-white font-semibold rounded-lg transition-colors">
                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                        </svg>
                                        Login
                                    </a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-3 bg-[#FFC72C] hover:bg-[#e6b326] text-[#26225C] font-semibold rounded-lg transition-colors">
                                            Register
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Ensure PDF viewer container is scrollable */
        html, body {
            height: 100%;
            overflow: auto;
        }
        
        /* Custom scrollbar styling for better UX */
        iframe {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 #f7fafc;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .max-w-7xl {
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }
        }
    </style>
</x-app-layout>

