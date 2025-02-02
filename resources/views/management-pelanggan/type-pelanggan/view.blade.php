<table class="table">
    <tr>
        <th style="border: 0; width: 120px">Type</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->type }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Keuntungan</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->persen_keuntungan }} %</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Status</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->active == 1 ? 'Aktif' : 'Non-Aktif' }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Dibuat</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->created_by }}</td>
    </tr>
</table>
