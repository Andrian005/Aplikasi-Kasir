<div class="container">
    <!-- Tombol download dan print -->
    <div class="d-flex justify-content-end my-3">
        <a href="{{ route('kasir.invoice.download', $transaksi->id) }}" class="btn btn-success mr-2">
            <i class="fa fa-download"></i> Download Invoice
        </a>
        <a href="{{ route('kasir.invoice.print', $transaksi->id) }}" class="btn btn-info" target="_blank">
            <i class="fa fa-print"></i> Print Invoice
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <!-- Header Invoice -->
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h2 class="mb-0">Invoice</h2>
                    <p class="mb-1">Invoice #: {{ $transaksi->invoice }}</p>
                    <p class="mb-0">Tanggal: {{ $transaksi->created_at->format('d/m/Y') }}</p>
                </div>
                <div class="col-sm-6 text-right">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Perusahaan" class="img-fluid"
                        style="max-width:150px;">
                </div>
            </div>

            <!-- Informasi Pelanggan & Toko -->
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h5>Pelanggan</h5>
                    @if($transaksi->pelanggan)
                        <p class="mb-0"><strong>Nama:</strong> {{ $transaksi->pelanggan->nama_pelanggan }}</p>
                        <p class="mb-0"><strong>Alamat:</strong> {{ $transaksi->pelanggan->alamat ?? '-' }}</p>
                        <p class="mb-0"><strong>Telepon:</strong> {{ $transaksi->pelanggan->nomor_telepon ?? '-' }}</p>
                        <p class="mb-0"><strong>Poin Member:</strong> {{ $transaksi->pelanggan->poin_member ?? '-' }}</p>
                    @else
                        <p class="mb-0">Umum</p>
                    @endif
                </div>
                <div class="col-sm-6 text-right">
                    <h5>Toko</h5>
                    <p class="mb-0">Toko Kita Bersama</p>
                    <p class="mb-0">Alamat Toko</p>
                    <p class="mb-0">Telepon: (021) 12345678</p>
                </div>
            </div>

            <!-- Daftar Barang -->
            <div class="table-responsive mb-4">
                <table class="table table-bordered">
                    <thead class="thead-light">
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
            </div>

            <!-- Ringkasan Pembayaran -->
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <table class="table table-sm">
                        <tr>
                            <th class="text-right">Total Belanja :</th>
                            <td class="text-right">Rp {{ number_format($transaksi->total_belanja, 0, ',', '.') }}</td>
                        </tr>
                        @if($transaksi->pelanggan)
                            <tr>
                                <th class="text-right">Poin Didapat :</th>
                                <td class="text-right">Rp {{ number_format($transaksi->poin_member_didapat, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <th class="text-right">Poin Digunakan :</th>
                                <td class="text-right">Rp
                                    {{ number_format($transaksi->poin_member_digunakan, 0, ',', '.') }}</td>
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
                            <td class="text-right text-primary fw-bold">Rp
                                {{ number_format($transaksi->total_akhir, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th class="text-right">Pembayaran :</th>
                            <td class="text-right text-primary fw-bold">Rp
                                {{ number_format($transaksi->pembayaran, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th class="text-right">Kembalian :</th>
                            <td class="text-right text-primary fw-bold">Rp
                                {{ number_format($transaksi->kembalian, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
