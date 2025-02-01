<table class="table">
    <tr>
        <th style="border: 0; width: 120px">Username</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->name }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Email</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->email }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Hak Akses</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->role->role }}</td>
    </tr>
    <tr>
        <th style="border: 0; width: 120px">Dibuat</th>
        <td style="border: 0; width: 1px">:</td>
        <td style="border: 0;">{{ $model->created_by ?? '...' }}</td>
    </tr>
</table>
