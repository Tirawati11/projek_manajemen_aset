@extends('layouts.main')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <h4 class="mb-4" style="text-align: center;">Detail Pengajuan</h4>
                    <hr>
                    <p class="mt-3" style="font-family: 'Roboto', sans-serif; color: #666;">
                        ID :  {{ $pengajuan->id }}
                    </p>
                    <div class="mt-3" style="font-family: 'Roboto', sans-serif; color: #666;">
                        <p>Nama Pemohon : {{ $pengajuan->nama_pemohon }}</p>
                        <p>Nama Barang : {{ $pengajuan->nama_barang }}</p>
                        <p>Jumlah : {{ $pengajuan->jumlah }}</p>
                        <p>Stok Divisi : {{ $pengajuan->stok }}</p>
                        <p>Keterangan : {{ $pengajuan->deskripsi }}</p>
                    </div>
                    <div class="d-flex justify-content-start mt-3">
                        <a href="{{ route('pengajuan.edit', $pengajuan->id) }}" class="btn btn-primary">Edit</a>
                        <a href="{{ route('pengajuan.index') }}" class="btn btn-danger ml-1 mr-1">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
