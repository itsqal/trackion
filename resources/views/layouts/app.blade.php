<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite('resources/css/app.css')

        <!-- Alpine Plugins -->
        <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>
        
        <link rel="icon" href="{{ asset('favlogo.ico')}}" type="image/x-icon">

        <title>{{ $title ?? config('app.name') }}</title>
    </head>
    <body class="flex bg-gray-100">

        {{-- sidebar component --}} 
        <livewire:sidebar />
    
        <div class="flex flex-col w-full">
            {{-- top navbar component --}}
            <livewire:navbar />

            {{-- main content --}}
            <div>  
                {{ $slot }}
            </div>
        </div>
    
    </body>
</html>
