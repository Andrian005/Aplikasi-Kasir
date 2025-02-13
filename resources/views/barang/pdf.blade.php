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
        <h2>Laporan Barang</h2>
        <p class="periode">Seluruh Data Barang</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Tanggal Pembelian</th>
                <th>Tanggal Kadaluarsa</th>
                <th>HPP</th>
                <th>Harga Jual 1</th>
                <th>Harga Jual 2</th>
                <th>Harga Jual 3</th>
                <th>Stok Minimal</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barang as $barangs)
                <tr>
                    <td style="text-align: center;">{{ $barangs->kode_barang }}</td>
                    <td style="text-align: center;">{{ $barangs->nama_barang }}</td>
                    <td style="text-align: center;">{{ $barangs->kategori->nama_kategori }}</td>
                    <td style="text-align: center;">
                        {{ $barangs->tgl_pembelian ? date('d/m/Y', strtotime($barangs->tgl_pembelian)) : '-' }}</td>
                    <td style="text-align: center;">
                        {{ $barangs->tgl_kadaluarsa ? date('d/m/Y', strtotime($barangs->tgl_kadaluarsa)) : '-' }}</td>
                    <td style="text-align: center;">Rp {{ number_format($barangs->harga_beli, 0, ',', '.') }}</td>
                    <td style="text-align: center;">Rp {{ number_format($barangs->harga_jual_1, 0, ',', '.') }}</td>
                    <td style="text-align: center;">Rp {{ number_format($barangs->harga_jual_2, 0, ',', '.') }}</td>
                    <td style="text-align: center;">Rp {{ number_format($barangs->harga_jual_3, 0, ',', '.') }}</td>
                    <td style="text-align: center;">{{ $barangs->stok_minimal }}</td>
                    <td style="text-align: center;">{{ $barangs->stok }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
