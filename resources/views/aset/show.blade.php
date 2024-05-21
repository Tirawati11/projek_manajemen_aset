@extends('layouts.main')
@section('content')
<section class="section">
<div class="section-header">
    <h1>Detail Aset</h1>
</div>
</section>
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <img src="{{ asset('storage/aset/'.$aset->gambar) }}" class="w-100 rounded">
                    <hr>
                    <p>Nama Barang: {{ $aset->nama_barang }}</p>
                    <p>Kode: {{ $aset->codes->kode }}</p>
                    <p>Merek: {{ $aset->merek }}</p>
                    <p>Jumlah: {{ $aset->jumlah}}</p>
                    <p>Tahun: {{ $aset->years->tahun }}</p>
                    <p>Deskripsi: {{ $aset->deskripsi }}</p>
                    <p>kondisi: {{ $aset->kondisi }}</p>
                    </p>
                    </p>
                    <div>
                    <a href="{{ route('aset.index') }}" class="btn btn-danger">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection