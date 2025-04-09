@extends('layouts.guest')

@section('title', 'Tracking')

@section('content')
    @if ($truck->current_status === 'dalam pengiriman')
    <div class="flex flex-col max-w-xl mx-auto px-4 sm:px-6 mt-10 space-y-6">
        <!-- Judul dan deskripsi -->
        <div class="text-center space-y-2">
            <h1 class="text-white text-2xl sm:text-3xl font-bold">Anda Dalam Pengiriman!</h1>
            <p class="text-white text-sm sm:text-base font-medium">
                Pastikan perjalanan Anda tetap aman dan terkendali, dan segera laporkan jika terjadi kendala.
            </p>
        </div>
    
        <!-- Informasi Truck & Pengemudi -->
        <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-lg space-y-2">
            <div class="grid grid-cols-[auto_1fr] gap-x-4 gap-y-2">
                <p class="text-sm font-medium text-[var(--color-primary)]">Nomor Plat</p>
                <p class="text-sm font-medium text-gray-800">:&nbsp; &nbsp; &nbsp;{{ $truck->plate_number }}</p>
        
                <p class="text-sm font-medium text-[var(--color-primary)]">Pengemudi</p>
                <p class="text-sm font-medium text-gray-800">:&nbsp; &nbsp; &nbsp;-</p>
        
                <p class="text-sm font-medium text-[var(--color-primary)]">Kendaraan</p>
                <p class="text-sm font-medium text-gray-800">:&nbsp; &nbsp; &nbsp;{{ ucwords($truck->model) }}</p>
        
                <p class="text-sm font-medium text-[var(--color-primary)]">Status</p>
                <p class="text-sm font-medium text-gray-800">:&nbsp; &nbsp; &nbsp;{{ ucwords($truck->current_status) }}</p>
            </div>
        
            <!-- Tombol aksi -->
            <form id="tracking-form" class="pt-4">
                <div class="flex flex-col sm:flex-row justify-between gap-4">
                    <button 
                    type="button" 
                    class="px-6 py-2 bg-[var(--color-primary)] hover:opacity-90 text-white text-sm font-medium rounded-full transition lg:w-full md:w-full"
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
    @else
    <div class="flex flex-col max-w-xl mx-auto px-4 sm:px-6 mt-10 space-y-6">
        <!-- Judul dan deskripsi -->
        <div class="text-center space-y-2">
            <h1 class="text-white text-2xl sm:text-3xl font-bold">Siap Memulai Pengiriman Anda?</h1>
            <p class="text-white text-sm sm:text-base font-medium">
                Optimalkan perjalanan Anda dengan informasi terkini dan proses pengiriman yang efisien.
            </p>
        </div>
    
        <!-- Informasi Truck & Pengemudi -->
        <div class="bg-white p-4 sm:p-6 rounded-2xl shadow-lg space-y-2">
            <div class="grid grid-cols-[auto_1fr] gap-x-4 gap-y-2">
                <p class="text-sm font-medium text-[var(--color-primary)]">Nomor Plat</p>
                <p class="text-sm font-medium text-gray-800">:&nbsp; &nbsp; &nbsp;{{ $truck->plate_number }}</p>
        
                <p class="text-sm font-medium text-[var(--color-primary)]">Pengemudi</p>
                <p class="text-sm font-medium text-gray-800">:&nbsp; &nbsp; &nbsp;-</p>
        
                <p class="text-sm font-medium text-[var(--color-primary)]">Kendaraan</p>
                <p class="text-sm font-medium text-gray-800">:&nbsp; &nbsp; &nbsp;{{ ucwords($truck->model) }}</p>
            </div>
        
            <!-- Tombol aksi -->
            <form id="start-tracking-form" class="pt-4">
                <div class="flex flex-col sm:flex-row justify-between gap-4">
                    <button 
                    type="button" 
                    onclick="startTracking()" 
                    class="px-6 py-2 bg-[var(--color-primary)] hover:opacity-90 text-white text-sm font-medium rounded-full transition lg:w-full md:w-full"
                >
                    Mulai
                </button>
                </div>
            </form>
        </div>     
        </div>
    </div>        
    @endif
    
    <script>
        function startTracking() {
            navigator.geolocation.getCurrentPosition(async (position) => {
                const { latitude, longitude } = position.coords;
                const truckId = "{{ $truck->id }}";

                const res = await fetch('/api/location/reverse-geocode', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ latitude, longitude, truck_id: truckId })
                });
                
                const data = await res.json();
                
                if (data) {
                    window.location.reload(); 
                }

            }, (error) => {
                alert('Gagal mengambil lokasi. Pastikan izin lokasi sudah diberikan.');
                console.error('Error:', error);
            });
        }
    </script>
@endsection

