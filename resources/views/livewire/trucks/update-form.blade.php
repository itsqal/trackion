<form wire:submit="updateTruck">
    <x-modal-form-field wire:model="plate_number" label="Nomor Plat" name="plate_number" />

    <x-modal-form-field wire:model="model" label="Model Kendaraan" name="model" />

    <div class="relative" x-data="{ open: false }">
        <label class="block text-xs font-medium text-gray-700 mb-1">Pengemudi</label>
        <div class="relative">
            <input type="text" wire:model.live.debounce.300ms="search" @focus="open = true" @click.away="open = false"
                placeholder="Cari pengemudi..."
                class="w-full rounded-lg border-[#EFF0F6] shadow-sm focus:border-[var(--color-primary)] focus:ring-[var(--color-primary)] text-xs placeholder:text-xs py-2 px-4">

            <div x-show="open" x-transition
                class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-xl py-2 text-xs ring-1 ring-[#EFF0F6] overflow-auto">
                @if(count($drivers) > 0)
                @foreach($drivers as $driver)
                <div wire:key="driver-{{ $driver->id }}"
                    wire:click="selectDriver({ id: {{ $driver->id }}, name: '{{ $driver->name }}', contact_number: '{{ $driver->contact_number }}' })"
                    @click="open = false" class="cursor-pointer select-none py-2 px-4 hover:bg-gray-50">
                    <div class="flex gap-2">
                        <span class="font-medium text-gray-800">
                            {{ $driver->name }}
                        </span>
                        <span class="text-[#64748B] text-xs">
                            {{ $driver->contact_number }}
                        </span>
                    </div>
                </div>
                @endforeach
                @else
                @if(strlen($search) >= 2)
                <div class="py-2 px-4 text-gray-500">
                    Tidak ada pengemudi ditemukan
                </div>
                @else
                <div class="py-2 px-4 text-gray-500">
                    Ketik minimal 2 karakter untuk mencari
                </div>
                @endif
                @endif
            </div>
        </div>

        @if(count($selectedDrivers) > 0)
        <div class="mt-2 flex flex-wrap gap-2">
            @foreach($selectedDrivers as $index => $driver)
            <div class="flex items-center gap-1 bg-gray-50 py-1 px-2 rounded-xl border border-[#EFF0F6]">
                <div class="flex gap-2">
                    <span class="text-xs font-medium text-gray-800">{{ $driver['name'] }}</span>
                    <span class="text-xs text-[#64748B]">{{ $driver['contact_number'] }}</span>
                </div>
                <button type="button" wire:key="remove-{{ $index }}" wire:click="removeDriver({{ $index }})"
                    class="text-xs text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 p-1 rounded-lg ml-1">
                    &times;
                </button>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <p class="mt-3 text-xs text-center text-red-600 my-2 font-medium">{{ collect($errors->all())->first() }}</p>

    <div class="mt-4 flex justify-end">
        <button type="submit"
            class="text-xs bg-[var(--color-primary)] text-white font-regular py-2 px-4 rounded-3xl cursor-pointer">
            Simpan
        </button>
    </div>
</form>