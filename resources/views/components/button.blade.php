@props(['style' => ''])

@php
    if ($style == 'white') {
        $colorStyle = 'bg-white text-[var(--color-primary)] hover:bg-[#E4E9EE]';
    } else if ($style == 'green') {
        $colorStyle = 'bg-[#2AD72D] text-white hover:bg-[#16BE18]';
    } else {
        $colorStyle = $style;
    }
@endphp

<button {{ $attributes->merge(['class' => 'flex items-center gap-2 px-4 py-2 rounded-md text-xs sm:text-sm font-sans font-medium transition cursor-pointer ' . $colorStyle]) }}>
    {{ $slot }}
</button>