<?php

namespace App\Exports;

use App\Models\MasterItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MasterItemsExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithColumnWidths,
    ShouldAutoSize,
    WithTitle
{
    public function collection()
    {
        return MasterItem::with(['kategori'])->get();
    }

    public function map($item): array
    {
        $hargaJual = $item->harga_beli + ($item->harga_beli * $item->laba / 100);

        return [
            $item->id,
            $item->kategori->nama ?? '-',
            $item->nama,
            $item->supplier,
            $item->harga_beli,
            $item->laba,
            $hargaJual,
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Kategori',
            'Nama Items',
            'Nama Supplier',
            'Harga',
            'Laba (%)',
            'Harga Jual',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style Header
        $sheet->getStyle('A1:G1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => 'solid',
                'color' => ['rgb' => '4F81BD'], // biru elegan
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => ['rgb' => 'AAAAAA'],
                ],
            ],
        ]);

        // Style seluruh isi tabel (borders dan rata tengah sebagian)
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle("A2:G{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => ['rgb' => 'DDDDDD'],
                ],
            ],
            'alignment' => [
                'vertical' => 'center',
            ],
        ]);

        // Rata kanan untuk angka
        $sheet->getStyle("E2:G{$lastRow}")
            ->getAlignment()
            ->setHorizontal('right');

        // Lebarkan tinggi baris header
        $sheet->getRowDimension(1)->setRowHeight(25);

        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 25,
            'C' => 25,
            'D' => 25,
            'E' => 15,
            'F' => 10,
            'G' => 15,
        ];
    }

    public function title(): string
    {
        return 'Data Master Items';
    }
}
