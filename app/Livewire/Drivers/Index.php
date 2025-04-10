<?php

namespace App\Livewire\Drivers;

use Livewire\Component;
use App\Livewire\Drivers\Table;

#[\Livewire\Attributes\Title('Driver')]

class Index extends Component
{
    public function exportExcel()
    {
        return $this->dispatch('exportDriver')->to(Table::class);
    }

    public function render()
    {
        return view('livewire.drivers.index');
    }

    public function viewAddDriver()
    {
        $this->dispatch('open-modal', name: 'view-add-driver');
    }
}
