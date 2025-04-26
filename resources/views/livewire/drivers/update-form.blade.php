<form wire:submit="updateDriver">
    <x-modal-form-field wire:model="name" label="Nama Pengemudi" name="name" value="{{ $driver->name }}" />

    <x-modal-form-field wire:model="email" label="Email" name="email" value="{{ $driver->email }}"/>

    <x-modal-form-field wire:model="contact_number" label="Nomor Kontak" name="contact_number" value="{{ $driver->contact_number }}" />

    @if ($errors->any())
    @php
    $errorMessage = collect($errors->all())->first();
    @endphp
    <p class="mt-3 text-xs text-center text-red-600 my-2 font-medium">
        {{ $errorMessage }}
    </p>
    @endif

    <div class="mt-2 flex justify-end">
        <input type="submit" class="text-xs bg-[var(--color-primary)] text-white font-regular py-2 px-4 rounded-lg" value="Simpan">
    </div>
</form>