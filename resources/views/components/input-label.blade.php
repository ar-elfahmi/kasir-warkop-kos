@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-slate-btn']) }}>
    {{ $value ?? $slot }}
</label>
