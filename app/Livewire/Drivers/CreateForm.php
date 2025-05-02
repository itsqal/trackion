<?php

namespace App\Livewire\Drivers;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateForm extends Component
{
    public $name;
    public $contact_number;

    public function createDriver()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Nama pengemudi tidak boleh kosong.',
        ]);

        \App\Models\Driver::create([
            'user_id' => Auth::id(),
            'name' => $this->name,
            'contact_number' => $this->contact_number,
        ]);

        $this->reset(['name', 'contact_number']);

        $this->dispatch('driverUpdated');
        $this->dispatch('close-modal');
    }
    public function render()
    {
        return view('livewire.drivers.create-form');
    }
}
