<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center gap-2 px-6 py-3 bg-[#1a1a1a] text-white rounded-full font-bold text-xs tracking-wider uppercase hover:bg-gray-800 active:bg-gray-900 focus:outline-none transition-all duration-300 shadow-md hover:shadow-lg disabled:opacity-40 disabled:cursor-not-allowed']) }}>
    {{ $slot }}
</button>
