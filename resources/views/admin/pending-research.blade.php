<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pending Research Review') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Student Research -->
            @if($studentResearch->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-blue-800">Student Research ({{ $studentResearch->count() }})</h3>
                        <div class="space-y-4">
                            @foreach($studentResearch as $research)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h4 class="font-medium text-gray-900">{{ $research->title }}</h4>
                                            <p class="text-sm text-gray-600">By: {{ $research->authors }}</p>
                                            <p class="text-sm text-gray-600">Department: {{ $research->department }} | Program: {{ $research->program }}</p>
                                            <p class="text-sm text-gray-600">Submitted by: {{ $research->user->name }} ({{ $research->user->email }})</p>
                                            <p class="text-xs text-gray-500">{{ $research->created_at->format('M j, Y g:i A') }}</p>
                                        </div>
                                        <div class="flex space-x-2 ml-4">
                                            <form method="POST" action="{{ route('admin.approve.student', $research->id) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                                                    Approve
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.reject.student', $research->id) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-700"><strong>Abstract:</strong> {{ Str::limit($research->abstract, 200) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Faculty Research -->
            @if($facultyResearch->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-purple-800">Faculty Research ({{ $facultyResearch->count() }})</h3>
                        <div class="space-y-4">
                            @foreach($facultyResearch as $research)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h4 class="font-medium text-gray-900">{{ $research->title }}</h4>
                                            @if($research->co_researchers)
                                                <p class="text-sm text-gray-600">Co-Researchers: {{ $research->co_researchers }}</p>
                                            @endif
                                            <p class="text-sm text-gray-600">Department: {{ $research->department }}</p>
                                            <p class="text-sm text-gray-600">Submitted by: {{ $research->user->name }} ({{ $research->user->email }})</p>
                                            <p class="text-xs text-gray-500">{{ $research->created_at->format('M j, Y g:i A') }}</p>
                                        </div>
                                        <div class="flex space-x-2 ml-4">
                                            <form method="POST" action="{{ route('admin.approve.faculty', $research->id) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                                                    Approve
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.reject.faculty', $research->id) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-700"><strong>Abstract:</strong> {{ Str::limit($research->abstract, 200) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Thesis -->
            @if($thesis->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-green-800">Thesis ({{ $thesis->count() }})</h3>
                        <div class="space-y-4">
                            @foreach($thesis as $item)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h4 class="font-medium text-gray-900">{{ $item->title }}</h4>
                                            <p class="text-sm text-gray-600">Author: {{ $item->author }}</p>
                                            <p class="text-sm text-gray-600">Department: {{ $item->department }} | Year: {{ $item->year_completed }}</p>
                                            <p class="text-sm text-gray-600">Keywords: {{ $item->keywords }}</p>
                                            <p class="text-sm text-gray-600">Submitted by: {{ $item->user->name }} ({{ $item->user->email }})</p>
                                            <p class="text-xs text-gray-500">{{ $item->created_at->format('M j, Y g:i A') }}</p>
                                        </div>
                                        <div class="flex space-x-2 ml-4">
                                            <form method="POST" action="{{ route('admin.approve.thesis', $item->id) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                                                    Approve
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.reject.thesis', $item->id) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-700"><strong>Abstract:</strong> {{ Str::limit($item->abstract, 200) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Dissertations -->
            @if($dissertations->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 text-red-800">Dissertations ({{ $dissertations->count() }})</h3>
                        <div class="space-y-4">
                            @foreach($dissertations as $dissertation)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h4 class="font-medium text-gray-900">{{ $dissertation->title }}</h4>
                                            <p class="text-sm text-gray-600">Author: {{ $dissertation->author }}</p>
                                            <p class="text-sm text-gray-600">Department: {{ $dissertation->department }} | Year: {{ $dissertation->year_completed }}</p>
                                            <p class="text-sm text-gray-600">Keywords: {{ $dissertation->keywords }}</p>
                                            <p class="text-sm text-gray-600">Submitted by: {{ $dissertation->user->name }} ({{ $dissertation->user->email }})</p>
                                            <p class="text-xs text-gray-500">{{ $dissertation->created_at->format('M j, Y g:i A') }}</p>
                                        </div>
                                        <div class="flex space-x-2 ml-4">
                                            <form method="POST" action="{{ route('admin.approve.dissertation', $dissertation->id) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                                                    Approve
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.reject.dissertation', $dissertation->id) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-700"><strong>Abstract:</strong> {{ Str::limit($dissertation->abstract, 200) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            @if($studentResearch->count() == 0 && $facultyResearch->count() == 0 && $thesis->count() == 0 && $dissertations->count() == 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No pending research</h3>
                        <p class="mt-1 text-sm text-gray-500">All submissions have been reviewed.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
