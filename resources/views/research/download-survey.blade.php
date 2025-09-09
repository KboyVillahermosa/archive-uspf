<div class="p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Download Purpose Survey</h3>
        <button type="button" class="modal-close text-gray-400 hover:text-gray-600">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <div class="mb-4">
        <p class="text-sm text-gray-600 mb-2">You are about to download:</p>
        <p class="font-medium text-gray-900">{{ $research->title ?? $thesis->title ?? $dissertation->title }}</p>
    </div>

    @php
        $researchType = '';
        $researchId = '';
        if(isset($research)) {
            if(class_basename($research) === 'StudentResearch') {
                $researchType = 'student';
                $researchId = $research->id;
            } elseif(class_basename($research) === 'FacultyResearch') {
                $researchType = 'faculty';
                $researchId = $research->id;
            }
        } elseif(isset($thesis)) {
            $researchType = 'thesis';
            $researchId = $thesis->id;
        } elseif(isset($dissertation)) {
            $researchType = 'dissertation';
            $researchId = $dissertation->id;
        }
    @endphp

    {{-- Debug information --}}
    @if(config('app.debug'))
        <div class="mb-4 p-2 bg-yellow-100 rounded">
            <p class="text-xs">Debug: Type: {{ $researchType }}, ID: {{ $researchId }}</p>
            <p class="text-xs">Route: {{ route($researchType . '.download', $researchId) }}</p>
        </div>
    @endif

    <form class="modal-form" 
          action="{{ route($researchType . '.download', $researchId) }}" 
          method="POST"
          onsubmit="handleFormSubmit(event)">
        @csrf
        
        <div class="space-y-4">
            <div>
                <label for="purpose" class="block text-sm font-medium text-gray-700 mb-2">
                    What is your purpose for downloading this document? <span class="text-red-500">*</span>
                </label>
                <select name="purpose" id="purpose" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Select a purpose...</option>
                    <option value="Academic Research">Academic Research</option>
                    <option value="Literature Review">Literature Review</option>
                    <option value="Educational Purpose">Educational Purpose</option>
                    <option value="Professional Reference">Professional Reference</option>
                    <option value="Personal Interest">Personal Interest</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                    Additional notes (optional)
                </label>
                <textarea name="notes" id="notes" rows="3" 
                          placeholder="Please provide any additional context about your usage..."
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                <p class="text-xs text-gray-500 mt-1">This information helps us understand how our research is being used.</p>
            </div>
        </div>

        <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-200">
            <button type="button" class="modal-close px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Cancel
            </button>
            <button type="submit" id="download-btn" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <span class="btn-text">Continue Download</span>
                <span class="btn-loading hidden">Processing...</span>
            </button>
        </div>
    </form>
</div>

<script>
function handleFormSubmit(event) {
    const btn = document.getElementById('download-btn');
    const btnText = btn.querySelector('.btn-text');
    const btnLoading = btn.querySelector('.btn-loading');
    
    // Show loading state
    btnText.classList.add('hidden');
    btnLoading.classList.remove('hidden');
    btn.disabled = true;
    
    // Log form data for debugging
    const formData = new FormData(event.target);
    console.log('Form submission data:', Object.fromEntries(formData));
    
    // Reset button state after 5 seconds in case of issues
    setTimeout(() => {
        btnText.classList.remove('hidden');
        btnLoading.classList.add('hidden');
        btn.disabled = false;
    }, 5000);
}
</script>
