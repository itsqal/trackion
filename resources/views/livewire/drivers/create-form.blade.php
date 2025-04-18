<form wire:submit="createDriver">
    <div class="flex flex-col bg-[#FFFFFF]">
        <div class="flex flex-col space-y-2">

            <x-modal-form-field
                label="Nama Pengemudi"
                name="name"
                placeholder="Masukan nama pengemudi"
                wire:model="name"
            />

            <x-modal-form-field
            label="Email Pengemudi"
            name="email"
            placeholder="Masukan email pengemudi (optional)"
            wire:model="email"
            />

            <x-modal-form-field
            label="Nomor Kontak Pengemudi"
            name="contact_number"
            placeholder="Masukan nomor kontak pengemudi (optional)"
            wire:model="contact_number"
            />

    <div class="mt-2 flex justify-end">
        <input type="submit" class="text-xs bg-[var(--color-primary)] text-white font-regular py-2 px-4 rounded-lg cursor-pointer" value="Tambah">
    </div>
</form>