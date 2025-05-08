<form wire:submit="createDriver">
    <div class="flex flex-col bg-[#FFFFFF]">
        <x-modal-form-field label="Nama Pengemudi" name="name" placeholder="Masukan nama pengemudi" wire:model="name" />

        <x-modal-form-field label="Nomor Kontak Pengemudi" name="contact_number"
            placeholder="Masukan nomor kontak pengemudi (optional)" wire:model="contact_number" />

        <p class="mt-3 text-xs text-center text-red-600 my-2 font-medium">{{ collect($errors->all())->first() }}</p>

        <div class="mt-2 flex justify-end">
            <input type="submit"
                class="text-xs bg-[var(--color-primary)] text-white font-regular py-2 px-4 rounded-lg cursor-pointer"
                value="Tambah">
        </div>
    </div>
</form>