<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class LaporanTransaksiExport implements FromCollection, WithHeadings, WithMapping, WithEvents, WithCustomStartCell, ShouldAutoSize, WithStyles, WithColumnFormatting
{
    protected $dateRange;

    public function __construct($dateRange = null)
    {
        $this->dateRange = $dateRange;
    }

    public function collection()
    {
        $query = Transaksi::with(['detailTransaksi', 'pelanggan.typePelanggan']);

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
        return [
            $transaksi->created_by,
            $transaksi->created_at ? $transaksi->created_at->format('d/m/Y H:i:s') : '',
            $transaksi->pelanggan->nama_pelanggan ?? 'Umum',
            $transaksi->pelanggan->typePelanggan->type ?? '-',
            $transaksi->total_belanja,
            $transaksi->diskon,
            $transaksi->poin_member_digunakan,
            $transaksi->total_akhir,
        ];
    }

    /**
     * Karena terdapat 4 baris header (3 baris untuk judul & periode, 1 baris kosong),
     * header tabel akan mulai dari baris 5.
     */
    public function startCell(): string
    {
        return 'A5';
    }

    public function registerEvents(): array
    {
        // Tentukan teks periode berdasarkan nilai $dateRange
        $periodeText = "Periode Transaksi: Semua Periode";
        if ($this->dateRange) {
            $startDate = date('d/m/Y', strtotime($this->dateRange[0]));
            $endDate = date('d/m/Y', strtotime($this->dateRange[1]));
            $periodeText = "Periode Transaksi: $startDate - $endDate";
        }

        return [
            AfterSheet::class => function (AfterSheet $event) use ($periodeText) {
                $sheet = $event->sheet->getDelegate();

                // Baris 1: Nama Toko
                $sheet->mergeCells('A1:H1');
                $sheet->setCellValue('A1', 'Toko Kita Bersama');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold'  => true,
                        'size'  => 20,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                    ],
                    'fill' => [
                        'fillType'   => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '4F81BD'],
                    ],
                ]);

                // Baris 2: Judul Laporan Transaksi
                $sheet->mergeCells('A2:H2');
                $sheet->setCellValue('A2', 'Laporan Transaksi Penjualan');
                $sheet->getStyle('A2')->applyFromArray([
                    'font' => [
                        'bold'  => true,
                        'size'  => 16,
                        'color' => ['rgb' => '000000'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Baris 3: Periode Transaksi
                $sheet->mergeCells('A3:H3');
                $sheet->setCellValue('A3', $periodeText);
                $sheet->getStyle('A3')->applyFromArray([
                    'font' => [
                        'italic' => true,
                        'size'   => 12,
                        'color'  => ['rgb' => '000000'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Baris 4: Kosong sebagai spasi

                // Baris 5: Header Tabel
                $sheet->getStyle('A5:H5')->applyFromArray([
                    'font' => [
                        'bold'  => true,
                        'color' => ['rgb' => '000000'],
                    ],
                    'fill' => [
                        'fillType'   => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'D9E1F2'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color'       => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                // Freeze pane: data mulai dari baris 6 (setelah header)
                $sheet->freezePane('A6');

                // Terapkan border ke seluruh area tabel (header + data)
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                $sheet->getStyle("A5:{$highestColumn}{$highestRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color'       => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                // Set alignment untuk kolom numerik pada data (baris mulai dari 6)
                $sheet->getStyle("E6:H{$highestRow}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_RIGHT);

                // Pewarnaan bergantian untuk baris data (mulai dari baris 6)
                for ($row = 6; $row <= $highestRow; $row++) {
                    $fillColor = ($row % 2 == 0) ? 'FFFFFF' : 'F2F2F2';
                    $sheet->getStyle("A{$row}:{$highestColumn}{$row}")
                        ->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setRGB($fillColor);
                }

                // Baris Grand Total (setelah data)
                $totalRow = $highestRow + 1;
                $sheet->setCellValue("A{$totalRow}", "Grand Total");
                $sheet->mergeCells("A{$totalRow}:D{$totalRow}");
                $sheet->getStyle("A{$totalRow}:D{$totalRow}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_RIGHT);

                // Rumus Grand Total (data dari baris 6 hingga baris terakhir data)
                $sheet->setCellValue("E{$totalRow}", "=SUM(E6:E{$highestRow})");
                $sheet->setCellValue("F{$totalRow}", "=SUM(F6:F{$highestRow})");
                $sheet->setCellValue("G{$totalRow}", "=SUM(G6:G{$highestRow})");
                $sheet->setCellValue("H{$totalRow}", "=SUM(H6:H{$highestRow})");

                $sheet->getStyle("A{$totalRow}:H{$totalRow}")->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType'   => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'FFFF99'],
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color'       => ['rgb' => '000000'],
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
        // Set tinggi baris judul utama (baris 1)
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
