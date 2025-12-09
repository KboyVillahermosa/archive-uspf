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
        </div>
    </div>
</x-app-layout>
