@extends('layouts.main')

@section('content')
<section class="section">
    <div class="section-header">
        <h1 class="section-title">Dashboard</h1>
    </div>
</section>
<div class="container">
    <div class="row">
        <!-- Kolom pertama -->
        <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="fas fa-cubes"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Inventaris</h4>
                    </div>
                    <div class="card-body">
                        <h5>{{ $totalAsets }}</h5>
                    </div>
                </div>
            </div>
        </div>
        

        <!-- Kolom kedua -->
        <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
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
        
        <!-- Kolom ketiga -->
        <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
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

        <!-- Kolom keempat -->
        <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
            <div class="card card-statistic-1">
                <div class="card-icon bg-info">
                    <i class="fas fa-hand-holding"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Peminjaman</h4>
                    </div>
                    <div class="card-body">
                        <h5>{{ $totalPeminjamanBarang }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom kelima -->
        <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Pengajuan Belum Disetujui</h4>
                    </div>
                    <div class="card-body">
                        <h5>{{ $totalPengajuanBelumDisetujui }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
