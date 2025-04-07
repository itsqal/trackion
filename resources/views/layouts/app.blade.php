<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite('resources/css/app.css')

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
