<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    @vite('resources/css/app.css')
    <link rel="icon" href="{{ asset('favlogo.ico')}}" type="image/x-icon">
</head>
<body class="h-screen flex">
    <!-- Left Side: Image -->
    <div class="w-1/2 h-full bg-cover bg-center" style="background-image: url('{{ asset('images/login-register-cover.png') }}');"></div>
    
    <!-- Right Side: Form -->
    <div class="w-1/2 flex items-center justify-center p-10">
        {{ $slot }}
    </div>
</body>
</html>