<?php

namespace App\Livewire\Shipments;

use App\Exports\ShipmentsExport;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;
use App\Models\Shipment;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Table extends Component
{
    use WithPagination;

    // Search filter
    #[Url(history:true)]
    public string $search = '';

    // Date filter
    #[Url(history:true)]
    public $startDate = '';
    #[Url(history:true)]
    public $endDate = '';

    public string $sortBy = 'created_at';
    public string $sortDir = 'DESC';

    // number of items per page
    public int $itemsPerPage=10;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    #[On('exportShipment')]
    public function export()
    {
        return Excel::download(new ShipmentsExport($this->search, $this->startDate, $this->endDate), 'pengiriman-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function render()
    {
        $query = Shipment::with(['truck:id,plate_number'])
            ->search($this->search)
            ->orderBy($this->sortBy, $this->sortDir);

        if (!empty($this->startDate) && !empty($this->endDate)) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        return view('livewire.shipments.table', [
            'shipments' => $query->paginate($this->itemsPerPage),
        ]);
    }
}
