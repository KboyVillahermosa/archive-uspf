<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="w-full max-w-full mx-auto px-2 sm:px-4 lg:px-6 py-8">
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="rounded-2xl shadow-lg bg-gradient-to-r from-[#26225C] to-[#3a3770] text-white relative overflow-hidden">
                    <div class="p-5">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="text-xs uppercase tracking-widest text-white/70 mb-1">Pending</div>
                                <div class="text-sm text-white/80 uppercase tracking-[0.15em] mb-2">Student Research</div>
                                <div class="text-3xl font-semibold mt-2">{{ $pendingStudentResearch }}</div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="inline-block w-3 h-3 rounded-full bg-[#FFC72C]"></span>
                                <span class="inline-block w-3 h-3 rounded-full bg-[#FFC72C]/50"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl shadow-lg bg-gradient-to-r from-purple-600 to-purple-800 text-white relative overflow-hidden">
                    <div class="p-5">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="text-xs uppercase tracking-widest text-white/70 mb-1">Pending</div>
                                <div class="text-sm text-white/80 uppercase tracking-[0.15em] mb-2">Faculty Research</div>
                                <div class="text-3xl font-semibold mt-2">{{ $pendingFacultyResearch }}</div>
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
                                <div class="text-xs uppercase tracking-widest text-white/70 mb-1">Pending</div>
                                <div class="text-sm text-white/80 uppercase tracking-[0.15em] mb-2">Thesis</div>
                                <div class="text-3xl font-semibold mt-2">{{ $pendingThesis }}</div>
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
                                <div class="text-xs uppercase tracking-widest text-white/70 mb-1">Pending</div>
                                <div class="text-sm text-white/80 uppercase tracking-[0.15em] mb-2">Dissertations</div>
                                <div class="text-3xl font-semibold mt-2">{{ $pendingDissertations }}</div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="inline-block w-3 h-3 rounded-full bg-white/30"></span>
                                <span class="inline-block w-3 h-3 rounded-full bg-white/20"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @include('admin.partials.charts')

            @if(isset($isAdmin) && $isAdmin && isset($waitingForAdviserApproval) && $waitingForAdviserApproval > 0)
            <!-- Adviser Approval Reminder -->
            <div class="mt-8 mb-8">
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl shadow-lg border border-orange-400 p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-white mb-1">Research Waiting for Adviser Approval</h3>
                                <p class="text-sm text-white/90">
                                    <span class="font-bold text-xl">{{ $waitingForAdviserApproval }}</span> 
                                    {{ $waitingForAdviserApproval === 1 ? 'research item' : 'research items' }} 
                                    {{ $waitingForAdviserApproval === 1 ? 'is' : 'are' }} waiting for adviser approval. 
                                    Admins can still approve these, but adviser approval is recommended.
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('admin.pending-research') }}" class="px-4 py-2 bg-white text-orange-600 rounded-lg font-semibold hover:bg-orange-50 transition-colors">
                            View All
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="mt-8">
                <div class="mb-6 pb-4 border-b-2 border-[#FFC72C]">
                    <h2 class="text-3xl font-bold text-[#26225C] mb-1">Quick Actions</h2>
                    <p class="text-sm text-gray-600">Manage your research repository</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="{{ route('admin.pending-research') }}" class="group bg-gradient-to-br from-[#FFC72C] to-yellow-500 hover:from-yellow-500 hover:to-[#FFC72C] p-5 rounded-xl border border-yellow-300 transition-all duration-200 shadow-md hover:shadow-lg">
                            <div class="flex items-center">
                            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                                <div>
                                <h4 class="font-semibold text-white text-sm mb-1">Review Pending</h4>
                                <p class="text-xs text-white/90">{{ $pendingStudentResearch + $pendingFacultyResearch + $pendingThesis + $pendingDissertations }} items waiting</p>
                                </div>
                            </div>
                        </a>

                    <a href="{{ route('admin.users.index') }}" class="group bg-gradient-to-br from-[#26225C] to-[#3a3770] hover:from-[#3a3770] hover:to-[#26225C] p-5 rounded-xl border border-[#26225C]/30 transition-all duration-200 shadow-md hover:shadow-lg">
                            <div class="flex items-center">
                            <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0" />
                                </svg>
                            </div>
                                <div>
                                <h4 class="font-semibold text-white text-sm mb-1">Manage Users</h4>
                                <p class="text-xs text-white/80">List and import users via CSV</p>
                                </div>
                            </div>
                        </a>

                    <a href="{{ route('admin.research') }}" class="group bg-gradient-to-br from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 p-5 rounded-xl border border-blue-500/30 transition-all duration-200 shadow-md hover:shadow-lg">
                            <div class="flex items-center">
                            <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                                <div>
                                <h4 class="font-semibold text-white text-sm mb-1">View Reports</h4>
                                <p class="text-xs text-white/80">Research statistics and analytics</p>
                                </div>
                            </div>
                        </a>

                    <a href="{{ route('admin.research') }}" class="group bg-gradient-to-br from-gray-600 to-gray-800 hover:from-gray-700 hover:to-gray-900 p-5 rounded-xl border border-gray-500/30 transition-all duration-200 shadow-md hover:shadow-lg">
                            <div class="flex items-center">
                            <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                                </svg>
                            </div>
                                <div>
                                <h4 class="font-semibold text-white text-sm mb-1">System Settings</h4>
                                <p class="text-xs text-white/80">Configure system preferences</p>
                                </div>
                            </div>
                        </a>
                </div>
            </div>

            @if(isset($isAdmin) && $isAdmin && isset($studentActivity) && !empty($studentActivity['summary']))
            <!-- Student Activity Section -->
            <div class="mt-8">
                <div class="mb-6 pb-4 border-b-2 border-[#FFC72C]">
                    <h2 class="text-3xl font-bold text-[#26225C] mb-1">Student Research Activity</h2>
                    <p class="text-sm text-gray-600">View what research students are viewing and downloading</p>
                </div>

                <!-- Student Activity Summary -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 mb-6">
                    <div class="bg-gradient-to-r from-[#26225C] to-[#3a3770] text-white px-6 py-4 rounded-t-xl">
                        <h3 class="text-lg font-semibold">Most Active Students</h3>
                        <p class="text-sm text-white/80">Students with the most research views and downloads</p>
                    </div>
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Program</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Views</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Downloads</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Total Activity</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($studentActivity['summary'] as $student)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div class="flex flex-col">
                                                <div class="text-sm font-medium text-gray-900">{{ $student['user_name'] }}</div>
                                                <div class="text-xs text-gray-500">{{ $student['user_email'] }}</div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <span class="text-sm text-gray-900">{{ $student['department'] ?? '—' }}</span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <span class="text-sm text-gray-900">{{ $student['program'] ?? '—' }}</span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $student['views_count'] }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                {{ $student['downloads_count'] }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                {{ $student['views_count'] + $student['downloads_count'] }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm">
                                            <a href="{{ route('admin.users.show', $student['user_id']) }}" class="text-[#26225C] hover:text-[#FFC72C] font-medium">
                                                View Details →
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Recent Views and Downloads -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Recent Views -->
                    <div class="bg-white rounded-xl shadow-lg border border-gray-200">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white px-6 py-4 rounded-t-xl">
                            <h3 class="text-lg font-semibold">Recent Views</h3>
                            <p class="text-sm text-white/80">Latest research viewed by students</p>
                        </div>
                        <div class="p-6">
                            @if(!empty($studentActivity['recent_views']))
                            <div class="space-y-4 max-h-96 overflow-y-auto">
                                @foreach(array_slice($studentActivity['recent_views'], 0, 10) as $view)
                                <div class="border-l-4 border-blue-500 pl-4 py-2 hover:bg-blue-50 transition-colors rounded-r">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="text-sm font-medium text-gray-900 mb-1">
                                                {{ Str::limit($view['research_title'], 50) }}
                                            </div>
                                            <div class="text-xs text-gray-600 mb-1">
                                                <span class="font-medium">{{ $view['user_name'] }}</span>
                                                @if(!empty($view['department']) || !empty($view['program']))
                                                <span class="mx-1">•</span>
                                                @if(!empty($view['department']))
                                                <span>{{ $view['department'] }}</span>
                                                @endif
                                                @if(!empty($view['department']) && !empty($view['program']))
                                                <span class="mx-1">•</span>
                                                @endif
                                                @if(!empty($view['program']))
                                                <span>{{ $view['program'] }}</span>
                                                @endif
                                                @endif
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ ucfirst($view['research_type']) }} • {{ $view['viewed_at']->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-8 text-gray-500">
                                <p>No recent views by students</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Recent Downloads -->
                    <div class="bg-white rounded-xl shadow-lg border border-gray-200">
                        <div class="bg-gradient-to-r from-green-600 to-green-800 text-white px-6 py-4 rounded-t-xl">
                            <h3 class="text-lg font-semibold">Recent Downloads</h3>
                            <p class="text-sm text-white/80">Latest research downloaded by students</p>
                        </div>
                        <div class="p-6">
                            @if(!empty($studentActivity['recent_downloads']))
                            <div class="space-y-4 max-h-96 overflow-y-auto">
                                @foreach(array_slice($studentActivity['recent_downloads'], 0, 10) as $download)
                                <div class="border-l-4 border-green-500 pl-4 py-2 hover:bg-green-50 transition-colors rounded-r">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="text-sm font-medium text-gray-900 mb-1">
                                                {{ Str::limit($download['research_title'], 50) }}
                                            </div>
                                            <div class="text-xs text-gray-600 mb-1">
                                                <span class="font-medium">{{ $download['user_name'] }}</span>
                                                @if(!empty($download['department']) || !empty($download['program']))
                                                <span class="mx-1">•</span>
                                                @if(!empty($download['department']))
                                                <span>{{ $download['department'] }}</span>
                                                @endif
                                                @if(!empty($download['department']) && !empty($download['program']))
                                                <span class="mx-1">•</span>
                                                @endif
                                                @if(!empty($download['program']))
                                                <span>{{ $download['program'] }}</span>
                                                @endif
                                                @endif
                                            </div>
                                            @if($download['download_purpose'])
                                            <div class="text-xs text-gray-700 mt-1">
                                                <span class="font-medium">Purpose:</span> {{ $download['download_purpose'] }}
                                            </div>
                                            @endif
                                            @if($download['download_notes'])
                                            <div class="text-xs text-gray-600 mt-1">
                                                <span class="font-medium">Notes:</span> {{ Str::limit($download['download_notes'], 50) }}
                                            </div>
                                            @endif
                                            <div class="text-xs text-gray-500 mt-1">
                                                {{ ucfirst($download['research_type']) }} • {{ $download['downloaded_at']->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-8 text-gray-500">
                                <p>No recent downloads by students</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
