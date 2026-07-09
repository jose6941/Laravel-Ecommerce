@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-[11px] font-bold text-gray-500 tracking-[0.12em] uppercase mb-2']) }}>
    {{ $value ?? $slot }}
</label>
