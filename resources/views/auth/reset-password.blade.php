<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('favlogo.ico')}}" type="image/x-icon">
    <title>{{ config('app.name') }} - Reset Password</title>

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css'])
</head>

<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="w-full max-w-md px-6 py-4 mx-4 bg-white shadow-md rounded-xl">
            <div class="mb-6 text-center">
                <h2 class="text-2xl font-bold text-[#170F49]">Reset Password</h2>
                <p class="mt-2 text-sm text-[#170F49]">Masukan password baru anda</p>
            </div>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <!-- Hidden Token Field -->
                <input type="hidden" name="token" value="{{ $token }}">

                <label for="email" class="block text-xs sm:text-sm text-[#170F49] font-semibold">Email</label>
                <input type="email" value="{{ old('email') }}" placeholder="Masukan email anda" name="email"
                    class="mb-3 shadow w-full rounded-3xl border-[#EFF0F6] border-1 text-xs sm:text-sm placeholder:text-xs sm:placeholder:text-sm py-2 px-2"
                    required>

                <label for="password" class="block text-xs sm:text-sm text-[#170F49] font-semibold">Password</label>
                <div class="relative mb-3">
                    <input type="password" id="password" name="password" placeholder="Masukan password baru anda"
                        class="w-full shadow rounded-3xl border-[#EFF0F6] border-1 text-xs sm:text-sm placeholder:text-xs sm:placeholder:text-sm py-2 px-2 pr-10"
                        required>
                    <span class="absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer"
                        onclick="togglePassword('password')">
                        <svg id="eye-open-password" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                            <path fill-rule="evenodd"
                                d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                clip-rule="evenodd" />
                        </svg>

                        <svg id="eye-closed-password" xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 sm:h-5 sm:w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path
                                d="M3.53 2.47a.75.75 0 0 0-1.06 1.06l18 18a.75.75 0 1 0 1.06-1.06l-18-18ZM22.676 12.553a11.249 11.249 0 0 1-2.631 4.31l-3.099-3.099a5.25 5.25 0 0 0-6.71-6.71L7.759 4.577a11.217 11.217 0 0 1 4.242-.827c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113Z" />
                            <path
                                d="M15.75 12c0 .18-.013.357-.037.53l-4.244-4.243A3.75 3.75 0 0 1 15.75 12ZM12.53 15.713l-4.243-4.244a3.75 3.75 0 0 0 4.244 4.243Z" />
                            <path
                                d="M6.75 12c0-.619.107-1.213.304-1.764l-3.1-3.1a11.25 11.25 0 0 0-2.63 4.31c-.12.362-.12.752 0 1.114 1.489 4.467 5.704 7.69 10.675 7.69 1.5 0 2.933-.294 4.242-.827l-2.477-2.477A5.25 5.25 0 0 1 6.75 12Z" />
                        </svg>
                    </span>
                </div>

                <label for="password_confirmation" class="block text-xs sm:text-sm text-[#170F49] font-semibold">Konfirmasi
                    password</label>
                <div class="relative">
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        placeholder="Masukan ulang password anda"
                        class="w-full shadow rounded-3xl border-[#EFF0F6] border-1 text-xs sm:text-sm placeholder:text-xs sm:placeholder:text-sm py-2 px-2 pr-10"
                        required>
                    <span class="absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer"
                        onclick="togglePassword('password_confirmation')">
                        <svg id="eye-open-password_confirmation" xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                            <path fill-rule="evenodd"
                                d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                clip-rule="evenodd" />
                        </svg>

                        <svg id="eye-closed-password_confirmation" xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 sm:h-5 sm:w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path
                                d="M3.53 2.47a.75.75 0 0 0-1.06 1.06l18 18a.75.75 0 1 0 1.06-1.06l-18-18ZM22.676 12.553a11.249 11.249 0 0 1-2.631 4.31l-3.099-3.099a5.25 5.25 0 0 0-6.71-6.71L7.759 4.577a11.217 11.217 0 0 1 4.242-.827c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113Z" />
                            <path
                                d="M15.75 12c0 .18-.013.357-.037.53l-4.244-4.243A3.75 3.75 0 0 1 15.75 12ZM12.53 15.713l-4.243-4.244a3.75 3.75 0 0 0 4.244 4.243Z" />
                            <path
                                d="M6.75 12c0-.619.107-1.213.304-1.764l-3.1-3.1a11.25 11.25 0 0 0-2.63 4.31c-.12.362-.12.752 0 1.114 1.489 4.467 5.704 7.69 10.675 7.69 1.5 0 2.933-.294 4.242-.827l-2.477-2.477A5.25 5.25 0 0 1 6.75 12Z" />
                        </svg>
                    </span>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="mt-3 w-full text-sm sm:text-base bg-[var(--color-primary)] text-white font-semibold py-2 rounded-3xl">
                    Simpan
                </button>

                @if ($errors->has('email'))
                <p class="mt-3 text-xs text-center text-red-600 my-2 font-medium">
                    {{ $errors->first('email') }}
                </p>
                @endif

                @if ($errors->has('password'))
                <p class="mt-3 text-xs text-center text-red-600 my-2 font-medium">
                    {{ $errors->first('password') }}
                </p>
                @endif

                @if (session('status'))
                <p class="text-green-500 text-sm text-center mb-4">{{ session('status') }}</p>
                @endif
            </form>
        </div>
    </div>
</body>
<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        const eyeOpen = document.getElementById('eye-open-' + id);
        const eyeClosed = document.getElementById('eye-closed-' + id);

        if (input.type === 'password') {
            input.type = 'text';
            eyeOpen.classList.add('hidden');
            eyeClosed.classList.remove('hidden');
        } else {
            input.type = 'password';
            eyeOpen.classList.remove('hidden');
            eyeClosed.classList.add('hidden');
        }
    }
</script>
</html>