<div class="relative p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="modal-title text-xl font-semibold text-[#26225C]">Search & Filter</h2>
        <button type="button" class="modal-close w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-md hover:bg-gray-100 transition-all duration-200 hover:scale-110">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <div class="message-container my-4 text-red-500 text-sm text-center"></div>

    <form method="GET" action="{{ route('admin.research') }}" class="modal-form" data-callback="" data-confirm="no">
        <div class="space-y-4">
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#26225C]">
                    <option value="all" {{ $statusFilter === 'all' ? 'selected' : '' }}>All Status</option>
                    <option value="pending" {{ $statusFilter === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ $statusFilter === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ $statusFilter === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                <select name="type" id="type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#26225C]">
                    <option value="all" {{ $typeFilter === 'all' ? 'selected' : '' }}>All Types</option>
                    <option value="student" {{ $typeFilter === 'student' ? 'selected' : '' }}>Student Research</option>
                    <option value="faculty" {{ $typeFilter === 'faculty' ? 'selected' : '' }}>Faculty Research</option>
                    <option value="thesis" {{ $typeFilter === 'thesis' ? 'selected' : '' }}>Thesis</option>
                    <option value="dissertation" {{ $typeFilter === 'dissertation' ? 'selected' : '' }}>Dissertation</option>
                </select>
            </div>
        </div>
        <div class="flex items-center justify-center gap-3 mt-6">
            <button type="submit" class="btn-submit px-4 py-2 bg-[#26225C] text-white rounded hover:bg-[#3a3770]">
                Submit
            </button>
        </div>
    </form>
</div>

