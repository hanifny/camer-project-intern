<?php

namespace App\Exports;

use App\Meter;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Http\Resources\CamerResource;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;


class CamerExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
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
            'Tanggal Upload',
            'Tanggal Validasi',
        ];
    }

    public function collection()
    {
        return CamerResource::collection(Meter::orderBy('validasi', 'asc')->get());
    }

    public function registerEvents(): array
    {

        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:L1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getStyle('A1:L' . (Meter::count() + 1))->applyFromArray([
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
