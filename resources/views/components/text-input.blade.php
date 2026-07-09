@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-200 bg-gray-50 focus:border-[#1a1a1a] focus:ring-[#1a1a1a] rounded-xl shadow-sm disabled:bg-gray-50 disabled:text-gray-400 placeholder-gray-400 text-sm font-medium']) }}>
