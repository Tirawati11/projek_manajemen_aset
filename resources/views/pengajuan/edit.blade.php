@extends('layouts.main')

@section('content')
<section class="section">
    <div class="section-header">
        <h1 class="section-title">Edit Pengajuan Barang</h1>
    </div>
</section>
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <form action="{{route('pengajuan.update', $pengajuan->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label class="font-weight-bold">Nama Barang</label>
                            <input type="text" name="nama_barang" id="nama_barang" class="form-control" value="{{ old('nama_barang', $pengajuan->nama_barang) }}">
                        </div>
                          <div class="form-group">
                            <label class="font-weight-bold">Jumlah</label>
                            <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" step="1" oninput="this.value = Math.abs(this.value)" value="{{ old('jumlah', $pengajuan->jumlah) }}" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Stok Divisi</label>
                            <input type="number" name="stok" id="stok" class="form-control" min="1"  value="{{ old('stok', $pengajuan->stok) }}" required>
                        </div>
                            <div class="form-group">
                            <label class="font-weight-bold">Catatan</label>
                            <input type="text" name="deskripsi" id="deskripsi" class="form-control" value="{{ old('deskripsi', $pengajuan->deskripsi) }}">
                            <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-sm btn-primary me-2 mr-1">Simpan</button>
                        <a href="{{ route('pengajuan.index') }}" class="btn btn-sm btn-danger">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
