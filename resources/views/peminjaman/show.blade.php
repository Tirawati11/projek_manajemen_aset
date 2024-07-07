@extends('layouts.main')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <h4 class="mb-4">Detail Peminjaman Aset</h4>
                    <hr>
                    <p class="mt-3" style="font-family: 'Roboto', sans-serif; color: #666;">
                        ID :  {{ $peminjaman->id }}
                    </p>
                    <div class="mt-3" style="font-family: 'Roboto', sans-serif; color: #666;">
                        <p>Penanggungjawab : {{ $peminjaman->user ? $peminjaman->user->nama_user : 'Tidak diketahui' }}</p>
                        <p>Nama Barang : {{ $peminjaman->barang->nama_barang }}</p>
                        <p>Jumlah : {{ $peminjaman->jumlah }}</p>
                        <p>Lokasi : {{ $peminjaman->location ? $peminjaman->location->name : 'Tidak diketahui' }}</p>
                        <p>Tanggal Peminjaman : {{ $peminjaman->tanggal_peminjaman }}</p>
                        <p>Tanggal Pengembalian : {{ $peminjaman->tanggal_pengembalian }}</p>
                        <p>Status : {{ $peminjaman->status }}</p>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <a href="{{ route('peminjaman.edit', $peminjaman->id) }}" class="btn btn-sm btn-primary me-2 mr-1">Edit</a>
                        <a href="{{ route('peminjaman.index') }}" class="btn btn-sm btn-danger">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
