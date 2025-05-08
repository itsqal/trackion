<form wire:submit="createTruck">
    <div class="flex flex-col bg-[#FFFFFF]">
        <x-modal-form-field id="plate_number" label="Nomor Plat" name="plate_number" placeholder="XX 1234 XYZ"
            wire:model="plate_number" />

        <x-modal-form-field label="Model / Jenis Truk" name="model" placeholder="Masukan model atau jenis truk"
            wire:model="model" />

        <x-modal-form-field type="number" label="Total Jarak Tempuh" name="total_distance"
            placeholder="Masukan total jarak tempuh truk jika ada (optional)" wire:model="total_distance" />

        <p class="mt-3 text-xs text-center text-red-600 my-2 font-medium">{{ collect($errors->all())->first() }}</p>

        <div class="mt-2 flex justify-end">
            <input type="submit"
                class="text-xs bg-[var(--color-primary)] text-white font-regular py-2 px-4 rounded-lg cursor-pointer"
                value="Tambah">
        </div>
    </div>
</form>