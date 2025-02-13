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
                                <th>Username</th>
                                <th>Email</th>
                                <th>Hak Akses</th>
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
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'role.role', name: 'role.role' },
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
                url: '{{ route('user-management.user.view') }}/' + id,
                success: function (response) {
                    bootbox.dialog({
                        title: 'Detail User',
                        message: response,
                    });
                },
                error: function (response) {
                    iziToast.error({
                        title: 'Error',
                        message: 'Gagal memuat form view user.',
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
                url: '{{ route('user-management.user.create') }}',
                success: function (response) {
                    bootbox.dialog({
                        title: 'Tambah User',
                        message: response,
                    });
                },
                error: function (response) {
                    iziToast.error({
                        title: 'Error',
                        message: 'Gagal memuat form tambah user.',
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
                url: '{{ route('user-management.user.store') }}',
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

        function edit(id) {
            $.ajax({
                url: '{{ route('user-management.user.edit') }}/' + id,
                success: function (response) {
                    bootbox.dialog({
                        title: 'Edit User',
                        message: response,
                    });
                },
                error: function (response) {
                    iziToast.error({
                        title: 'Error',
                        message: 'Gagal memuat form edit user.',
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
                url: '{{ route('user-management.user.update') }}/' + id,
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
                    $('#formEdit').prepend(validation(response));
                }
            })
        }

        function destroy(id) {
            alertDestroy().then((result) => {
                if (result) {
                    $.ajax({
                        url: '{{ route('user-management.user.delete') }}/' + id,
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
