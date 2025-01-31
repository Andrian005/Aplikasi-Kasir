<table class="table">
    <tr>
        <th style="border: 0; width: 120px">Kode Kategori</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->kode_kategori }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Nama Kategori</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->nama_kategori }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Status</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->active == 1 ? 'Aktif' : 'Non-Aktif' }}</td>
    </tr>
</table>
