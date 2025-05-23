<form wire:submit="updateDriver">
    <x-modal-form-field wire:model="name" label="Nama Pengemudi" name="name" value="{{ $driver->name }}" />

    <x-modal-form-field wire:model="contact_number" label="Nomor Kontak" name="contact_number"
        value="{{ $driver->contact_number }}" />

    <p class="mt-3 text-xs text-center text-red-600 my-2 font-medium">{{ collect($errors->all())->first() }}</p>

    <div class="mt-2 flex justify-end">
        <input type="submit" class="text-xs bg-[var(--color-primary)] text-white font-regular py-2 px-4 rounded-lg"
            value="Simpan">
    </div>
</form>