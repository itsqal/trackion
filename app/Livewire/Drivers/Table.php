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
    public $selectedDriver;

    protected $listeners = ['driverUpdated' => '$refresh'];

    // Search filter
    #[Url(history:true)]
    public string $search = '';

    public string $sortBy = 'created_at';
    public string $sortDir = 'DESC';

    // number of items per page
    public int $itemsPerPage=5;

    public function viewDriver($id)
    {
        $this->selectedDriver = Driver::findOrFail($id);

        $this->dispatch('open-modal', name: 'view-edit-driver');
    }

    public function viewDeleteDriver($id)
    {
        $this->selectedDriver = Driver::findOrFail($id);

        $this->dispatch('open-modal', name: 'view-delete-driver');
    }

    public function deleteDriver()
    {
        $driver = Driver::findOrFail($this->selectedDriver->id);
        $driver->delete();

        $this->reset('selectedDriver');
        
        $this->dispatch('driverUpdated');
        $this->dispatch('close-modal');
    }

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
        $query = Driver::where('user_id', Auth::id())
            ->search($this->search)
            ->orderBy($this->sortBy, $this->sortDir);
    
        return view('livewire.drivers.table', [
            'drivers' => $query->paginate($this->itemsPerPage),
        ]);
    }
}
