<table class="table">
    <tr>
        <th style="border: 0; width: 120px">Nama Pelanggan</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->nama_pelanggan }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Alamat</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->alamat }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Nomor Telepon</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->nomor_telepon }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Jenis Kelamin</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Type Pelanggan</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->typePelanggan->type }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Poin Member</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->poin_member }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Dibuat</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->created_by }}</td>
    </tr>
</table>
