<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-light text-[#26225C] mb-2">Downloads & Views</h1>
                <p class="text-gray-600">Analytics and insights for research downloads and views</p>
            </div>

            <!-- Most Viewed Research Section -->
            <div class="mb-8">
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-semibold text-[#26225C]">Most Viewed Research</h2>
                        <span class="text-sm text-gray-500">Top {{ $mostViewed->count() }} items</span>
                    </div>
                    
                    @if($mostViewed->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Research</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Views</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($mostViewed as $research)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ Str::limit($research->title ?? 'Untitled', 50) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                                    @if($research->research_type === 'student') bg-blue-100 text-blue-800
                                                    @elseif($research->research_type === 'faculty') bg-purple-100 text-purple-800
                                                    @elseif($research->research_type === 'thesis') bg-green-100 text-green-800
                                                    @else bg-orange-100 text-orange-800
                                                    @endif">
                                                    {{ ucfirst($research->research_type) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $research->department ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $research->user->name ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="text-sm font-semibold text-[#26225C]">{{ $research->view_count ?? 0 }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <a href="{{ route($research->research_type . '.show.public', $research->id) }}" 
                                                   class="text-[#26225C] hover:text-[#FFC72C] font-medium">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500">No view data available yet.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Most Downloaded Research Section -->
            <div class="mb-8">
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-semibold text-[#26225C]">Most Downloaded Research</h2>
                        <span class="text-sm text-gray-500">Top {{ $mostDownloaded->count() }} items</span>
                    </div>
                    
                    @if($mostDownloaded->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Research</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Downloads</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($mostDownloaded as $research)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ Str::limit($research->title ?? 'Untitled', 50) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                                    @if($research->research_type === 'student') bg-blue-100 text-blue-800
                                                    @elseif($research->research_type === 'faculty') bg-purple-100 text-purple-800
                                                    @elseif($research->research_type === 'thesis') bg-green-100 text-green-800
                                                    @else bg-orange-100 text-orange-800
                                                    @endif">
                                                    {{ ucfirst($research->research_type) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $research->department ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $research->user->name ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="text-sm font-semibold text-[#26225C]">{{ $research->download_count ?? 0 }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <a href="{{ route($research->research_type . '.show.public', $research->id) }}" 
                                                   class="text-[#26225C] hover:text-[#FFC72C] font-medium">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500">No download data available yet.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Downloads with Purpose Section -->
            <div class="mb-8">
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-semibold text-[#26225C]">Recent Downloads</h2>
                        <span class="text-sm text-gray-500">Last {{ $recentDownloads->count() }} downloads with purpose</span>
                    </div>
                    
                    @if($recentDownloads->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Research</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Download Purpose</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($recentDownloads as $research)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-medium text-gray-900">{{ Str::limit($research->title ?? 'Untitled', 40) }}</div>
                                                <div class="text-xs text-gray-500 mt-1">{{ $research->department ?? 'N/A' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                                    @if($research->research_type === 'student') bg-blue-100 text-blue-800
                                                    @elseif($research->research_type === 'faculty') bg-purple-100 text-purple-800
                                                    @elseif($research->research_type === 'thesis') bg-green-100 text-green-800
                                                    @else bg-orange-100 text-orange-800
                                                    @endif">
                                                    {{ ucfirst($research->research_type) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900">{{ $research->download_purpose ?? 'N/A' }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-500">{{ Str::limit($research->download_notes ?? 'No notes', 50) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $research->download_date ? $research->download_date->format('M d, Y H:i') : 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <a href="{{ route($research->research_type . '.show.public', $research->id) }}" 
                                                   class="text-[#26225C] hover:text-[#FFC72C] font-medium">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500">No recent downloads available yet.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Research Section -->
            <div class="mb-8">
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-semibold text-[#26225C]">Recent Research</h2>
                        <span class="text-sm text-gray-500">Last {{ $recentResearch->count() }} approved items</span>
                    </div>
                    
                    @if($recentResearch->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Research</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Views</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Downloads</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($recentResearch as $research)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-medium text-gray-900">{{ Str::limit($research->title ?? 'Untitled', 50) }}</div>
                                                <div class="text-xs text-gray-500 mt-1">
                                                    Approved: {{ $research->approved_at ? $research->approved_at->format('M d, Y') : 'N/A' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                                    @if($research->research_type === 'student') bg-blue-100 text-blue-800
                                                    @elseif($research->research_type === 'faculty') bg-purple-100 text-purple-800
                                                    @elseif($research->research_type === 'thesis') bg-green-100 text-green-800
                                                    @else bg-orange-100 text-orange-800
                                                    @endif">
                                                    {{ ucfirst($research->research_type) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $research->department ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="text-sm font-semibold text-[#26225C]">{{ $research->view_count ?? 0 }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="text-sm font-semibold text-[#26225C]">{{ $research->download_count ?? 0 }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <a href="{{ route($research->research_type . '.show.public', $research->id) }}" 
                                                   class="text-[#26225C] hover:text-[#FFC72C] font-medium">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500">No recent research available yet.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

