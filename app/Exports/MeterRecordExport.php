<?php

namespace App\Exports;

use App\MeterRecord;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Http\Resources\MeterRecordResource;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;


class MeterRecordExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
	public function headings(): array
	{
		return [
            'ID Catatan Meter',
            'ID Unit',
            'Unit',
            'Lantai',
            'Stand Awal Listrik',
            'Stand Akhir Listrik',
            'Pemakaian Listrik',
            'Stand Awal Air',
            'Stand Akhir Air',
            'Pemakaian Air',
            'Bulan Tahun',
            'Status Validasi',
            'Administrator',
            'Teknisi',
            'Gambar 1',
            'Gambar 2',
            'Tanggal Upload',
            'Tanggal Validasi',
        ];
    }

    public function collection()
    {
        return MeterRecordResource::collection(MeterRecord::orderBy('validation', 'asc')->get());
    }

    public function registerEvents(): array
    {

        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:L1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getStyle('A1:L' . (MeterRecord::count() + 1))->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            },
        ];
    }
}
