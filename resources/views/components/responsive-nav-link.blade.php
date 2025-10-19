@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-yellow-400 text-start text-base font-medium text-yellow-300 bg-yellow-50 bg-opacity-10 focus:outline-none focus:text-yellow-200 focus:bg-yellow-50 focus:bg-opacity-20 focus:border-yellow-500 transition duration-200 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-white hover:text-yellow-300 hover:bg-yellow-50 hover:bg-opacity-10 hover:border-yellow-300 focus:outline-none focus:text-yellow-300 focus:bg-yellow-50 focus:bg-opacity-10 focus:border-yellow-300 transition duration-200 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
