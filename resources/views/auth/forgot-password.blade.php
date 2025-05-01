<x-auth.auth-form>
    <x-slot:title>
        Login
    </x-slot:title>
    <div class="w-full max-w-xs sm:max-w-sm mx-auto">
        @if (session('status'))
            <div class="mb-4 text-green-800 text-sm text-center font-medium transition-all duration-300 ease-in-out">
                {{ session('status') }}
            </div>
        @endif
        <form action="{{ route('password.email') }}" method="POST"
            class="bg-white shadow-md rounded-xl px-4 sm:px-6 pt-4 sm:pt-5 pb-5 sm:pb-6">
            <h1 class="text-xl sm:text-2xl text-[#170F49] text-center font-bold">
                Masukan akun email
            </h1>
            <p class="text-xs sm:text-sm text-center text-[#64748B] mt-2 mb-4">
                Silahkan masukan akun email anda untuk mendapatkan email konfirmasi reset password.
            </p>
            @csrf
            <label for="email" class="block text-xs sm:text-sm text-[#170F49] font-semibold">Email</label>
            <input type="email" value="{{ old('email') }}" placeholder="Masukan email anda" name="email"
                class="mb-3 shadow w-full rounded-3xl border-[#EFF0F6] border-1 text-xs sm:text-sm placeholder:text-xs sm:placeholder:text-sm py-2 px-2">
            @if ($errors->any())
            @php
            $errorMessage = collect($errors->all())->first();
            @endphp
            <p class="mt-3 text-xs text-center text-red-600 my-2 font-medium">
                {{ $errorMessage}}
            </p>
            @endif

            <button type="submit"
                class="w-full text-sm sm:text-base bg-[var(--color-primary)] text-white font-semibold py-2 rounded-3xl">Kirim</button>
        </form>
    </div>
</x-auth.auth-form>