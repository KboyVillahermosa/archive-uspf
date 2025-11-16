@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-[#FFC72C] text-sm font-medium leading-5 text-[#FFC72C] focus:outline-none focus:border-[#FFC72C] transition duration-200 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-white hover:text-[#FFC72C] hover:border-[#FFC72C] focus:outline-none focus:text-[#FFC72C] focus:border-[#FFC72C] transition duration-200 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
