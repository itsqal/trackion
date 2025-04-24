@extends('layouts.guest')

@section('title', 'Tracking')

@section('content')
{{-- Shipping success animation --}}
<div id="finish-shipping-animation" class="flex flex-col items-center max-w-xl mx-auto px-4 sm:px-6 mt-10 space-y-6 hidden">
    <img src="{{ asset('images/finish-shipping-animation.png') }}" alt="" class="max-w-60 max-h-60 animate-pulse">
    <div class="text-center space-y-2">
        <h1 class="text-white text-2xl sm:text-3xl font-bold">Pengiriman Selesai!</h1>
        <p class="text-white text-sm text-wrap sm:text-base font-regular">
            Terimakasih telah menyelesaikan pengiriman ini! Pekerjaan Anda membantu kami memberikan pelayanan terbaik untuk pelanggan.
        </p>
    </div>
</div>

<!-- Danger Alert -->
<div id="error-alert" class="fixed max-w-3xl top-0 left-1/2 transform -translate-x-1/2 -translate-y-full transition-all duration-500 flex items-center p-4 text-xs text-red-800 rounded-lg bg-red-50 z-50" role="alert">
    <svg class="shrink-0 inline w-4 h-4 me-3" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
    </svg>
    <span class="sr-only">Info</span>
    <div>
    <span class="font-medium">Gagal mengambil lokasi!</span> Pastikan GPS perangkat anda aktif dan izin lokasi diberikan.
    </div>
</div>

{{-- Getting Location Alert --}}
<div id="getting-location-alert" class="fixed min-w-xs top-0 left-1/2 transform -translate-x-1/2 -translate-y-full transition-all duration-500 flex items-center p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 gap-2" role="alert">
    <div role="status">
        <svg aria-hidden="true" class="w-5 h-5 text-gray-200 animate-spin fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
        </svg>
    </div>
    <div>
        <span class="font-medium text-xs">Mendapatkan lokasi...
    </div>
</div>

{{-- Loading Skeleton --}}
<div id="loading-overlay" class="loader hidden">
    <span class="loader-text">Memproses</span>
    <span class="load"></span>
</div>

<div id="main-content" class="flex flex-col max-w-xl mx-auto px-4 sm:px-6 mt-10 space-y-6">
    <!-- Judul dan deskripsi -->
    <div class="text-center space-y-2">
        <h1 class="text-white text-2xl sm:text-3xl font-bold">Anda Dalam Pengiriman!</h1>
        <p class="text-white text-sm sm:text-base font-medium">
            Pastikan perjalanan Anda tetap aman dan terkendali, dan segera laporkan jika terjadi kendala.
        </p>
    </div>

    <!-- Informasi Truck & Pengemudi -->
    <div class="bg-white p-6 sm:p-6 rounded-2xl shadow-lg space-y-4 relative">
        <div class="grid grid-cols-[auto_1fr] gap-x-4 gap-y-2">
            <p class="text-sm font-medium text-[var(--color-primary)]">Nomor Plat</p>
            <p class="text-sm font-medium text-gray-800">:&nbsp;&nbsp;&nbsp;{{ $truck->plate_number }}</p>

            <p class="text-sm font-medium text-[var(--color-primary)]">Pengemudi</p>
            <p class="text-sm font-medium text-gray-800">:&nbsp;&nbsp;&nbsp;-</p>

            <p class="text-sm font-medium text-[var(--color-primary)]">Kendaraan</p>
            <p class="text-sm font-medium text-gray-800">:&nbsp;&nbsp;&nbsp;{{ ucwords($truck->model) }}</p>

            <p class="text-sm font-medium text-[var(--color-primary)]">Status</p>
            <p class="text-sm font-medium text-gray-800">:&nbsp;&nbsp;&nbsp;{{ ucwords($truck->current_status) }}</p>
        </div>

        <!-- Tombol aksi -->
        <form id="tracking-form" class="pt-4">
            <div class="flex flex-col sm:flex-row justify-between gap-4">
                <button 
                    onclick="finishTracking()"
                    type="button" 
                    class="w-full px-6 py-2 bg-[var(--color-primary)] hover:opacity-90 text-white text-sm font-medium rounded-full transition disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    Selesai
                </button>

                <button 
                    type="button" 
                    class="flex justify-center items-center gap-2 px-6 py-2 bg-[#DF0404] hover:opacity-90 text-white text-sm font-medium rounded-full transition lg:w-full md:w-full"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" 
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" 
                        class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 
                                1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 
                                3.378c-.866-1.5-3.032-1.5-3.898 
                                0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                    Lapor Kendala
                </button>
            </div>
        </form>
    </div>        
</div>
<script>
    window.truckId = "{{ $truck->id }}";
</script>
@endsection