<table class="table">
    <tr>
        <th style="border: 0; width: 120px">Kode Barang</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->kode_barang }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Nama Barang</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->nama_barang }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Kategori</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->kategori->nama_kategori }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Tanggal Pembelian</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->tgl_pembelian }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Tanggal Kadaluarsa</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->tgl_kadaluarsa }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Stok Barang</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->stok }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">HPP</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">Rp. {{ number_format( $model->harga_beli, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Harga Jual 1</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">Rp. {{ number_format( $model->harga_jual_1, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Harga Jual 2</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">Rp. {{ number_format( $model->harga_jual_2, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Harga Jual 3</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">Rp. {{ number_format( $model->harga_jual_3, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Status Kadaluarsa</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;"><div class="badge {{ $model->status == 'Masih Berlaku' ? 'badge-success' : 'badge-danger' }}">{{ $model->status }}</div></td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Dibuat</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->created_by }}</td>
    </tr>
</table>
