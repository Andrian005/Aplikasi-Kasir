<table class="table">
    <tr>
        <th style="border: 0; width: 120px">Nama Kasir</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->detailKasir->name ?? '-' }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Tanggal & Waktu Transaksi</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->created_at->format('d-m-Y H:i:s') }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Nama Pelanggan</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->pelanggan->nama_pelanggan ?? 'Umum' }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Type Pelanggan</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->pelanggan->typePelanggan->type ?? '-' }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Total Pembelanjaan</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">Rp. {{ number_format($model->total_belanja, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Diskon</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">Rp. {{ number_format($model->diskon, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Poin Digunakan</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">Rp. {{ number_format($model->poin_member_digunakan, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Poin Didapatkan</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">Rp. {{ number_format($model->poin_member_didapat, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">PPN</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">Rp. {{ number_format($model->ppn, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Total Akhir</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">Rp. {{ number_format($model->total_akhir, 0, ',', '.') }}</td>
    </tr>
</table>
