<?php

namespace App\Livewire\Trucks;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateForm extends Component
{
    public $plate_number;
    public $model;
    public $total_distance;

    public function createTruck()
    {
        $this->validate([
            'plate_number' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'total_distance' => 'nullable|numeric|min:0',
        ], [
            'plate_number.required' => 'Nomor plat tidak boleh kosong. Mohon isi nomor plat kendaraan.',
            'model.required' => 'Model tidak boleh kosong. Mohon isi data model kendaraan.',
            'total_distance.numeric' => 'Total jarak harus berupa angka.',
            'total_distance.min' => 'Total jarak tidak valid.',
        ]);

        \App\Models\Truck::create([
            'user_id' => Auth::id(),
            'plate_number' => $this->plate_number,
            'model' => $this->model,
            'total_distance' => $this->total_distance ?? 0,
            'current_status' => 'tidak dalam pengiriman',
        ]);

        $this->reset(['plate_number', 'model', 'total_distance']);

        $this->dispatch('truckUpdated');
        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('livewire.trucks.create-form');
    }
}