<?php

namespace App\Exports;

use App\MeterRecord;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Http\Resources\ExcelResource;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;


class MeterRecordExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
	public function headings(): array
	{
		return [
            'Tipe Meter',
            'Unit',
            'Stand Awal',
            'Stand Akhir',
            'Pemakaian',
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
        return ExcelResource::collection(MeterRecord::orderByRaw('validation asc', 'type asc')->get());
    }

    public function registerEvents(): array
    {

        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:K1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getStyle('A1:K' . (MeterRecord::count() + 1))->applyFromArray([
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
