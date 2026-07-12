@props(['src', 'alt' => '', 'class' => 'w-full h-full object-cover', 'wrapperClass' => ''])

<div x-data="{ loaded: false, error: false }" class="relative overflow-hidden w-full h-full {{ $wrapperClass }}">
    <!-- Skeleton shimmer placeholder -->
    <div x-show="!loaded"
         class="absolute inset-0 bg-gray-200 shimmer rounded-[inherit] z-10"
         style="background-size: 200% 100%;">
    </div>

    <!-- Image with native lazy loading + opacity fade-in on load -->
    <img src="{{ $src }}"
         alt="{{ $alt }}"
         loading="lazy"
         x-on:load="loaded = true"
         x-on:error="loaded = true; error = true"
         x-bind:class="loaded && !error ? 'opacity-100' : 'opacity-0'"
         class="transition-opacity duration-500 ease-out {{ $class }}"
         {{ $attributes }}>
</div>
