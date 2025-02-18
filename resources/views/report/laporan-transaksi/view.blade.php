@extends('layouts.main')

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-4">Detail Transaksi</h4>
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th class="text-muted" style="width: 150px;">Nama Kasir</th>
                                <td>:</td>
                                <td>{{ $model->detailKasir->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Tanggal & Waktu</th>
                                <td>:</td>
                                <td>{{ $model->created_at->format('d-m-Y H:i:s') }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Nama Pelanggan</th>
                                <td>:</td>
                                <td>{{ $model->pelanggan->nama_pelanggan ?? 'Umum' }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Tipe Pelanggan</th>
                                <td>:</td>
                                <td>{{ $model->pelanggan->typePelanggan->type ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Total Pembelanjaan</th>
                                <td>:</td>
                                <td><strong>Rp. {{ number_format($model->total_belanja, 0, ',', '.') }}</strong></td>
                            </tr>
                            <tr>
                                <th class="text-muted">Diskon</th>
                                <td>:</td>
                                <td>Rp. {{ number_format($model->diskon, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Poin Digunakan</th>
                                <td>:</td>
                                <td>Rp. {{ number_format($model->poin_member_digunakan, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Poin Didapatkan</th>
                                <td>:</td>
                                <td>Rp. {{ number_format($model->poin_member_didapat, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">PPN</th>
                                <td>:</td>
                                <td>Rp. {{ number_format($model->ppn, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Total Akhir</th>
                                <td>:</td>
                                <td><strong class="text-success">Rp.
                                        {{ number_format($model->total_akhir, 0, ',', '.') }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-6 border-start">
                    <h5 class="mb-3">Detail Barang</h5>
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Barang</th>
                                <th>Harga Barang</th>
                                <th>Jumlah Barang</th>
                                <th>Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detailTransaksi as $detail)
                                <tr>
                                    <td>{{ $detail->barang->nama_barang }}</td>
                                    <td>
                                        Rp.
                                        {{ number_format($detail->barang->getHargaByTipe($model->pelanggan->typePelanggan->type ?? 0), 0, ',', '.') }}
                                    </td>
                                    <td>{{ $detail->jumlah_barang }}</td>
                                    <td>
                                        Rp.
                                        {{ number_format($detail->sub_total, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="card-footer text-right">
                        <nav class="d-inline-block">
                            {{ $detailTransaksi->links('pagination::bootstrap-4') }}
                        </nav>
                    </div>
                </div>
            </div>

            <div class="text-right mt-4">
                <a href="{{ route('report.laporan-transaksi.index') }}" class="btn btn-secondary btn-sm">
                    Kembali
                </a>
            </div>
        </div>
    </div>
@endsection
