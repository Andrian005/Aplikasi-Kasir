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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px
        }

        table thead {
            background-color: #f2f2f2;
        }

        table thead th {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 12px;
            text-align: left;
        }

        table tbody td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 12px;
        }

        table tbody tr:nth-child(even) {
            background-color: #fafafa;
        }

        table tfoot tr {
            background-color: #f9f9f9;
        }

        table tfoot tr td {
            font-weight: bold;
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
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

    <table>
        <thead>
            <tr>
                <th style="text-align: center;">Kode Barang</th>
                <th style="text-align: center;">Nama Barang</th>
                <th style="text-align: center;">Kategori</th>
                <th style="text-align: center;">Tanggal Pembelian</th>
                <th style="text-align: center;">Tanggal Kadaluarsa</th>
                <!-- <th style="text-align: center;">Stok Awal</th> -->
                <th style="text-align: center;">Sisa Stok</th>
                <th style="text-align: center;">HPP</th>
                <th style="text-align: center;">Tanggal Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barang as $barangs)
                <tr>
                    <td style="text-align: center;">{{ $barangs->kode_barang }}</td>
                    <td style="text-align: center;">{{ $barangs->nama_barang }}</td>
                    <td style="text-align: center;">{{ $barangs->kategori->nama_kategori }}</td>
                    <td style="text-align: center;">
                        {{ $barangs->tgl_pembelian ? date('d/m/Y', strtotime($barangs->tgl_pembelian)) : '-' }}
                    </td>
                    <td style="text-align: center;">
                        {{ $barangs->tgl_kadaluarsa ? date('d/m/Y', strtotime($barangs->tgl_kadaluarsa)) : '-' }}
                    </td>
                    <!-- <td style="text-align: center;">{{ $barangs->stok_awal }}</td> -->
                    <td style="text-align: center;">{{ $barangs->stok }}</td>
                    <td style="text-align: center;">Rp {{ number_format($barangs->harga_beli, 0, ',', '.') }}</td>
                    <td style="text-align: center;">
                        {{ $barangs->created_at ? date('d/m/Y', strtotime($barangs->created_at)) : '-' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
