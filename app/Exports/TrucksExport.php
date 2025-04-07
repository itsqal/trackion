<?php

namespace App\Exports;

use App\Models\Truck;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TrucksExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public string $search;

    public function __construct(string $search)
    {
        $this->search = $search;
    }

    public function collection()
    {
        return Truck::search($this->search)
                ->get();
    }

    public function map($truck): array
    {
        return [
            $truck->plate_number,
            $truck->model,
            number_format($truck->total_distance, 0, ',', '.')
        ];
    }

    public function headings(): array
    {
        return [
            'Nomor Plat', 'Model Truk', 'Total Jarak Tempuh'
        ];
    }
}
