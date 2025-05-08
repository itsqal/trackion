<?php

namespace App\Livewire\Drivers;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On; 
use Livewire\Component;
use App\Models\Driver;

class CreateForm extends Component
{
    public $name;
    public $contact_number;

    #[On('close-modal')] 
    public function resetModal()
    {
        $this->reset([
            'name',
            'contact_number'
        ]);

        $this->resetErrorBag();
    }

    public function createDriver()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'contact_number' => 'numeric|nullable',
        ], [
            'name.required' => 'Nama pengemudi tidak boleh kosong.',
            'contact_number.numeric' => 'Nomor kontak tidak valid.'
        ]);

        Driver::create([
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