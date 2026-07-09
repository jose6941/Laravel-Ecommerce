<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center gap-2 px-6 py-3 bg-white border-2 border-gray-200 rounded-full font-semibold text-sm text-gray-600 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#1a1a1a]/20 focus:ring-offset-2 disabled:opacity-40 transition-all duration-200']) }}>
    {{ $slot }}
</button>
