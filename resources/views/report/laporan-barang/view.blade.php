<table class="table table-bordered">
    <tbody>
        <tr>
            <th style="width: 150px;">Kode Barang</th>
            <td>{{ $model->kode_barang ?? '-' }}</td>
        </tr>
        <tr>
            <th>Nama Barang</th>
            <td>{{ $model->nama_barang ?? '-' }}</td>
        </tr>
        <tr>
            <th>Kategori</th>
            <td>{{ $model->kategori->nama_kategori ?? '-' }}</td>
        </tr>
        <tr>
            <th>Sisa Stok</th>
            <td>{{ $model->total_stok ?? '-' }}</td>
        </tr>
        <tr>
            <th>Dibuat</th>
            <td>{{ $model->created_by ?? '-' }}</td>
        </tr>
    </tbody>
</table>

<div class="table-responsive mt-3">
    <table class="table table-sm table-bordered">
        <thead>
            <tr class="bg-light text-center">
                <th>Tgl Pembelian</th>
                <th>Tgl Kadaluarsa</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">{{ $model->tgl_pembelian }}</td>
                <td class="text-center">{{ $model->tgl_kadaluarsa }}</td>
                <td class="text-center font-weight-bold">{{ $model->stok }}</td>
            </tr>
            @foreach ($model->tambahStok as $stok)
                <tr>
                    <td class="text-center">{{ $stok->tgl_pembelian }}</td>
                    <td class="text-center">{{ $stok->tgl_kadaluarsa }}</td>
                    <td class="text-center font-weight-bold">{{ $stok->jumlah_stok }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
