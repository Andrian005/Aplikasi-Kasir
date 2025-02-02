@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="text-right mb-3">
                    <button class="btn btn-primary" onclick="create()">Tambah</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped w-100" id="table-1">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Persentase Keuntungan</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('page_script')
    <script>
        var dataTable;
        $(function () {
            dataTable = $('#table-1').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: '',
                columns: [
                    { data: 'type', name: 'type' },
                    { data: 'persen_keuntungan', name: 'persen_keuntungan' },
                    { data: 'active', name: 'active', searchable: false, orderable: false },
                    {
                        data: 'id', name: '_', orderable: false, searchable: false, class: 'text-right nowrap',
                        render: function (data, type, row) {
                            let html;
                            html = `<button onclick="view(${data})" class="btn btn-info btn-icon mr-2" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </button>`;
                            html += `<button onclick="edit(${data})" class="btn btn-warning btn-icon mr-2" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>`;
                            html += `<button onclick="destroy(${data})" class="btn btn-danger btn-icon mr-2" title="Hapus">
                                            <i class="far fa-trash-alt"></i>
                                        </button>`;
                            return html;
                        }
                    }]
            });
        });

        function view(id) {
            $.ajax({
                url: '{{ route('management-pelanggan.type-pelanggan.view') }}/' + id,
                success: function (response) {
                    bootbox.dialog({
                        title: 'Detail Type Pelanggan',
                        message: response
                    });
                },
                error: function () {
                    iziToast.error({
                        title: 'Error',
                        message: 'Gagal memuat view type pelanggan.',
                        position: 'topRight',
                        timeout: 3000,
                        transitionIn: 'fadeInUp',
                        transitionOut: 'fadeOutDown'
                    });
                }
            })
        }

        function create() {
            $.ajax({
                url: '{{ route('management-pelanggan.type-pelanggan.create') }}',
                success: function (response) {
                    bootbox.dialog({
                        title: 'Tambah Type Pelanggan',
                        message: response
                    });
                },
                error: function () {
                    iziToast.error({
                        title: 'Error',
                        message: 'Gagal memuat form tambah type pelanggan.',
                        position: 'topRight',
                        timeout: 3000,
                        transitionIn: 'fadeInUp',
                        transitionOut: 'fadeOutDown'
                    });
                }
            })
        }

        function store() {
            $('#formCreate .alert').remove();
            $.ajax({
                url: '{{ route('management-pelanggan.type-pelanggan.store') }}',
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
                    $('#formCreate').prepend(validation(response));
                }
            })
        }

        function edit(id) {
            $.ajax({
                url: '{{ route('management-pelanggan.type-pelanggan.edit') }}/' + id,
                success: function (response) {
                    bootbox.dialog({
                        title: 'Edit Type Pelanggan',
                        message: response
                    });
                },
                error: function () {
                    iziToast.error({
                        title: 'Error',
                        message: 'Gagal memuat form edit type pelanggan.',
                        position: 'topRight',
                        timeout: 3000,
                        transitionIn: 'fadeInUp',
                        transitionOut: 'fadeOutDown'
                    });
                }
            })
        }

        function update(id) {
            $('#formEdit .alert').remove();
            $.ajax({
                url: '{{ route('management-pelanggan.type-pelanggan.update') }}/' + id,
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
                        dataTable.ajax.reload();
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

        function destroy(id) {
            alertDestroy().then((result) => {
                if (result) {
                    $.ajax({
                        url: '{{ route('management-pelanggan.type-pelanggan.delete') }}/' + id,
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
                                    title: 'Failed',
                                    message: response.message,
                                    position: 'topRight',
                                    timeout: 3000,
                                    transitionIn: 'fadeInUp',
                                    transitionOut: 'fadeOutDown'
                                });
                            }
                            bootbox.hideAll();
                        }
                    })
                }
            });
        }
    </script>
@endpush
