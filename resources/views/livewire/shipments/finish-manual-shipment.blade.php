<div>
    <p class="text-sm text-gray-800 mb-4">
        <span class="font-semibold">Pastikan anda melakukan konfirmasi terlebih dahulu dengan pengemudi truk.</span>
    </p>

    <form wire:submit="finishManualShipment">
        <div class="flex flex-col bg-[#FFFFFF]">
            <div id="autocomplete" class="mb-4">
                <label for="final_location" class="block text-xs font-medium text-gray-700 mb-1"></label>
                <input wire:model.defer='final_location' id="final_location" type="text" name="final_location" placeholder="Cari lokasi..."
                    class="text-xs p-2 mt-1 block w-full rounded-lg border-gray-300 border-1 shadow-xs focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div class="relative" x-data="{ open: false, clearFields() {
                        $wire.set('search', '');
                        $wire.set('shipments', []);
                    }
                }" x-init="$watch('open', value => !value && clearFields())">
                <label class="block text-xs font-medium text-gray-700 mb-1">Pengiriman</label>

                <div class="relative">
                    <input type="text" wire:model.live.debounce.300ms="search" {{ count($selectedShipments)> 0 ?
                    'readonly' : '' }}
                    @focus="open = true"
                    @click.away="open = false"
                    placeholder="Cari pengiriman..."
                    class="w-full mb-2 rounded-lg border-[#EFF0F6] shadow-sm focus:border-[var(--color-primary)]
                    focus:ring-[var(--color-primary)] text-xs placeholder:text-xs py-2 px-4
                    {{ count($selectedShipments) > 0 ? "bg-gray-100 cursor-not-allowed" : "" }}"
                    >

                    <div x-show="open" x-transition
                        class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-xl py-2 text-xs ring-1 ring-[#EFF0F6] overflow-auto">
                        @if(count($shipments) > 0)
                        @foreach($shipments as $shipment)
                        <div wire:key="shipment-{{ $shipment['id'] }}" wire:click="selectShipment({ 
                                        id: {{ $shipment['id'] }}, 
                                        plate_number: '{{ $shipment['plate_number'] }}', 
                                        client: '{{ $shipment['client'] }}', 
                                        departure_waybill_number: '{{ $shipment['departure_waybill_number'] }}', 
                                        return_waybill_number: '{{ $shipment['return_waybill_number'] }}' 
                                    })" @click="open = false"
                            class="cursor-pointer select-none py-2 px-4 hover:bg-gray-50">
                            <div class="flex gap-2">
                                <span class="font-medium text-gray-800">{{ $shipment['plate_number'] }}</span>
                                <span class="text-gray-600">{{ $shipment['client'] }}</span>
                                <span class="text-gray-600">{{ $shipment['departure_waybill_number'] }}</span>
                                <span class="text-gray-600">{{ $shipment['return_waybill_number'] }}</span>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="py-2 px-4 text-gray-500">
                            @if(count($selectedShipments) > 0)
                            Hanya bisa menyelesaikan satu pengiriman
                            @elseif(strlen($search) >= 2)
                            Tidak ada pengiriman ditemukan
                            @else
                            Ketik minimal 2 karakter untuk mencari
                            @endif
                        </div>
                        @endif
                    </div>
                </div>

                @if(count($selectedShipments) > 0)
                <div class="my-2 flex flex-wrap gap-2">
                    @foreach($selectedShipments as $index => $shipment)
                    <div
                        class="flex justify-between w-full items-center gap-1 bg-gray-50 py-1 px-2 rounded-xl border border-[#EFF0F6]">
                        <div class="flex gap-2">
                            <span class="text-xs font-medium text-gray-800">{{ $shipment['plate_number'] }}</span>
                            <span class="text-xs text-[#64748B]">{{ $shipment['client'] }}</span>
                            <span class="text-xs text-[#64748B]">{{ $shipment['departure_waybill_number'] }}</span>
                            <span class="text-xs text-[#64748B]">{{ $shipment['return_waybill_number'] }}</span>
                        </div>
                        <button type="button" wire:key="remove-{{ $index }}" wire:click="removeShipment({{ $index }})"
                            class="text-xs text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 p-1 rounded-lg ml-1">
                            &times;
                        </button>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <p class="mt-3 text-xs text-center text-red-600 my-2 font-medium">{{ $errorMessage }}</p>

            <div class="flex justify-end gap-2">
                <button @click="$dispatch('close-modal')"
                    class="px-4 py-2 text-xs text-white bg-[#C30010] hover:bg-red-700  rounded-lg cursor-pointer">
                    Kembali
                </button>
                <button type="submit"
                    class="px-4 py-2 text-xs bg-[var(--color-primary)] text-white rounded-lg cursor-pointer">
                    Ok
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<!-- Load Google Maps API script -->
<script
    src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=places&callback=initAutocomplete&loading=async">
</script>

<!-- Autocomplete initialization -->
<script>
    function initAutocomplete() {
            const input = document.getElementById('final_location');
            if (!input || input.dataset.autocompleteAttached) return;

            const autocomplete = new google.maps.places.Autocomplete(input, {
                componentRestrictions: { country: 'ID' }
            });

            input.dataset.autocompleteAttached = true;

            autocomplete.addListener('place_changed', function () {
                const place = autocomplete.getPlace();
                if (place && place.geometry && place.geometry.location) {
                    const lat = place.geometry.location.lat();
                    const lng = place.geometry.location.lng();

                    @this.set('final_location', place.formatted_address);
                    @this.set('latitude', lat);
                    @this.set('longitude', lng);
                }
            });
        }

        document.addEventListener('livewire:load', function () {
            Livewire.hook('message.processed', () => {
                if (typeof google !== 'undefined' && google.maps && google.maps.places) {
                    initAutocomplete();
                }
            });
        });
</script>
@endpush