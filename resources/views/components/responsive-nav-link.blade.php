@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-green-500 text-start text-base font-medium text-green-200 bg-blue-950 focus:outline-none focus:text-white focus:bg-blue-900 focus:border-blue-700 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-blue-200 hover:text-white hover:bg-blue-950 hover:border-blue-700 focus:outline-none focus:text-white focus:bg-blue-950 focus:border-blue-700 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
