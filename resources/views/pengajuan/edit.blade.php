@extends('layouts.main')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Form  Edit Pengajuan Barang</h1>
    </div>
</section>
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <form action="{{route('pengajuan.update', $pengajuan->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label class="font-weight-bold">Nama Barang</label>
                            <input type="text" name="nama_barang" id="nama_barang" class="form-control" value="{{ old('nama_barang', $pengajuan->nama_barang) }}">
                        </div>
                        {{-- <div class="form-group">
                            <label class="font-weight-bold">KATEGORI</label>
                            <select class="form-control @error('kategori_id') is-invalid @enderror" name="kategori_id">
                                <option value="{{ $category->id }}" {{ old('kategori_id', $pengajuan->kategori_id ?? '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama }}
                                </option>
                                </select>
                            @error('kategori_id')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                            @enderror
                        </div> --}}
                        <div class="form-group">
                            <label class="font-weight-bold">Nama Pemohon</label>
                            <input type="text" name="user_id" id="user_id" class="form-control" value="{{ old('user_id', $pengajuan->user_id) }}">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Jumlah</label>
                            <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" value="{{ old('jumlah', $pengajuan->jumlah) }}" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Stok</label>
                            <input type="number" name="stok" id="stok" class="form-control" min="1"  value="{{ old('stok', $pengajuan->stok) }}" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Status</label>
                            <input type="hidden" name="status" id="status" class="form-control" min="1"  value="{{ old('status', $pengajuan->status) }}" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Catatan</label>
                            <input type="text" name="deskripsi" id="deskripsi" class="form-control" value="{{ old('deskripsi', $pengajuan->deskripsi) }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Ajukan</button>
                        <a href="{{ route('pengajuan.index') }}" class="btn btn-danger">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
