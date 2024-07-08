@extends('layouts.main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1 class="section-title">Detail Inventaris</h1>
    </div>
</section>
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <img src="{{ asset('storage/aset/'.$aset->gambar) }}" class="img-fluid rounded" style="max-width: 100%; height: auto;">
                    <hr>
                    <p>Nama Barang: {{ $aset->nama_barang }}</p>
                    <p>Kode: {{ $aset->kode }}</p>
                    <p>Merek: {{ $aset->merek }}</p>
                    <p>Kategori: {{ $aset->category->name }}</p>
                    <p>Jumlah: {{ $aset->jumlah}}</p>
                    <p>Harga:  {{ 'Rp'   . number_format($aset->harga, 2, ',', '.')}}</p>
                    <p>Tanggal masuk: {{ \Carbon\Carbon::parse($aset->tanggal_masuk)->format('d-m-Y') }}</p>
                    <p>Keterangan: {{ $aset->deskripsi }}</p>
                    <p>kondisi: {{ $aset->kondisi }}</p>
                    <div class="d-flex justify-content-end mt-3">
                        <a href="{{ route('aset.edit', $aset->id) }}" class="btn btn-sm btn-primary me-2 mr-1">Edit</a>
                        <a href="{{ route('aset.index') }}" class="btn btn-sm btn-danger">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
