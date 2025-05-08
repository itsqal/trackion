@props(['active' => false])

@php
    $classes = ($active ?? false)
                ? 'flex items-center gap-2 block w-full px-4 py-2 text-sm text-white bg-[var(--color-primary)] rounded-md transition duration-200'
                : 'flex items-center gap-2 block w-full px-4 py-2 text-sm text-[var(--color-unselected)] hover:text-white hover:bg-[var(--color-hover)] rounded-md transition duration-200';
@endphp

<li class="list-none">
    <a {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a
</li>