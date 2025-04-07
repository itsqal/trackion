<x-auth.auth-form>
    <x-slot:title>
        Register
    </x-slot:title>
    <div class="w-full max-w-sm">
        <form action="/register" method="POST" class="bg-white shadow-md rounded px-6 pt-5 pb-6">
            <h1 class="text-2xl text-[#170F49] text-center font-bold">
                Buat Akun Baru
            </h1>
            <p class="text-sm text-center text-[#64748B] mt-2 mb-4">
                Silahkan isi informasi di bawah ini untuk membuat akun baru.
            </p>
            @csrf
            <x-auth.form-field label="Nama" name="name" type="text" placeholder="Masukan nama anda" class="text-sm" />
            <x-auth.form-field label="Email" name="email" type="email" placeholder="Masukan email anda" class="text-sm" />
            <x-auth.form-field label="Password" name="password" type="password" placeholder="Masukan password anda" class="text-sm" />
            <x-auth.form-field label="Konfirmasi Password" name="password_confirmation" type="password" placeholder="Masukan ulang password anda" class="text-sm" />
            <x-auth.form-error field="password"/>

            <div class="flex justify-end mb-3">
                <a href="#" class="text-xs text-[#9747FF] font-semibold hover:underline">Lupa password?</a>
            </div>

            <x-auth.form-button value="Register" class="text-sm"></x-form-button>

            <div class="flex justify-center mt-3">
                <span class="text-xs text-gray-700 font-semibold">
                    Sudah memiliki akun? <a href="{{  route('login') }}" class="text-xs text-[#9747FF] hover:underline">Login</a>
                </span>
            </div>
        </form>
    </div>
</x-auth.auth-form>