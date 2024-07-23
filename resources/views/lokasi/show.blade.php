@extends('layouts.main')

@section('content')
<section class="section">
    <div class="section-header">
        <h1 class="section-title">Detail Data di Lokasi: {{ $location->name }}</h1>
    </div>
</section>
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <h3 class="mb-4" style="text-align: center;">Data Peminjaman</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered table-md">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">No</th>
                                    <th style="text-align: center;">Nama Barang</th>
                                    <th style="text-align: center;">Nama Peminjam</th>
                                    <th style="text-align: center;">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($peminjamanBarangs as $index => $peminjamanBarang)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $peminjamanBarang->barang ? $peminjamanBarang->barang->nama_barang : 'Barang tidak ditemukan' }}</td>
                                <td class="text-center">{{ $peminjamanBarang->nama_peminjam }}</td>
                                <td class="text-center">{{ $peminjamanBarang->jumlah }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data peminjaman tersedia.</td>
                            </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('lokasi.index') }}" class="btn btn-sm btn-danger">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
