@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-user"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Pelanggan</h4>
                    </div>
                    <div class="card-body" id="pelanggan"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="fas fa-box"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Barang</h4>
                    </div>
                    <div class="card-body" id="barang"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="fas fa-file"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Reports</h4>
                    </div>
                    <div class="card-body" id="laporan-transaksi"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-12 col-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Statistics Penjualan</h4>
                    <div class="card-header-action">
                        <a href="#" class="btn btn-primary">Week</a>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="myChart" height="182"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-12 col-sm-12">
            <div class="card">
                @if (Auth::user()->role->role == 'Administrator')
                    <div class="card-header">
                        <h4>Monitoring Stok Barang</h4>
                        <div class="card-header-action">
                            <a href="{{ route('barang.index') }}" class="btn btn-danger">View More <i
                                    class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                @endif
                <div class="card-body p-0">
                    <div class="table-responsive table-invoice">
                        <table class="table table-striped" id="table">
                            <tr>
                                <th>Kode</th>
                                <th>Nama Barang</th>
                                <th>Status</th>
                                <th>Tanggal Kadaluarsa</th>
                                <th></th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page_script')
    <script>
        $.ajax({
            url: '{{ route('dashboard.getCountPelanggan') }}',
            type: "GET",
            success: function (data) {
                $('#pelanggan').html(`${data}`);
            },
            error: function () {
                $('#pelanggan').html('<p style="color: red;">Gagal mengambil data pelanggan.</p>');
            }
        });

        $.ajax({
            url: '{{ route('dashboard.getCountBarang') }}',
            type: "GET",
            success: function (data) {
                $('#barang').html(`${data}`);
            },
            error: function () {
                $('#barang').html('<p style="color: red;">Gagal mengambil data barang.</p>');
            }
        });

        $.ajax({
            url: '{{ route('dashboard.getCountLaporanTransaksi') }}',
            type: "GET",
            success: function (data) {
                $('#laporan-transaksi').html(`${data}`);
            },
            error: function () {
                $('#laporan-transaksi').html('<p style="color: red;">Gagal mengambil data laporan transaksi.</p>');
            }
        });

        $.ajax({
            url: '{{ route('dashboard.getBarang') }}',
            type: "GET",
            success: function (data) {
                let html = $("#table");
                data.forEach(function (item) {
                    let row = `
                            <tr>
                                <td>${item.kode_barang}</td>
                                    <td>${item.nama_barang}</td>
                                    <td><span class="badge ${item.status_stok == 'Stok Menipis' ? 'badge-warning' : 'badge-danger'}">${item.status_stok}</td>
                                    <td>${item.tgl_kadaluarsa}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" onclick="detail(${item.id})">Detail</button>
                                    </td>
                            </tr>
                            `;
                    html.append(row);
                });
            },
            error: function () {
                alert("Gagal mengambil data.");
            }
        });

        function detail(id) {
            $.ajax({
                url: '{{ route('dashboard.view.barang') }}/' + id,
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

        $.ajax({
            url: "{{ route('dashboard.chart') }}",
            method: "GET",
            success: function (response) {
                let labels = response.map(item => item.hari);
                let totalPenjualan = response.map(item => parseFloat(item.total));

                var ctx = document.getElementById("myChart").getContext('2d');

                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Total Penjualan (Rp)',
                            data: totalPenjualan,
                            backgroundColor: [
                                'rgba(63,82,227,0.8)',
                                'rgba(54, 162, 235, 0.8)',
                                'rgba(75, 192, 192, 0.8)',
                                'rgba(255, 206, 86, 0.8)',
                                'rgba(255, 99, 132, 0.8)',
                                'rgba(153, 102, 255, 0.8)',
                                'rgba(255, 159, 64, 0.8)'
                            ],
                            borderColor: 'rgba(63,82,227,1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        legend: {
                            display: true
                        },
                        scales: {
                            yAxes: [{
                                gridLines: {
                                    drawBorder: false,
                                    color: '#f2f2f2',
                                },
                                ticks: {
                                    beginAtZero: true,
                                    stepSize: 100000,
                                    callback: function (value) {
                                        return 'Rp ' + value.toLocaleString('id-ID');
                                    }
                                }
                            }],
                            xAxes: [{
                                gridLines: {
                                    display: false,
                                }
                            }]
                        }
                    }
                });
            },
            error: function (error) {
                console.error("Error fetching data:", error);
            }
        });
    </script>
@endpush
