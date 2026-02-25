@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-3 border-l-4 border-[#FFC72C] text-start text-base font-bold text-[#FFC72C] bg-white/10 focus:outline-none transition duration-300 ease-in-out'
            : 'block w-full ps-3 pe-4 py-3 border-l-4 border-transparent text-start text-base font-semibold text-white/70 hover:text-white hover:bg-white/5 hover:border-[#FFC72C]/50 focus:outline-none transition duration-300 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
