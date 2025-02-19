<div class="row">
    <div class="col-md-3 mb-3">
        <div class="border rounded">
            <div class="bg-primary text-white p-2">
                Informasi Barang
            </div>
            <table class="table mb-0">
                <tbody>
                    <tr>
                        <td><strong>Kode Barang</strong></td>
                        <td>:</td>
                        <td>{{ $model->kode_barang }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nama Barang:</strong></td>
                        <td>:</td>
                        <td>{{ $model->nama_barang }}</td>
                    </tr>
                    <tr>
                        <td><strong>Kategori:</strong></td>
                        <td>:</td>
                        <td>{{ $model->kategori->nama_kategori }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <div class="border rounded">
            <div class="bg-info text-white p-2">
                Informasi Stok & Riwayat Tambah Stok
            </div>
            <div class="p-2">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered mb-0">
                        <thead>
                            <tr>
                                <th class="text-center">Tgl Pembelian</th>
                                <th class="text-center">Tgl Kadaluarsa</th>
                                <th class="text-center">Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-light">
                                <td class="p-3 text-center text-nowrap">{{ $model->tgl_pembelian }}</td>
                                <td class="p-3 text-center text-nowrap">{{ $model->tgl_kadaluarsa }}</td>
                                <td class="p-3 text-center font-weight-bold">{{ $model->stok }}</td>
                            </tr>
                            @foreach ($model->tambahStok as $stok)
                                <tr>
                                    <td class="p-3 text-center text-nowrap">{{ $stok->tgl_pembelian }}</td>
                                    <td class="p-3 text-center text-nowrap">{{ $stok->tgl_kadaluarsa }}</td>
                                    <td class="p-3 text-center font-weight-bold">{{ $stok->jumlah_stok }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="border rounded">
            <div class="bg-success text-white p-2">
                Harga & Informasi Tambahan
            </div>
            <table class="table table-borderless mb-0">
                <tbody>
                    <tr>
                        <td><strong>HPP</strong></td>
                        <td>:</td>
                        <td>Rp. {{ number_format($model->harga_beli, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Harga Jual 1</strong></td>
                        <td>:</td>
                        <td>Rp. {{ number_format($model->harga_jual_1, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Harga Jual 2</strong></td>
                        <td>:</td>
                        <td>Rp. {{ number_format($model->harga_jual_2, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Harga Jual 3</strong></td>
                        <td>:</td>
                        <td>Rp. {{ number_format($model->harga_jual_3, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
            <hr>
            <div class="text-center">
                <h6 class="mb-2">Informasi Tambahan</h6>
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <span class="font-weight-bold">Dibuat Oleh:</span>
                    <span class="ml-2">{{ $model->created_by }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
