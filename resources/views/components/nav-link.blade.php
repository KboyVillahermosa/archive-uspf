@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-[#FFC72C] text-sm font-bold leading-5 text-white focus:outline-none focus:border-[#FFC72C] transition duration-300 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-semibold leading-5 text-white/70 hover:text-white hover:border-[#FFC72C]/50 focus:outline-none focus:text-white focus:border-[#FFC72C] transition duration-300 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
