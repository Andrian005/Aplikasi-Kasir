@extends('layouts.main')

@section('content')
<div class="card p-4">
    <form id="formEdit" method="POST">
        @csrf
        @include('layouts.partial.validate')
        @include('list-data.diskon.form')
        <div class="text-right">
            <a href="{{ route('list-data.diskon.index') }}" class="btn btn-secondary">
                Kembali
            </a>
            <button type="button" class="btn btn-primary" onclick="update({{ $data->id }})">Update</button>
        </div>
    </form>
</div>
@endsection

@push('page_script')
    <script>
        $('#formCreate').Form();
    </script>
    <script>
        function update(id) {
            $('#formEdit .alert').remove();
            $.ajax({
                url: '{{ route('list-data.diskon.update') }}/' + id,
                type: 'POST',
                dataType: 'JSON',
                data: $('#formEdit').serialize(),
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
                    } else {
                        iziToast.error({
                            title: 'Failed',
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
                    $('#formEdit').prepend(validation(response));
                }
            })
        }
    </script>
@endpush
