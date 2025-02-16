<table class="table">
    <tr>
        <th style="border: 0; width: 120px">Kode Barang</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->kode_barang ?? '-' }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Nama Barang</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->nama_barang ?? '-' }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Kategori</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->kategori->nama_kategori ?? '-' }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Stok Awal</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->stok_awal ?? '-' }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Stok Terkini</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->stok ?? '-' }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Tanggal Kadaluarsa</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->tgl_kadaluarsa ?? '-' }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">HPP</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">Rp. {{ number_format( $model->harga_beli, 0, ',', '.') ?? '-' }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Tanggal Dibuat</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->created_at->format('Y-m-d') ?? '-' }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Dibuat</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->created_by ?? '-' }}</td>
    </tr>
</table>
