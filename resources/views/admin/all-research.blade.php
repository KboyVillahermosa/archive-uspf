<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            <!-- Header -->
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-light text-[#26225C] mb-2">All Research</h1>
                    <p class="text-gray-600">View and manage all research submissions</p>
                </div>
                <a href="{{ route('admin.research.filter-form', ['status' => $statusFilter, 'type' => $typeFilter]) }}" class="mp-form flex items-center gap-2 px-6 py-3 bg-[#26225C] hover:bg-[#3a3770] text-white font-semibold rounded-xl transition-all shadow-md hover:shadow-lg" data-target="filterModal">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Search & Filter
                </a>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="rounded-2xl shadow-lg bg-gradient-to-r from-[#26225C] to-[#3a3770] text-white relative overflow-hidden">
                    <div class="p-5">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="text-xs uppercase tracking-widest text-white/70 mb-1">Total</div>
                                <div class="text-sm text-white/80 uppercase tracking-[0.15em] mb-2">Research Items</div>
                                <div class="text-3xl font-semibold mt-2">{{ $totalCount }}</div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="inline-block w-3 h-3 rounded-full bg-[#FFC72C]"></span>
                                <span class="inline-block w-3 h-3 rounded-full bg-[#FFC72C]/50"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl shadow-lg bg-gradient-to-r from-yellow-500 to-yellow-600 text-white relative overflow-hidden">
                    <div class="p-5">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="text-xs uppercase tracking-widest text-white/70 mb-1">Pending</div>
                                <div class="text-sm text-white/80 uppercase tracking-[0.15em] mb-2">Review Required</div>
                                <div class="text-3xl font-semibold mt-2">{{ $pendingCount }}</div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="inline-block w-3 h-3 rounded-full bg-white/30"></span>
                                <span class="inline-block w-3 h-3 rounded-full bg-white/20"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl shadow-lg bg-gradient-to-r from-green-600 to-green-800 text-white relative overflow-hidden">
                    <div class="p-5">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="text-xs uppercase tracking-widest text-white/70 mb-1">Approved</div>
                                <div class="text-sm text-white/80 uppercase tracking-[0.15em] mb-2">Published</div>
                                <div class="text-3xl font-semibold mt-2">{{ $approvedCount }}</div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="inline-block w-3 h-3 rounded-full bg-white/30"></span>
                                <span class="inline-block w-3 h-3 rounded-full bg-white/20"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl shadow-lg bg-gradient-to-r from-red-600 to-red-800 text-white relative overflow-hidden">
                    <div class="p-5">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="text-xs uppercase tracking-widest text-white/70 mb-1">Rejected</div>
                                <div class="text-sm text-white/80 uppercase tracking-[0.15em] mb-2">Not Published</div>
                                <div class="text-3xl font-semibold mt-2">{{ $rejectedCount }}</div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="inline-block w-3 h-3 rounded-full bg-white/30"></span>
                                <span class="inline-block w-3 h-3 rounded-full bg-white/20"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Filters Display -->
            @if($statusFilter !== 'all' || $typeFilter !== 'all')
            <div class="mb-6 flex items-center gap-2 flex-wrap">
                <span class="text-sm text-gray-600 font-medium">Active filters:</span>
                @if($statusFilter !== 'all')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-[#26225C] bg-opacity-10 text-[#26225C] border border-[#FFC72C] border-opacity-30">
                    Status: {{ ucfirst($statusFilter) }}
                    <a href="{{ route('admin.research', ['type' => $typeFilter !== 'all' ? $typeFilter : 'all']) }}" class="ml-2 hover:text-red-600">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </a>
                </span>
                @endif
                @if($typeFilter !== 'all')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-[#26225C] bg-opacity-10 text-[#26225C] border border-[#FFC72C] border-opacity-30">
                    Type: {{ ucfirst($typeFilter) }}
                    <a href="{{ route('admin.research', ['status' => $statusFilter !== 'all' ? $statusFilter : 'all']) }}" class="ml-2 hover:text-red-600">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </a>
                </span>
                @endif
                <a href="{{ route('admin.research') }}" class="text-sm text-[#26225C] hover:text-[#FFC72C] font-medium underline">
                    Clear all
                </a>
            </div>
            @endif

            <!-- Research List -->
            <div id="all-research-container" class="table-container overflow-x-auto">
                @if($allResearch->count() > 0)
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-[#26225C] to-[#3a3770] border-b border-[#FFC72C]">
                                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase">Type</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase">Title</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase">Author</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase">Department</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase">Date</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($allResearch as $item)
                                @php
                                    $research = $item->data;
                                    $type = $item->type;
                                    
                                    $routeName = match($type) {
                                        'student' => 'student.show',
                                        'faculty' => 'faculty.show',
                                        'thesis' => 'thesis.show',
                                        'dissertation' => 'dissertation.show',
                                        default => 'student.show',
                                    };
                                    
                                    $statusColors = [
                                        'pending' => 'text-yellow-700',
                                        'approved' => 'text-green-700',
                                        'rejected' => 'text-red-700',
                                    ];
                                    
                                    $typeColors = [
                                        'student' => 'text-[#26225C]',
                                        'faculty' => 'text-purple-700',
                                        'thesis' => 'text-green-700',
                                        'dissertation' => 'text-red-700',
                                    ];
                                    
                                    $author = match($type) {
                                        'student' => $research->authors ?? 'N/A',
                                        'faculty' => $research->user->name ?? 'N/A',
                                        'thesis' => $research->author ?? 'N/A',
                                        'dissertation' => $research->author ?? 'N/A',
                                        default => 'N/A',
                                    };
                                @endphp

                                <tr onclick="window.location.href='{{ route($routeName, $research->id) }}'" class="cursor-pointer hover:bg-[#FFC72C] hover:bg-opacity-5 transition-colors border-b border-gray-100 bg-white">
                                    <td class="px-4 py-3">
                                        <span class="text-xs {{ $typeColors[$type] ?? 'text-gray-700' }} font-semibold">{{ ucfirst($type) }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-xs text-[#26225C] font-medium">{{ Str::limit($research->title, 60) }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-xs text-gray-600">{{ Str::limit($author, 40) }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-xs text-gray-600">
                                            {{ $research->department ?? 'N/A' }}
                                            @if(isset($research->program) && $research->program)
                                                • {{ Str::limit($research->program, 20) }}
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-xs {{ $statusColors[$research->status] ?? 'text-gray-700' }} font-semibold">
                                            {{ ucfirst($research->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-xs text-gray-600">{{ $research->created_at->format('M j, Y') }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-16 bg-white rounded-xl">
                        <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-[#26225C] mb-2">No research found</h3>
                        <p class="text-sm text-gray-500">Try adjusting your filters to see more results</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Filter Modal -->
    <div id="filterModal" class="modal fixed inset-0 bg-black bg-opacity-50 hidden z-50 transition-opacity duration-300 ease-in-out" style="display: none;">
        <div class="flex justify-center pt-8 px-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full transform transition-all duration-300 ease-out modal-content-wrapper">
                <div class="modal-content">
                    <!-- Content will be loaded here via AJAX -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // Ensure modal displays properly with smooth transitions
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('filterModal');
            const wrapper = modal?.querySelector('.modal-content-wrapper');
            
            if (modal && wrapper) {
                // Watch for hidden class removal
                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                            if (!modal.classList.contains('hidden')) {
                                // Show modal with animation
                                modal.style.display = 'block';
                                setTimeout(() => {
                                    modal.style.opacity = '1';
                                    wrapper.style.opacity = '1';
                                    wrapper.style.transform = 'translateY(0)';
                                }, 10);
                            } else {
                                // Hide modal with animation
                                modal.style.opacity = '0';
                                wrapper.style.opacity = '0';
                                wrapper.style.transform = 'translateY(-20px)';
                                setTimeout(() => {
                                    modal.style.display = 'none';
                                }, 300);
                            }
                        }
                    });
                });
                observer.observe(modal, { attributes: true, attributeFilter: ['class'] });
                
                // Initialize hidden state
                wrapper.style.opacity = '0';
                wrapper.style.transform = 'translateY(-20px)';
                wrapper.style.transition = 'opacity 0.3s ease-out, transform 0.3s ease-out';
            }

            // Function to show table skeleton loader
            function showAllResearchSkeleton() {
                const container = document.getElementById('all-research-container');
                if (container) {
                    container.innerHTML = `
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gradient-to-r from-[#26225C] to-[#3a3770] border-b border-[#FFC72C]">
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase">Type</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase">Title</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase">Author</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase">Department</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase">Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${Array.from({length: 10}, () => `
                                    <tr class="skeleton-row">
                                        <td class="skeleton-cell">
                                            <div class="skeleton-badge skeleton"></div>
                                        </td>
                                        <td class="skeleton-cell">
                                            <div class="skeleton-text skeleton w-52"></div>
                                        </td>
                                        <td class="skeleton-cell">
                                            <div class="skeleton-text skeleton w-32"></div>
                                        </td>
                                        <td class="skeleton-cell">
                                            <div class="skeleton-text skeleton w-36"></div>
                                        </td>
                                        <td class="skeleton-cell">
                                            <div class="skeleton-badge skeleton"></div>
                                        </td>
                                        <td class="skeleton-cell">
                                            <div class="skeleton-text skeleton w-20"></div>
                                        </td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    `;
                }
            }

            // Function to load all research data (for future API implementation)
            async function loadAllResearchData() {
                try {
                    showAllResearchSkeleton();
                    
                    // Simulate API call delay
                    await new Promise(resolve => setTimeout(resolve, 1200));
                    
                    // In a real implementation:
                    // const response = await fetch('/api/admin/all-research');
                    // const data = await response.json();
                    
                    // For now, reload the page
                    location.reload();
                    
                } catch (error) {
                    console.error('Error loading research data:', error);
                }
            }

            // Add refresh functionality for testing skeleton
            window.loadAllResearchData = loadAllResearchData;
        });
    </script>

    <style>
        .table-container {
            background: white;
            border-radius: 0.75rem;
            overflow: hidden;
        }
        
        .table-container table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table-container thead th {
            font-weight: 600;
            text-align: left;
        }
        
        .table-container tbody tr {
            transition: background-color 0.2s;
        }
        
        .table-container tbody tr:hover {
            background-color: rgba(255, 199, 44, 0.05);
        }

        /* Skeleton loading styles */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: skeleton-loading 1.5s infinite;
        }

        @keyframes skeleton-loading {
            0% {
                background-position: 200% 0;
            }
            100% {
                background-position: -200% 0;
            }
        }

        .skeleton-row {
            @apply border-b border-gray-100 bg-white;
        }

        .skeleton-cell {
            @apply px-4 py-3;
        }

        .skeleton-text {
            @apply bg-gray-300 rounded h-3;
        }

        .skeleton-badge {
            @apply bg-gray-300 rounded h-4 w-16;
        }

        .loader {
            @apply skeleton;
        }
    </style>
</x-app-layout>
