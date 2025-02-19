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
                                    placeholder="Pilih Rentang Tanggal Pembuatan">
                                <button id="resetFilter" class="btn btn-secondary">Reset</button>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-right mt-2 mt-md-0">
                            <a href="{{ route('report.laporan-barang.export-excel') }}" id="exportExcel"
                                class="btn btn-success">Export Excel</a>
                            <a href="{{ route('report.laporan-barang.export-pdf') }}" id="exportPdf"
                                class="btn btn-primary">Export PDF</a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped w-100" id="table-1">
                            <thead>
                                <tr>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Kategori</th>
                                    <!-- <th>Tanggal Pembelian</th>
                                        <th>Tanggal Kadaluarsa</th> -->
                                    <!-- <th>Stok Awal</th> -->
                                    <th>Sisa Stok</th>
                                    <!-- <th>Tanggal Dibuat</th> -->
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
                var baseUrlExcel = "{{ route('report.laporan-barang.export-excel') }}";
                var baseUrlPdf = "{{ route('report.laporan-barang.export-pdf') }}";
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
                    { data: 'kode_barang', name: 'kode_barang' },
                    { data: 'nama_barang', name: 'nama_barang' },
                    { data: 'kategori.nama_kategori', name: 'kategori.nama_kategori' },
                    // { data: 'tgl_pembelian', name: 'tgl_pembelian' },
                    // { data: 'tgl_kadaluarsa', name: 'tgl_kadaluarsa' },
                    // { data: 'stok_awal', name: 'stok_awal' },
                    { data: 'total_stok', name: 'total_stok' },
                    // {
                    //     data: 'created_at',
                    //     name: 'created_at',
                    //     render: function (data, type, row) {
                    //         return data ? moment(data).format('YYYY-MM-DD') : '';
                    //     }
                    // },
                    {
                        data: 'id', name: '_', orderable: false, searchable: false, class: 'text-right nowrap',
                        render: function (data, type, row) {
                            let html = `<div class="d-flex">`;
                            html += `<button onclick="view(${data})" class="btn btn-info btn-icon mr-2" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </button>`;
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

        function view(id) {
            $.ajax({
                url: '{{ route('report.laporan-barang.view') }}/' + id,
                success: function (response) {
                    bootbox.dialog({
                        title: 'Detail Laporan Barang',
                        message: response,
                    });
                },
                error: function (response) {
                    iziToast.error({
                        title: 'Error',
                        message: 'Gagal memuat form view laporan barang.',
                        position: 'topRight',
                        timeout: 3000,
                        transitionIn: 'fadeInUp',
                        transitionOut: 'fadeOutDown'
                    });
                }
            });
        }
    </script>
@endpush
