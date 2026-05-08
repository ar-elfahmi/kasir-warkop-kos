@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-slate-btn text-start text-base font-semibold text-deep-charcoal bg-very-light-gray focus:outline-none focus:text-deep-charcoal focus:bg-very-light-gray focus:border-slate-btn transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-medium-gray hover:text-deep-charcoal hover:bg-very-light-gray hover:border-light-border focus:outline-none focus:text-deep-charcoal focus:bg-very-light-gray focus:border-light-border transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
