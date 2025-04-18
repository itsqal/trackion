<?php

namespace App\Livewire\Drivers;

use App\Exports\DriversExport;
use App\Models\Driver;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Auth;

class Table extends Component
{
    use WithPagination;

    // Search filter
    #[Url(history:true)]
    public string $search = '';

    public string $sortBy = 'created_at';
    public string $sortDir = 'DESC';

    // number of items per page
    public int $itemsPerPage=5;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    #[On('exportDriver')]
    public function export()
    {
        return Excel::download(new DriversExport($this->search), 'pengemudi-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function render()
    {
        $query = Driver::whereHas('trucks', function ($truckQuery) {
                $truckQuery->where('user_id', Auth::id());
            })
            ->search($this->search)
            ->orderBy($this->sortBy, $this->sortDir);
    
        return view('livewire.drivers.table', [
            'drivers' => $query->paginate($this->itemsPerPage),
        ]);
    }
}
