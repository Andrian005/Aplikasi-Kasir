<form id="formCreate" method="POST">
    @csrf
    @include('layouts.partial.validate')
    @include('barang.form-stok')
    <div class="text-right">
        <button type="button" class="btn btn-secondary" onclick="bootbox.hideAll()">Batal</button>
        <button type="button" class="btn btn-primary" onclick="store({{ $model->id }})">Tambah</button>
    </div>
</form>

<script>
    $('#formCreate').Form();

    function store(id) {
        $('#formCreate .alert').remove();
        $.ajax({
            url: '{{ route('barang.storeStok') }}/' + id,
            type: 'POST',
            dataType: 'JSON',
            data: $('#formCreate').serialize(),
            success: function (response) {
                if (response.success) {
                    iziToast.success({
                        title: 'Success',
                        message: response.message,
                        position: 'topRight',
                        timeout: 3000,
                        transitionIn: 'fadeInUp',
                        transitionOut: 'fadeOutDown'
                    });
                    dataTable.ajax.reload();
                } else {
                    iziToast.error({
                        title: 'Error',
                        message: response.message,
                        position: 'topRight',
                        timeout: 3000,
                        transitionIn: 'fadeInUp',
                        transitionOut: 'fadeOutDown'
                    });
                }
                bootbox.hideAll();
            },
            error: function (error) {
                var response = JSON.parse(error.responseText);
                $('#formCreate').prepend(validation(response));
            }
        })
    }
</script>
