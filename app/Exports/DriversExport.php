<?php

namespace App\Exports;

use App\Models\Driver;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DriversExport implements FromCollection, WithMapping, WithHeadings
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
        return Driver::where('user_id', Auth::id())
                ->search($this->search)
                ->get();
    }

    public function map($driver): array
    {
        return [
            $driver->name,
            $driver->contact_number,
        ];
    }

    public function headings(): array
    {
        return [
            'Nama', 'Nomor Kontak'
        ];
    }
}
