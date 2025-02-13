<table class="table">
    <tr>
        <th style="border: 0; width: 120px">Kode Diskon</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->kode_diskon }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Nama Diskon</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->nama_diskon }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Minimal Diskon</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">Rp. {{ number_format($model->min_diskon, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Maximal Diskon</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">Rp. {{ number_format($model->max_diskon, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Persen Diskon</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->diskon }}%</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Type Pelanggan</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->type->type }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Tanggal Mulai</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->tgl_mulai }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Tanggal Berakhir</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->tgl_berakhir }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Status</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;"><div class="badge {{ $model->status == 'Masih Berlaku' ? 'badge-success' : 'badge-danger' }}">{{ $model->status }}</div></td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Dibuat</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->created_by }}</td>
    </tr>
</table>
