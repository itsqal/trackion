<?php

namespace App\Exports;

use App\Models\Shipment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ShipmentsExport implements FromCollection, WithHeadings, WithMapping
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
        return Shipment::with(['truck:id,plate_number'])
                ->search($this->search)
                ->when($this->startDate, function ($query) {
                    return $query->whereDate('created_at', '>=', $this->startDate);
                })
                ->when($this->endDate, function ($query) {
                    return $query->whereDate('created_at', '<=', $this->endDate);
                })
                ->get();
    }

    public function map($shipment): array
    {
        return [
            $shipment->truck->plate_number,
            $shipment->delivery_order_price,
            $shipment->client,
            $shipment->load_type,
            $shipment->departure_waybill_number,
            $shipment->return_waybill_number,
            $shipment->departure_location,
            $shipment->final_location,
            $shipment->distance_traveled,
            ucfirst($shipment->status)
        ];
    }

    public function headings(): array
    {
        return [
            'Nomor Plat', 'Harga Pengiriman', 'Klien', 'Muatan', 'Nomor Surat Jalan (Pergi)', 'Nomor Surat Jalan (Pulang)', 
            'Lokasi Keberangkatan', 'Lokasi Tujuan', 'Jarak Tempuh', 'Status'
        ];
    }
}
