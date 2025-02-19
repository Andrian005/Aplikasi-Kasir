@extends('layouts.main')

@section('content')
    <div class="card p-4">
        <form id="formCreate" method="POST">
            @csrf
            @include('layouts.partial.validate')
            @include('barang.form')
            <div class="text-right">
                <a href="{{ route('barang.index') }}" class="btn btn-secondary">
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
                url: '{{ route('barang.store') }}',
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

        $(document).ready(function () {
            $('#harga_beli').on('input', function () {
                hitungHargaJual();
            });

            function hitungHargaJual() {
                let hpp = parseFloat($('#harga_beli').val().replace(/\D/g, '')) || 0;

                if (hpp > 0) {
                    $('#harga_jual_1').val(formatRupiah(hpp * 1.1));
                    $('#harga_jual_2').val(formatRupiah(hpp * 1.2));
                    $('#harga_jual_3').val(formatRupiah(hpp * 1.3));
                } else {
                    $('#harga_jual_1, #harga_jual_2, #harga_jual_3').val('');
                }
            }

            function formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'decimal',
                    minimumFractionDigits: 0
                }).format(angka);
            }
        });
    </script>
@endpush
