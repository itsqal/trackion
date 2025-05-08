<?php

namespace App\Livewire\Drivers;

use Livewire\Attributes\On; 
use Livewire\Component;

class UpdateForm extends Component
{
    public $driver;
    public $name;
    public $contact_number;

    public function mount($driver)
    {
        $this->driver = $driver;
        $this->name = $driver->name;
        $this->contact_number = $driver->contact_number;
    }

    #[On('open-modal')] 
    public function resetModal()
    {
        $this->resetErrorBag();
        $this->name = $this->driver->name;
        $this->contact_number = $this->driver->contact_number;
    }

    public function updateDriver()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'contact_number' => 'numeric|nullable',
        ], [
            'name.required' => 'Nama pengemudi tidak boleh kosong.',
            'contact_number.numeric' => 'Nomor kontak tidak valid.'
        ]);

        $this->driver->update([
            'name' => $this->name,
            'contact_number' => $this->contact_number,
        ]);

        $this->dispatch('driverUpdated');
        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('livewire.drivers.update-form');
    }
}
