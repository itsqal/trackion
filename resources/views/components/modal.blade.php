@props(['title', 'name'])

<div 
    x-data = "{ show: false, name: '{{ $name }}' }"
    x-on:open-modal.window = "show = ($event.detail.name === name)"
    x-on:close-modal.window = "show = false"
    x-on:keydown.escape.window = "show = false"
    x-show="show"
    x-transition.opacity
    class="fixed inset-0 z-50 flex items-center justify-center"
    style="display: none"
>
    {{-- Faded Background --}}
    <div 
        class="absolute inset-0 bg-black opacity-40 backdrop-blur-sm"
        x-on:click="show = false"
    ></div>

    {{-- Modal Box --}}
    <div 
        x-transition
        class="relative bg-white rounded-2xl shadow-lg w-full max-w-lg mx-4 p-6 z-10"
    >
        {{-- Modal Header --}}
        <header class="flex items-center justify-between mb-4">
            @if (isset($title))
                <h2 class="text-lg font-semibold text-gray-800">
                    {{ $title }}
                </h2>
            @endif
            <button 
                x-on:click="show = false" 
                class="text-gray-500 hover:text-red-500 transition hover:bg-gray-200 rounded px-2"
                aria-label="Close"
            >
                &times;
            </button>
        </header>

        {{-- Modal Body --}}
        <main class="text-gray-700">
            {{ $slot }}
        </main>
    </div>
</div>