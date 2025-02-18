@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                <input type="text" id="daterange" class="form-control mr-2" style="max-width: 250px;"
                                    placeholder="Pilih Rentang Tanggal">
                                <button id="resetFilter" class="btn btn-secondary">Reset</button>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-right mt-2 mt-md-0">
                            <a href="{{ route('report.laporan-transaksi.export-excel') }}" id="exportExcel"
                                class="btn btn-success">Export Excel</a>
                            <a href="{{ route('report.laporan-transaksi.export-pdf') }}" id="exportPdf"
                                class="btn btn-primary">Export PDF</a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped w-100" id="table-1">
                            <thead>
                                <tr>
                                    <th>Nama Kasir</th>
                                    <th>Tanggal &amp; Waktu Transaksi</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Tipe Pelanggan</th>
                                    <th>Total Pembelanjaan</th>
                                    <th>Diskon</th>
                                    <th>Poin yang Digunakan</th>
                                    <th>Total Akhir</th>
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
            $('#daterange').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    format: 'YYYY-MM-DD',
                    cancelLabel: 'Clear'
                }
            });

            function updateExportLink(dateRange) {
                var baseUrlExcel = "{{ route('report.laporan-transaksi.export-excel') }}";
                var baseUrlPdf = "{{ route('report.laporan-transaksi.export-pdf') }}";
                if (dateRange) {
                    $('#exportExcel').attr('href', baseUrlExcel + '?date_range=' + encodeURIComponent(dateRange));
                    $('#exportPdf').attr('href', baseUrlPdf + '?date_range=' + encodeURIComponent(dateRange));
                } else {
                    $('#exportExcel').attr('href', baseUrlExcel);
                    $('#exportPdf').attr('href', baseUrlPdf);
                }
            }

            $('#daterange').on('apply.daterangepicker', function (ev, picker) {
                var formattedDateRange = picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD');
                $(this).val(formattedDateRange);
                updateExportLink(formattedDateRange);
                dataTable.draw();
            });

            $('#daterange').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
                updateExportLink('');
                dataTable.draw();
            });

            dataTable = $('#table-1').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: {
                    url: "",
                    data: function (d) {
                        d.date_range = $('#daterange').val();
                    }
                },
                columns: [
                    {
                        data: 'nama_kasir', name: 'nama_kasir',
                        render: function (data) {
                            return data ?? '-';
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function (data, type, row) {
                            return data ? moment(data).format('DD/MM/YYYY HH:mm:ss') : '';
                        }
                    },
                    {
                        data: 'pelanggan',
                        name: 'pelanggan.nama_pelanggan',
                        render: function (data, type, row) {
                            return data && data.nama_pelanggan ? data.nama_pelanggan : 'Umum';
                        }
                    },
                    {
                        data: 'pelanggan.type_pelanggan',
                        name: 'pelanggan.type_pelanggan.type',
                        render: function (data, type, row) {
                            return data && data.type ? data.type : '-';
                        }
                    },
                    {
                        data: 'total_belanja',
                        name: 'total_belanja',
                        render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')
                    },
                    {
                        data: 'diskon',
                        name: 'diskon',
                        render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')
                    },
                    {
                        data: 'poin_member_digunakan',
                        name: 'poin_member_digunakan',
                        render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')
                    },
                    {
                        data: 'total_akhir',
                        name: 'total_akhir',
                        render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')
                    },
                    {
                        data: 'id', name: '_', orderable: false, searchable: false, class: 'text-right nowrap',
                        render: function (data, type, row) {
                            let url = `{{ route('report.laporan-transaksi.view', ':id') }}`.replace(':id', data);
                            let html = `<div class="d-flex">`;
                            html += `<a href="${url}" class="btn btn-info btn-icon mr-2" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>`;
                            if (row.role === 'Administrator') {
                                html += `<button onclick="destroy(${data})" class="btn btn-danger btn-icon mr-2" title="Hapus">
                                            <i class="far fa-trash-alt"></i>
                                        </button>`;
                            }
                            html += `</div>`;
                            return html;
                        }
                    }
                ]
            });

            $('#resetFilter').click(function () {
                $('#daterange').val('');
                updateExportLink('');
                dataTable.draw();
            });
        });

        function destroy(id) {
            alertDestroy().then((result) => {
                if (result) {
                    $.ajax({
                        url: '{{ route('report.laporan-transaksi.delete') }}/' + id,
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
                    });
                }
            });
        }
    </script>
@endpush
