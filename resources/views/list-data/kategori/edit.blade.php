<form id="formEdit" method="POST">
    @csrf
    @include('list-data.kategori.form')
    @include('layouts.partial.validate')
    <div class="text-right">
        <button type="button" class="btn btn-secondary" onclick="bootbox.hideAll()">Batal</button>
        <button type="button" class="btn btn-primary" onclick="update({{ $data->id }})">Update</button>
    </div>
</form>

<script>
    $('#formEdit').Form();
</script>
