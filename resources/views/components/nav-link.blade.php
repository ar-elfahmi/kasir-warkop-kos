@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-slate-btn text-sm font-semibold leading-5 text-deep-charcoal focus:outline-none focus:border-slate-btn transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-medium-gray hover:text-deep-charcoal hover:border-light-border focus:outline-none focus:text-deep-charcoal focus:border-light-border transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
