@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-right mb-3">
                        <a href="{{ route('barang.create') }}" class="btn btn-primary">
                            Tambah
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped w-100" id="table-1">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Kategori Barang</th>
                                    <th>Sisa Stok</th>
                                    <th>HPP</th>
                                    <th>Harga Jual 1</th>
                                    <th>Harga Jual 2</th>
                                    <th>Harga Jual 3</th>
                                    <th>Status Kadaluarsa</th>
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
                    { data: 'nama_barang', name: 'nama_barang' },
                    { data: 'kategori.nama_kategori', name: 'kategori.nama_kategori' },
                    { data: 'stok', name: 'stok' },
                    {
                        data: 'harga_beli', name: 'harga_beli',
                        render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')
                    },
                    {
                        data: 'harga_jual_1', name: 'harga_jual_1',
                        render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')
                    },
                    {
                        data: 'harga_jual_2', name: 'harga_jual_2',
                        render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')
                    },
                    {
                        data: 'harga_jual_3', name: 'harga_jual_3',
                        render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')
                    },
                    { data: 'status', name: 'status' },
                    {
                        data: 'id', name: '_', orderable: false, searchable: false, class: 'text-right nowrap',
                        render: function (data, type, row) {
                            let html;
                            html = `<button onclick="view(${data})" class="btn btn-info btn-icon mr-2" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </button>`;
                            html += `<a href="/dashboard/barang/edit/${data}" class="btn btn-warning btn-icon mr-2" title="Edit">
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
                url: '{{ route('barang.view') }}/' + id,
                success: function (response) {
                    bootbox.dialog({
                        title: 'Detail Barang',
                        message: response,
                    });
                },
                error: function (response) {
                    iziToast.error({
                        title: 'Error',
                        message: 'Gagal memuat form view barang.',
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
                        url: '{{ route('barang.delete') }}/' + id,
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
