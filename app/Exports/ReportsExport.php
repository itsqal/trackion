<?php

namespace App\Exports;

use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReportsExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public string $search;
    public string $startDate;
    public string $endDate;

    public function __construct(string $search, string $startDate, string $endDate)
    {
        $this->search = $search;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return Report::where('user_id', Auth::id())
                ->search($this->search)
                ->when($this->startDate, function ($query) {
                    return $query->whereDate('created_at', '>=', $this->startDate);
                })
                ->when($this->endDate, function ($query) {
                    return $query->whereDate('created_at', '<=', $this->endDate);
                })
                ->get();
    }

    public function map($report): array
    {
        Carbon::setLocale('id');

        return [
            $report->plate_number,
            $report->problem_type,
            $report->report_location,
            $report->problem_description,
            Carbon::parse($report->created_at)->translatedFormat('d F Y, H.i')
        ];
    }

    public function headings(): array
    {
        return [
            'kendaraan', 'Tipe Kendala', 'lokasi', 'Deskripsi', 'Tanggal Laporan'
        ];
    }
}
