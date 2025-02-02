<form id="formCreate" method="POST">
    @csrf
    @include('management-pelanggan.pelanggan.form')
    @include('layouts.partial.validate')
    <div class="text-right">
        <button type="button" class="btn btn-secondary" onclick="bootbox.hideAll()">Batal</button>
        <button type="button" class="btn btn-primary" onclick="store()">Tambah</button>
    </div>
</form>

<script>
    $('#formCreate').Form();
</script>
