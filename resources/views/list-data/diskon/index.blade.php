@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="text-right mb-3">
                    <a href="{{ route('list-data.diskon.create') }}" class="btn btn-primary">
                        Tambah
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped w-100" id="table-1">
                        <thead>
                            <tr>
                                <th>Kode Diskon</th>
                                <th>Nama Diskon</th>
                                <th>Diskon</th>
                                <th>Type Pelanggan</th>
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
                    { data: 'kode_diskon', name: 'kode_diskon' },
                    { data: 'nama_diskon', name: 'nama_diskon' },
                    { data: 'diskon', name: 'diskon' },
                    { data: 'type.type', name: 'type.type' },
                    { data: 'status', name: 'status' },
                    {
                        data: 'id', name: '_', orderable: false, searchable: false, class: 'text-right nowrap',
                        render: function (data, type, row) {
                            let html;
                            html = `<button onclick="view(${data})" class="btn btn-info btn-icon mr-2" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </button>`;
                            html += `<a href="/dashboard/list-data/diskon/edit/${data}" class="btn btn-warning btn-icon mr-2" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>`;
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
                url: '{{ route('list-data.diskon.view') }}/' + id,
                success: function (response) {
                    bootbox.dialog({
                        title: 'Detail Diskon',
                        message: response
                    });
                },
                error: function () {
                    iziToast.error({
                        title: 'Error',
                        message: 'Gagal memuat view diskon.',
                        position: 'topRight',
                        timeout: 3000,
                        transitionIn: 'fadeInUp',
                        transitionOut: 'fadeOutDown'
                    });
                }
            })
        }

        function edit(id) {
            $.ajax({
                url: '{{ route('list-data.diskon.edit') }}/' + id,
                success: function (response) {
                },
                error: function () {
                    iziToast.error({
                        title: 'Error',
                        message: 'Gagal memuat form edit diskon.',
                        position: 'topRight',
                        timeout: 3000,
                        transitionIn: 'fadeInUp',
                        transitionOut: 'fadeOutDown'
                    });
                }
            })
        }

        function destroy(id) {
            alertDestroy().then((result) => {
                if (result) {
                    $.ajax({
                        url: '{{ route('list-data.diskon.delete') }}/' + id,
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
