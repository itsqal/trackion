<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use App\Livewire\Reports\Table;

#[\Livewire\Attributes\Title('Report')]

class Index extends Component
{
    public function exportExcel()
    {
        return $this->dispatch('exportReport')->to(Table::class);
    }

    public function render()
    {
        return view('livewire.reports.index');
    }
}
