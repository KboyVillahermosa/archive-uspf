<div class="relative p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="modal-title text-xl font-semibold text-[#26225C]">Approve Research</h2>
        <button type="button" class="modal-close w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-md hover:bg-gray-100 transition-all duration-200 hover:scale-110">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <div class="message-container my-4 text-red-500 text-sm text-center"></div>

    <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
        <h3 class="font-semibold text-[#26225C] mb-2">{{ $research->title }}</h3>
        <div class="text-sm text-gray-600 space-y-1">
            @if($type === 'student')
                <p><strong>Authors:</strong> {{ $research->authors }}</p>
                <p><strong>Department:</strong> {{ $research->department }}</p>
                @if($research->program)
                    <p><strong>Program:</strong> {{ $research->program }}</p>
                @endif
            @elseif($type === 'faculty')
                <p><strong>Researcher:</strong> {{ $research->user->name ?? 'N/A' }}</p>
                <p><strong>Department:</strong> {{ $research->department }}</p>
                @if($research->co_researchers)
                    <p><strong>Co-Researchers:</strong> {{ $research->co_researchers }}</p>
                @endif
            @else
                <p><strong>Author:</strong> {{ $research->author ?? 'N/A' }}</p>
                <p><strong>Department:</strong> {{ $research->department }}</p>
                @if(isset($research->year_completed))
                    <p><strong>Year:</strong> {{ $research->year_completed }}</p>
                @endif
            @endif
            <p><strong>Submitted:</strong> {{ $research->created_at->format('M j, Y g:i A') }}</p>
        </div>
    </div>

    <form method="POST" action="{{ $approveRoute }}" class="modal-form" data-callback="" data-confirm="no">
        @csrf
        <div class="mb-4">
            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Admin Notes (Optional)</label>
            <textarea name="notes" id="notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#26225C]" placeholder="Add any notes about this approval...">{{ old('notes', 'Approved by admin') }}</textarea>
        </div>
        <div class="flex items-center justify-center gap-3 mt-6">
            <button type="button" class="modal-close px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded transition-all">
                Cancel
            </button>
            <button type="submit" class="btn-submit px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Approve
            </button>
            <a href="{{ $rejectRoute }}" class="mp-form px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition-all" data-target="actionModal">
                Reject Instead
            </a>
        </div>
    </form>
</div>

