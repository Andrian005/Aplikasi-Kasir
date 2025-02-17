<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi - Toko Kita Bersama</title>
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
            margin-top: 10px;
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
        <h2>Laporan Transaksi</h2>
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
                <th>Nama Kasir</th>
                <th>Tanggal &amp; Waktu Transaksi</th>
                <th>Nama Pelanggan</th>
                <th>Tipe Pelanggan</th>
                <th>Total Pembelanjaan</th>
                <th>Diskon</th>
                <th>Poin yang Digunakan</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksis as $transaksi)
                <tr>
                    <td style="text-align: center;">{{ $transaksi->detailKasir->name }}</td>
                    <td style="text-align: center;">
                        {{ $transaksi->created_at ? date('d/m/Y H:i:s', strtotime($transaksi->created_at)) : '-' }}
                    </td>
                    <td style="text-align: center;">{{ $transaksi->pelanggan->nama_pelanggan ?? 'Umum' }}</td>
                    <td style="text-align: center;">{{ $transaksi->pelanggan->typePelanggan->type ?? '-' }}</td>
                    <td style="text-align: center;">Rp {{ number_format($transaksi->total_belanja, 0, ',', '.') }}</td>
                    <td style="text-align: center;">Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</td>
                    <td style="text-align: center;">Rp {{ number_format($transaksi->poin_member_digunakan, 0, ',', '.') }}
                    </td>
                    <td style="text-align: center;">Rp {{ number_format($transaksi->total_akhir, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="text-align: right;">Grand Total</td>
                <td style="text-align: center;">Rp {{ number_format($transaksis->sum('total_belanja'), 0, ',', '.') }}
                </td>
                <td style="text-align: center;">Rp {{ number_format($transaksis->sum('diskon'), 0, ',', '.') }}</td>
                <td style="text-align: center;">Rp
                    {{ number_format($transaksis->sum('poin_member_digunakan'), 0, ',', '.') }}</td>
                <td style="text-align: center;">Rp {{ number_format($transaksis->sum('total_akhir'), 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>
</body>

</html>
