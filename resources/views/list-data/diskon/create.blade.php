@extends('layouts.main')

@section('content')
<div class="card p-4">
    <form id="formCreate" method="POST">
        @csrf
        @include('layouts.partial.validate')
        @include('list-data.diskon.form')
        <div class="text-right">
            <a href="{{ route('list-data.diskon.index') }}" class="btn btn-secondary">
                Kembali
            </a>
            <button type="button" class="btn btn-primary" onclick="store()">Tambah</button>
        </div>
    </form>
</div>
@endsection

@push('page_script')
    <script>
        $('#formCreate').Form();
    </script>
    <script>
        function store() {
            $('#formCreate .alert').remove();
            $.ajax({
                url: '{{ route('list-data.diskon.store') }}',
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
@endpush
