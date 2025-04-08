<?php

namespace App\Livewire\Shipments;

use App\Models\Shipment;
use App\Livewire\Shipments\Table;
use Livewire\Component;

class UpdateForm extends Component
{
    public $shipment;
    public $departure_waybill_number;
    public $return_waybill_number;
    public $load_type;
    public $client;
    public $delivery_order_price;

    public function mount($shipment)
    {
        $this->shipment = $shipment;

        $this->departure_waybill_number = $this->shipment->departure_waybill_number;
        $this->return_waybill_number = $this->shipment->return_waybill_number;
        $this->load_type = $this->shipment->load_type;
        $this->client = $this->shipment->client;
        $this->delivery_order_price = $this->shipment->delivery_order_price;
    }

    public function updateShipment()
    {
        $this->validate([
            'departure_waybill_number' => 'nullable|string',
            'client' => 'nullable|string',
            'load_type' => 'nullable|string',
            'return_waybill_number' => 'nullable|string',
            'delivery_order_price' => 'nullable|numeric',
        ]);

        $shipment = Shipment::findOrFail($this->shipment->id);

        $shipment->update([
            'departure_waybill_number' => $this->departure_waybill_number,
            'client' => $this->client,
            'load_type' => $this->load_type,
            'return_waybill_number' => $this->return_waybill_number,
            'delivery_order_price' => $this->delivery_order_price,
        ]);

        $this->dispatch('shipmentUpdated')->to(Table::class);
        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('livewire.shipments.update-form');
    }
}
