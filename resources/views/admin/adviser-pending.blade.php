<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="w-full max-w-full mx-auto px-2 sm:px-4 lg:px-6 py-8">
            <div class="mb-6 pb-4 border-b-2 border-[#FFC72C]">
                <h2 class="text-3xl font-bold text-[#26225C] mb-1">Adviser Approvals</h2>
                <p class="text-sm text-gray-600">Review and approve research where you are assigned as adviser</p>
            </div>

            @if($studentResearch->isEmpty() && $facultyResearch->isEmpty() && $thesis->isEmpty() && $dissertations->isEmpty())
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-12 text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No Pending Approvals</h3>
                    <p class="text-gray-600">You don't have any research pending your approval as an adviser.</p>
                </div>
            @else
                <!-- Student Research -->
                @if($studentResearch->isNotEmpty())
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 mb-6">
                    <div class="bg-gradient-to-r from-[#26225C] to-[#3a3770] text-white px-6 py-4 rounded-t-xl">
                        <h3 class="text-lg font-semibold">Student Research ({{ $studentResearch->count() }})</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($studentResearch as $research)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ $research->title }}</h4>
                                        <div class="text-sm text-gray-600 space-y-1">
                                            <p><span class="font-medium">Authors:</span> {{ $research->authors }}</p>
                                            <p><span class="font-medium">Submitted by:</span> {{ $research->user->name ?? $research->user->email }}</p>
                                            <p><span class="font-medium">Department:</span> {{ $research->department }}</p>
                                            <p><span class="font-medium">Program:</span> {{ $research->program }}</p>
                                            <p><span class="font-medium">Submitted:</span> {{ $research->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <div class="ml-4 flex flex-col gap-2">
                                        <form action="{{ route('admin.approve-as-adviser', ['type' => 'student', 'id' => $research->id]) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors text-sm font-medium">
                                                Approve as Adviser
                                            </button>
                                        </form>
                                        <a href="{{ route('student.show', $research->id) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors text-sm font-medium text-center">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Faculty Research -->
                @if($facultyResearch->isNotEmpty())
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 mb-6">
                    <div class="bg-gradient-to-r from-purple-600 to-purple-800 text-white px-6 py-4 rounded-t-xl">
                        <h3 class="text-lg font-semibold">Faculty Research ({{ $facultyResearch->count() }})</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($facultyResearch as $research)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ $research->title }}</h4>
                                        <div class="text-sm text-gray-600 space-y-1">
                                            <p><span class="font-medium">Co-researchers:</span> {{ $research->co_researchers ?? 'N/A' }}</p>
                                            <p><span class="font-medium">Submitted by:</span> {{ $research->user->name ?? $research->user->email }}</p>
                                            <p><span class="font-medium">Department:</span> {{ $research->department }}</p>
                                            <p><span class="font-medium">Submitted:</span> {{ $research->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <div class="ml-4 flex flex-col gap-2">
                                        <form action="{{ route('admin.approve-as-adviser', ['type' => 'faculty', 'id' => $research->id]) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors text-sm font-medium">
                                                Approve as Adviser
                                            </button>
                                        </form>
                                        <a href="{{ route('faculty.show', $research->id) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors text-sm font-medium text-center">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Thesis -->
                @if($thesis->isNotEmpty())
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 mb-6">
                    <div class="bg-gradient-to-r from-green-600 to-green-800 text-white px-6 py-4 rounded-t-xl">
                        <h3 class="text-lg font-semibold">Master's Thesis ({{ $thesis->count() }})</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($thesis as $research)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ $research->title }}</h4>
                                        <div class="text-sm text-gray-600 space-y-1">
                                            <p><span class="font-medium">Author:</span> {{ $research->author }}</p>
                                            <p><span class="font-medium">Submitted by:</span> {{ $research->user->name ?? $research->user->email }}</p>
                                            <p><span class="font-medium">Department:</span> {{ $research->department }}</p>
                                            <p><span class="font-medium">Program:</span> {{ $research->program }}</p>
                                            <p><span class="font-medium">Year Completed:</span> {{ $research->year_completed }}</p>
                                            <p><span class="font-medium">Submitted:</span> {{ $research->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <div class="ml-4 flex flex-col gap-2">
                                        <form action="{{ route('admin.approve-as-adviser', ['type' => 'thesis', 'id' => $research->id]) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors text-sm font-medium">
                                                Approve as Adviser
                                            </button>
                                        </form>
                                        <a href="{{ route('thesis.show', $research->id) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors text-sm font-medium text-center">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Dissertations -->
                @if($dissertations->isNotEmpty())
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 mb-6">
                    <div class="bg-gradient-to-r from-red-600 to-red-800 text-white px-6 py-4 rounded-t-xl">
                        <h3 class="text-lg font-semibold">Doctoral Dissertations ({{ $dissertations->count() }})</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($dissertations as $research)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ $research->title }}</h4>
                                        <div class="text-sm text-gray-600 space-y-1">
                                            <p><span class="font-medium">Author:</span> {{ $research->author }}</p>
                                            <p><span class="font-medium">Submitted by:</span> {{ $research->user->name ?? $research->user->email }}</p>
                                            <p><span class="font-medium">Department:</span> {{ $research->department }}</p>
                                            <p><span class="font-medium">Program:</span> {{ $research->program }}</p>
                                            <p><span class="font-medium">Year Completed:</span> {{ $research->year_completed }}</p>
                                            <p><span class="font-medium">Submitted:</span> {{ $research->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <div class="ml-4 flex flex-col gap-2">
                                        <form action="{{ route('admin.approve-as-adviser', ['type' => 'dissertation', 'id' => $research->id]) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors text-sm font-medium">
                                                Approve as Adviser
                                            </button>
                                        </form>
                                        <a href="{{ route('dissertation.show', $research->id) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors text-sm font-medium text-center">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>

