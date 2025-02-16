<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $transaksi->invoice }}</title>
    <style>
        body {
            font-family: sans-serif;
        }

        .header,
        .footer {
            text-align: center;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 8px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .logo {
            max-height: 80px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2> Toko Kita Bersama </h2>

        <h3>Invoice</h3>
        <p>Invoice #: {{ $transaksi->invoice }}</p>
        <p>Tanggal: {{ $transaksi->created_at->format('d/m/Y') }}</p>
    </div>

    <h4>Informasi Pelanggan</h4>
    @if($transaksi->pelanggan)
        <p><strong>Nama:</strong> {{ $transaksi->pelanggan->nama_pelanggan ?? '-' }}</p>
        <p><strong>Alamat:</strong> {{ $transaksi->pelanggan->alamat ?? '-' }}</p>
        <p><strong>Telepon:</strong> +{{ $transaksi->pelanggan->nomor_telepon ?? '-' }}</p>
        <p><strong>Poin Member:</strong> {{ $transaksi->pelanggan->poin_member ?? '-' }}</p>
    @else
        <p>Umum</p>
    @endif

    <h4>Daftar Barang</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Barang</th>
                <th class="text-center">Jumlah</th>
                <th class="text-right">Harga Satuan</th>
                <th class="text-right">Sub Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi->detailTransaksi as $detail)
                <tr>
                    <td>{{ $detail->barang->nama_barang ?? 'Barang' }}</td>
                    <td class="text-center">{{ $detail->jumlah_barang }}</td>
                    <td class="text-right">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($detail->sub_total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Ringkasan Pembayaran</h4>
    <table class="table">
        <tr>
            <th class="text-right">Total Belanja :</th>
            <td class="text-right">Rp {{ number_format($transaksi->total_belanja, 0, ',', '.') }}</td>
        </tr>
        @if($transaksi->pelanggan)
            <tr>
                <th class="text-right">Poin Didapat :</th>
                <td class="text-right">Rp {{ number_format($transaksi->poin_member_didapat, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th class="text-right">Poin Digunakan :</th>
                <td class="text-right">Rp {{ number_format($transaksi->poin_member_digunakan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th class="text-right">Diskon :</th>
                <td class="text-right">Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</td>
            </tr>
        @endif
        <tr>
            <th class="text-right">PPN :</th>
            <td class="text-right">Rp {{ number_format($transaksi->ppn, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th class="text-right">Total Akhir :</th>
            <td class="text-right">Rp {{ number_format($transaksi->total_akhir, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th class="text-right">Pembayaran :</th>
            <td class="text-right">Rp {{ number_format($transaksi->pembayaran, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th class="text-right">Kembalian :</th>
            <td class="text-right">Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="footer">
        <p>Terima kasih atas kepercayaan Anda</p>
    </div>
</body>

</html>
