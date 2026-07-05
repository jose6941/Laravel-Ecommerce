@props(['size' => 'default'])

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-2 select-none']) }}>
    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-violet-600 text-white shadow-sm">
        <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12l-1 13.2a1.8 1.8 0 0 1-1.8 1.6H8.8A1.8 1.8 0 0 1 7 20.2L6 7Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 7V6a3 3 0 0 1 6 0v1" />
        </svg>
    </span>
    <span class="font-display text-xl font-semibold tracking-tight text-gray-900 leading-none">
        Acme<span class="text-violet-600">Store</span>
    </span>
</span>
