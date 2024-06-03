@extends('layouts.main')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Dashboard</h1>
    </div>
    </section>
<div class="container">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="far fa-user"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total User</h4>
                    </div>
                    <div class="card-body">
                        <h5>{{ $totalUsers }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="fas fa-cubes"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Aset</h4>
                    </div>
                    <div class="card-body">
                        <h5>{{ $totalAsets }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="fas fa-box-open"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Pengajuan Barang</h4>
                    </div>
                    <div class="card-body">
                        <h5>{{ $totalPengajuanBarang }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
