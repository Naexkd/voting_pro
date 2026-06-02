@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-blue-700 bg-blue-950 text-white focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm']) }}>
