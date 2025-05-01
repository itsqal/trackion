<?php

namespace App\Livewire\Drivers;

use Livewire\Component;

class UpdateForm extends Component
{
    public $driver;
    public $name;
    public $email;
    public $contact_number;

    public function mount($driver)
    {
        $this->driver = $driver;
        $this->name = $driver->name;
        $this->email = $driver->email;
        $this->contact_number = $driver->contact_number;
    }

    public function updateDriver()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'email|max:255|nullable',
            'contact_number' => 'string|max:15|nullable',
        ], [
            'email.email' => 'Email tidak valid. Pastiakan menggunakan format email yang benar.',
        ]);

        $this->driver->update([
            'name' => $this->name,
            'email' => $this->email,
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
