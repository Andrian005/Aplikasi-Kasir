@extends('layouts.main')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Admin</h4>
                        </div>
                        <div class="card-body">
                            10
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="far fa-newspaper"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>News</h4>
                        </div>
                        <div class="card-body">
                            42
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="far fa-file"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Reports</h4>
                        </div>
                        <div class="card-body">
                            1,201
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-circle"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Online Users</h4>
                        </div>
                        <div class="card-body">
                            47
                        </div>
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
                    <div class="card-header">
                        <h4>Monitoring Stok Barang</h4>
                        <div class="card-header-action">
                            <a href="#" class="btn btn-danger">View More <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive table-invoice">
                            <table class="table table-striped">
                                <tr>
                                    <th>Code</th>
                                    <th>Nama Barang</th>
                                    <th>Status</th>
                                    <th>Due Date</th>
                                    <th>Action</th>
                                </tr>
                                <tr>
                                    <td><a href="#">INV-87239</a></td>
                                    <td class="font-weight-600">Mie Goreng</td>
                                    <td>
                                        <div class="badge badge-warning">Unpaid</div>
                                    </td>
                                    <td>July 19, 2018</td>
                                    <td>
                                        <a href="#" class="btn btn-primary">Detail</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection