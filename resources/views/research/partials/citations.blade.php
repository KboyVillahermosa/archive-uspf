@php
    $year = $research->approved_at ? $research->approved_at->format('Y') : date('Y');
    $date = $research->approved_at ? $research->approved_at->format('d M. Y') : date('d M. Y');
    $author = $research->authors ?? $research->author ?? 'University Researcher';
@endphp

<!-- APA Format -->
<div id="citation-content-apa" class="citation-content">
    <p class="text-xs text-gray-700 font-mono leading-relaxed">
        {{ $author }} ({{ $year }}). <em>{{ $research->title }}</em>. 
        {{ $research->department }}, University of Southern Philippines Foundation. 
        Retrieved from {{ url()->current() }}
    </p>
</div>

<!-- MLA Format -->
<div id="citation-content-mla" class="citation-content hidden">
    <p class="text-xs text-gray-700 font-mono leading-relaxed">
        {{ $author }}. "{{ $research->title }}." <em>University of Southern Philippines Foundation</em>, 
        {{ $research->department }}, {{ $date }}, 
        {{ url()->current() }}.
    </p>
</div>

<!-- Chicago Format -->
<div id="citation-content-chicago" class="citation-content hidden">
    <p class="text-xs text-gray-700 font-mono leading-relaxed">
        {{ $author }}. "{{ $research->title }}." {{ $research->department }}, 
        University of Southern Philippines Foundation. {{ $year }}. 
        {{ url()->current() }}.
    </p>
</div>

<!-- Harvard Format -->
<div id="citation-content-harvard" class="citation-content hidden">
    <p class="text-xs text-gray-700 font-mono leading-relaxed">
        {{ $author }} {{ $year }}, <em>{{ $research->title }}</em>, University of Southern Philippines Foundation, 
        {{ $research->department }}, viewed {{ date('d M Y') }}, &lt;{{ url()->current() }}&gt;.
    </p>
</div>

<!-- IEEE Format -->
<div id="citation-content-ieee" class="citation-content hidden">
    <p class="text-xs text-gray-700 font-mono leading-relaxed">
        {{ $author }}, "{{ $research->title }}," University of Southern Philippines Foundation, 
        {{ $research->department }}, {{ $year }}. 
        [Online]. Available: {{ url()->current() }}
    </p>
</div>

<!-- Vancouver Format -->
<div id="citation-content-vancouver" class="citation-content hidden">
    <p class="text-xs text-gray-700 font-mono leading-relaxed">
        {{ $author }}. {{ $research->title }}. University of Southern Philippines Foundation; 
        {{ $year }}. 
        Available from: {{ url()->current() }}
    </p>
</div>
