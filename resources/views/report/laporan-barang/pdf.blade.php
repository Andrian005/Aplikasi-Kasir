<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Barang - Toko Kita Bersama</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 15mm;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
            background: #fff;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #4CAF50;
        }

        .header .store-details h3 {
            margin: 0;
            font-size: 24px;
            color: #4CAF50;
        }

        .header .store-details p {
            margin: 5px 0;
            font-size: 14px;
        }

        h2 {
            margin: 20px 0;
            font-size: 20px;
            color: #555;
        }

        .periode {
            font-size: 14px;
            margin-top: 5px;
        }

        .exported-info {
            font-size: 12px;
            margin-top: 5px;
            color: #777;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table thead {
            background-color: #f2f2f2;
        }

        table thead th {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 12px;
            text-align: center;
        }

        table tbody td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 12px;
            text-align: center;
        }

        table tbody tr:nth-child(even) {
            background-color: #fafafa;
        }

        table tfoot td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 12px;
            text-align: center;
            font-weight: bold;
        }

        @media print {
            table {
                page-break-after: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            thead {
                display: table-header-group;
            }

            tfoot {
                display: table-footer-group;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="store-details">
            <h3>Toko Kita Bersama</h3>
            <p>Alamat Toko / Kontak</p>
        </div>
        <h2>Laporan Barang</h2>
        @if(isset($dateRange) && count($dateRange) == 2)
            <p class="periode"><strong>Periode:</strong> {{ $dateRange[0] }} s/d {{ $dateRange[1] }}</p>
        @else
            <p class="periode">Semua Periode</p>
        @endif
        <p class="exported-info">
            Dicetak oleh: {{ Auth::user()->name }} pada {{ date('d/m/Y H:i:s') }}
        </p>
    </div>

    @php
        $totalStok = 0;
    @endphp

    <table>
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Tanggal Pembelian</th>
                <th>Tanggal Kadaluarsa</th>
                <th>Sisa Stok</th>
                <th>Tanggal Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barang as $item)
                @php
                    $totalStok += $item->stok;
                @endphp
                <tr>
                    <td>{{ $item->kode_barang }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                    <td>{{ $item->tgl_pembelian ? date('d/m/Y', strtotime($item->tgl_pembelian)) : '-' }}</td>
                    <td>{{ $item->tgl_kadaluarsa ? date('d/m/Y', strtotime($item->tgl_kadaluarsa)) : '-' }}</td>
                    <td>{{ $item->stok }}</td>
                    <td>{{ $item->created_at ? date('d/m/Y', strtotime($item->created_at)) : '-' }}</td>
                </tr>

                @if($item->tambahStok->isNotEmpty())
                    @foreach($item->tambahStok as $stok)
                        @php
                            $totalStok += $stok->jumlah_stok;
                        @endphp
                        <tr>
                            <td>{{ $item->kode_barang }}</td>
                            <td>{{ $item->nama_barang }}</td>
                            <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                            <td>{{ $stok->tgl_pembelian ? date('d/m/Y', strtotime($stok->tgl_pembelian)) : '-' }}</td>
                            <td>{{ $stok->tgl_kadaluarsa ? date('d/m/Y', strtotime($stok->tgl_kadaluarsa)) : '-' }}</td>
                            <td>{{ $stok->jumlah_stok }}</td>
                            <td>{{ $item->created_at ? date('d/m/Y', strtotime($item->created_at)) : '-' }}</td>
                        </tr>
                    @endforeach
                @endif
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" style="text-align: right;">Total</td>
                <td>{{ $totalStok }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</body>

</html>
