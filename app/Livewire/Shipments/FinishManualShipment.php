<?php

namespace App\Livewire\Shipments;

use App\Jobs\FinishManualShipmentJob;
use App\Livewire\Shipments\Table;
use Livewire\Attributes\On; 
use Livewire\Component;
use App\Models\Shipment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FinishManualShipment extends Component
{
    public $shipment;
    public $final_location;
    public $search = '';
    public $selectedShipments = [];
    public $shipments = [];

    public $location;
    public $latitude;
    public $longitude;

    public $errorMessage = '';

    protected $listeners = ['close-modal' => '$refresh'];

    #[On('close-modal')] 
    public function resetModal()
    {
        $this->reset([
            'final_location',
            'selectedShipments',
            'latitude',
            'longitude',
            'search', 
            'shipments',
            'errorMessage'
        ]);
    }

    public function updatedSearch()
    {
        if (strlen($this->search) >= 2) {
            $selectedIds = collect($this->selectedShipments)->pluck('id')->toArray();

            $this->shipments = Shipment::where('user_id', Auth::id())
                ->where('status', 'perjalanan')
                ->whereNotIn('id', $selectedIds)
                ->search($this->search)
                ->take(5)
                ->get()
                ->toArray();
        } else {
            $this->shipments = [];
        }
    }

    public function selectShipment($shipment)
    {
        $this->selectedShipments[] = $shipment;
        $this->search = '';
        $this->shipments = [];
    }

    public function removeShipment($index)
    {
        unset($this->selectedShipments[$index]);
        $this->selectedShipments = array_values($this->selectedShipments);
    }

    public function finishManualShipment()
    {
        $validator = Validator::make([
            'final_location' => $this->final_location,
            'selectedShipments' => $this->selectedShipments,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ], [
            'final_location' => 'required|string',
            'selectedShipments' => 'required|array|min:1',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ], [
            'final_location.required' => 'Lokasi tujuan pengiriman tidak boleh kosong. Mohon masukan lokasi pengiriman.',
            'selectedShipments.required' => 'Pengiriman tidak boleh kosong. Mohon pilih pengiriman.',
            'latitude.required' => 'Lokasi tidak valid. Mohon pilih lokasi yang valid.',
            'longitude.required' => 'Lokasi tidak valid. Mohon pilih lokasi yang valid.',
            'selectedShipments.min' => 'Pengiriman tidak boleh kosong. Mohon pilih pengiriman.',
        ]);

        if ($validator->fails()) {
            $this->errorMessage = collect($validator->errors()->all())->first();
            return;
        }

        $shipment = Shipment::findOrFail($this->selectedShipments[0]['id']);

        $shipment->update([
            'status' => 'selesai',
            'completed_at' => now(),
            'final_location' => $this->final_location
        ]);

        FinishManualShipmentJob::dispatch($shipment->id, $this->latitude, $this->longitude);

        $this->dispatch('shipmentUpdated')->to(Table::class);
        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('livewire.shipments.finish-manual-shipment');
    }
}