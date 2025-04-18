<?php

namespace App\Livewire\Trucks;

use Livewire\Component;
use App\Livewire\Trucks\Table;
use Illuminate\Support\Facades\Auth;

#[\Livewire\Attributes\Title('Truck')]

class Index extends Component
{
    public function mount()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
    }

    public function exportExcel()
    {
        return $this->dispatch('exportTruck')->to(Table::class);
    }

    public function viewAddTruck()
    {
        $this->dispatch('open-modal', name: 'view-add-truck');
    }

    
    public function render()
    {
        return view('livewire.trucks.index');
    }
}
