<?php

namespace App\Livewire\Trucks;

use Livewire\Component;
use App\Livewire\Trucks\Table;

#[\Livewire\Attributes\Title('Truck')]

class Index extends Component
{
    public function exportExcel()
    {
        return $this->dispatch('exportTruck')->to(Table::class);
    }
    
    public function render()
    {
        return view('livewire.trucks.index');
    }
}
