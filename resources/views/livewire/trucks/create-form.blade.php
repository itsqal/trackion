<form wire:submit="createTruck">
    <div class="flex flex-col bg-[#FFFFFF]">
        <div class="flex flex-col space-y-2">

            <x-modal-form-field
                label="Nomor Plat"
                name="plate_number"
                placeholder="Masukan nomor plat"
                wire:model="plate_number"
            />

            <x-modal-form-field
            label="Model / Jenis Truk"
            name="model"
            placeholder="Masukan model atau jenis truk"
            wire:model="model"
            />

            <x-modal-form-field
            type="number"
            label="Total Jarak Tempuh"
            name="total_distance"
            placeholder="Masukan total jarak tempuh truk jika ada (optional)"
            wire:model="total_distance"
            />

    <div class="mt-2 flex justify-end">
        <input type="submit" class="text-xs bg-[var(--color-primary)] text-white font-regular py-2 px-4 rounded-lg cursor-pointer" value="Tambah">
    </div>
</form>