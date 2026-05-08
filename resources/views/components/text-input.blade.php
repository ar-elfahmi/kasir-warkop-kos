@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-light-border bg-very-light-gray focus:border-slate-btn focus:ring-slate-btn rounded-6 shadow-l1 w-full h-12 px-3.5 py-3 text-deep-charcoal text-base']) }}>
