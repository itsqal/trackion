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

    {{-- Loading Skeleton --}}
    <div id="loading-overlay" class="flex items-center justify-center w-56 h-56 hidden">
        <div class="px-5 py-2 text-lg font-medium leading-none text-center text-gray-800 bg-blue-200 rounded-full animate-bounce">Mohon tunggu...</div>
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
                        class="w-full px-6 py-2 bg-[var(--color-primary)] hover:opacity-90 text-white text-sm font-medium rounded-full transition"
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