<?php

namespace App\Livewire\Shipments;

use Livewire\Component;
use App\Livewire\Shipments\Table;

#[\Livewire\Attributes\Title('Shipment')]

class Index extends Component
{
    public function exportExcel()
    {
        return $this->dispatch('exportShipment')->to(Table::class);
    }

    public function render()
    {
        return view('livewire.shipments.index');
    }
}
