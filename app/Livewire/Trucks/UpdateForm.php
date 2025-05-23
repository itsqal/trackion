<?php

namespace App\Livewire\Trucks;

use App\Models\Driver;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class UpdateForm extends Component
{
    public $truck;
    public $plate_number;
    public $model;
    public $search = '';
    public $selectedDrivers = [];
    public $drivers = [];

    #[On('open-modal')] 
    public function resetModal()
    {
        $this->reset([
            'search',
            'drivers'
        ]);

        $this->plate_number = $this->truck->plate_number;
        $this->model = $this->truck->model;
        $this->selectedDrivers = $this->truck->drivers->map(function($driver) {
            return [
                'id' => $driver->id,
                'name' => $driver->name,
                'contact_number' => $driver->contact_number
            ];
        })->toArray();

        $this->resetErrorBag();
    }

    public function mount($truck)
    {
        $this->truck = $truck;
        $this->plate_number = $truck->plate_number;
        $this->model = $truck->model;
        $this->selectedDrivers = $truck->drivers->map(function($driver) {
            return [
                'id' => $driver->id,
                'name' => $driver->name,
                'contact_number' => $driver->contact_number
            ];
        })->toArray();
    }

    public function updatedSearch()
    {
        if (strlen($this->search) >= 2) {
            $selectedIds = collect($this->selectedDrivers)->pluck('id')->toArray();
            
            $this->drivers = Driver::where('user_id', Auth::id())
                ->whereNotIn('id', $selectedIds)
                ->search($this->search)
                ->take(5)
                ->get();
        }
    }

    public function selectDriver($driver)
    {
        $this->selectedDrivers[] = $driver;
        $this->search = '';
        $this->drivers = [];
    }

    public function removeDriver($index)
    {
        unset($this->selectedDrivers[$index]);
        $this->selectedDrivers = array_values($this->selectedDrivers);
    }

    public function updateTruck()
    {
        $this->validate([
            'plate_number' => ['required', 'regex:/^[a-zA-Z]{1,2} \d{4} [a-zA-Z]{1,3}$/'],
            'model' => 'required',
        ], [
            'plate_number.required' => 'Nomor plat tidak boleh kosong. Mohon isi nomor plat kendaraan.',
            'plate_number.regex' => 'Gunakan format nomor plat yang sesuai (XX 1234 XYZ)',
            'model.required' => 'Model tidak boleh kosong. Mohon isi data model kendaraan.',
        ]);

        $this->truck->update([
            'plate_number' => strtoupper($this->plate_number),
            'model' => $this->model,
        ]);

        $driverIds = collect($this->selectedDrivers)->pluck('id')->toArray();
        $this->truck->drivers()->sync($driverIds);

        $this->dispatch('truckUpdated');
        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('livewire.trucks.update-form');
    }
}
