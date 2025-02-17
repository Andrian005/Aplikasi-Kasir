<?php

namespace App\Exports;

use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class LaporanBarangExport implements FromCollection, WithHeadings, WithMapping, WithEvents, WithCustomStartCell, ShouldAutoSize, WithStyles, WithColumnFormatting
{
    protected $dateRange;

    public function __construct($dateRange = null)
    {
        $this->dateRange = $dateRange;
    }

    public function collection()
    {
        $query = Barang::with(['kategori', 'detailTransaksi']);

        if ($dates = $this->dateRange) {
            $startDate = $dates[0];
            $endDate = $dates[1];
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Kode Barang',
            'Nama Barang',
            'Kategori',
            'Tanggal Pembelian',
            'Tanggal Kadaluarsa',
            'Stok Awal',
            'Stok Terkini',
            'HPP',
            'Tanggal Dibuat',
        ];
    }

    public function map($barang): array
    {
        return [
            $barang->kode_barang,
            $barang->nama_barang,
            $barang->kategori->nama_kategori ?? '-',
            $barang->tgl_pembelian ? date('d/m/Y', strtotime($barang->tgl_pembelian)) : '',
            $barang->tgl_kadaluarsa ? date('d/m/Y', strtotime($barang->tgl_kadaluarsa)) : '',
            $barang->stok_awal === 0 ? '0' : $barang->stok_awal,
            $barang->stok === 0 ? '0' : $barang->stok,
            $barang->harga_beli,
            $barang->created_at ? date('d/m/Y', strtotime($barang->created_at)) : '',
        ];
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function registerEvents(): array
    {
        $periodeText = "Seluruh Data Barang";

        return [
            AfterSheet::class => function (AfterSheet $event) use ($periodeText) {
                $sheet = $event->sheet->getDelegate();

                $sheet->mergeCells('A1:I1');
                $sheet->setCellValue('A1', 'Toko Kita Bersama');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 20,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '4CAF50'],
                    ],
                ]);

                $sheet->mergeCells('A2:I2');
                $sheet->setCellValue('A2', 'Laporan Data Barang');
                $sheet->getStyle('A2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 16,
                        'color' => ['rgb' => '000000'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                $sheet->mergeCells('A3:I3');
                $sheet->setCellValue('A3', $periodeText);
                $sheet->getStyle('A3')->applyFromArray([
                    'font' => [
                        'italic' => true,
                        'size' => 12,
                        'color' => ['rgb' => '000000'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                $printedBy = "Dicetak oleh: " . Auth::user()->name . " pada " . date('d/m/Y H:i:s');
                $sheet->mergeCells('A4:I4');
                $sheet->setCellValue('A4', $printedBy);
                $sheet->getStyle('A4')->applyFromArray([
                    'font' => [
                        'italic' => true,
                        'size' => 12,
                        'color' => ['rgb' => '000000'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                $sheet->getStyle('A5:I5')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => '000000'],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'C8E6C9'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                $sheet->freezePane('A6');
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();

                $sheet->getStyle("A5:{$highestColumn}{$highestRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                $sheet->getStyle("E6:H{$highestRow}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_RIGHT);

                for ($row = 6; $row <= $highestRow; $row++) {
                    $fillColor = ($row % 2 == 0) ? 'FFFFFF' : 'F2F2F2';
                    $sheet->getStyle("A{$row}:{$highestColumn}{$row}")
                        ->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setRGB($fillColor);
                }
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getRowDimension(1)->setRowHeight(30);
        return [];
    }

    public function columnFormats(): array
    {
        return ['H' => '"Rp " #,##0'];
    }
}
