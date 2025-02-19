<?php

namespace App\Exports;

use App\Models\Transaksi;
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

class LaporanTransaksiExport implements FromCollection, WithHeadings, WithMapping, WithEvents, WithCustomStartCell, ShouldAutoSize, WithStyles, WithColumnFormatting
{
    protected $dateRange;

    public function __construct($dateRange = null)
    {
        $this->dateRange = $dateRange;
    }

    public function collection()
    {
        $user = Auth::user();
        $query = Transaksi::with(['detailTransaksi', 'pelanggan.typePelanggan', 'detailKasir'])
            ->filterByUserRole($user);

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
            'Nama Kasir',
            'Tanggal & Waktu Transaksi',
            'Nama Pelanggan',
            'Tipe Pelanggan',
            'Total Pembelanjaan',
            'Diskon',
            'Poin yang Digunakan',
            'Total Harga',
        ];
    }

    public function map($transaksi): array
    {
        $poinDigunakan = (string)($transaksi->poin_member_digunakan ?? 0);
        return [
            $transaksi->detailKasir->name ?? 'Tidak diketahui',
            $transaksi->created_at ? $transaksi->created_at->format('d/m/Y H:i:s') : '',
            $transaksi->pelanggan->nama_pelanggan ?? 'Umum',
            $transaksi->pelanggan->typePelanggan->type ?? '-',
            $transaksi->total_belanja,
            $transaksi->diskon,
            $poinDigunakan,
            $transaksi->total_akhir,
        ];
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function registerEvents(): array
    {
        $periodeText = "Periode Transaksi: Semua Periode";
        if ($this->dateRange) {
            $startDate = date('d/m/Y', strtotime($this->dateRange[0]));
            $endDate = date('d/m/Y', strtotime($this->dateRange[1]));
            $periodeText = "Periode Transaksi: $startDate - $endDate";
        }

        $printedBy = "Dicetak oleh: " . Auth::user()->name . " pada " . date('d/m/Y H:i:s');

        return [
            AfterSheet::class => function (AfterSheet $event) use ($periodeText, $printedBy) {
                $sheet = $event->sheet->getDelegate();

                $sheet->mergeCells('A1:H1');
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

                $sheet->mergeCells('A2:H2');
                $sheet->setCellValue('A2', 'Laporan Transaksi Penjualan');
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

                $sheet->mergeCells('A3:H3');
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

                $sheet->mergeCells('A4:H4');
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

                $sheet->getStyle('A5:H5')->applyFromArray([
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

                $totalRow = $highestRow + 1;
                $sheet->setCellValue("A{$totalRow}", "Grand Total");
                $sheet->mergeCells("A{$totalRow}:D{$totalRow}");
                $sheet->getStyle("A{$totalRow}:D{$totalRow}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_RIGHT);

                $sheet->setCellValue("E{$totalRow}", "=SUM(E6:E{$highestRow})");
                $sheet->setCellValue("F{$totalRow}", "=SUM(F6:F{$highestRow})");
                $sheet->setCellValue("G{$totalRow}", "=SUM(G6:G{$highestRow})");
                $sheet->setCellValue("H{$totalRow}", "=SUM(H6:H{$highestRow})");

                $sheet->getStyle("A{$totalRow}:H{$totalRow}")->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'FFFF99'],
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                $sheet->getStyle("E{$totalRow}:H{$totalRow}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_RIGHT);

                $sheet->getStyle("E{$totalRow}:H{$totalRow}")
                    ->getNumberFormat()
                    ->setFormatCode('"Rp " #,##0');
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
        return [
            'E' => '"Rp " #,##0',
            'F' => '"Rp " #,##0',
            'G' => '"Rp " #,##0',
            'H' => '"Rp " #,##0',
        ];
    }
}
