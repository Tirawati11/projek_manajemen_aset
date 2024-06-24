@extends('layouts.main')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Edit Peminjaman Barang</h1>
    </div>
</section>
<div class="container mt-5 mb-5">
    <div class="row">
        <!-- Form 1: Informasi Barang -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <h4 class="font-weight-bold">Informasi Barang</h4>
                        <div class="form-group">
                            <label class="font-weight-bold">Nama Barang</label>
                            <select class="form-control @error('nama_barang_id') is-invalid @enderror" name="nama_barang_id">
                                <option value="">Pilih Nama Barang</option>
                                @foreach($barangs as $barang)
                                    <option value="{{ $barang->id }}" {{ old('nama_barang_id', $peminjaman->nama_barang_id) == $barang->id ? 'selected' : '' }}>{{ $barang->nama_barang }}</option>
                                @endforeach
                            </select>
                            @error('nama_barang_id')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Penanggungjawab</label>
                            <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $peminjaman->nama) }}">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Jumlah</label>
                            <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" value="{{ old('jumlah', $peminjaman->jumlah) }}" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Ruang</label>
                            <select class="form-control @error('location_id') is-invalid @enderror" name="location_id">
                                <option value="">Pilih Ruang</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}" {{ old('location_id', $peminjaman->location_id) == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                                @endforeach
                            </select>
                            @error('location_id')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
            </div>
        </div>

        <!-- Form 2: Informasi Peminjaman -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <h4 class="font-weight-bold">Informasi Peminjaman</h4>
                        <div class="form-group">
                            <label class="font-weight-bold">Tanggal Peminjaman</label>
                            <input type="date" class="form-control @error('tanggal_peminjaman') is-invalid @enderror" name="tanggal_peminjaman" value="{{ old('tanggal_peminjaman', $peminjaman->tanggal_peminjaman ? \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->format('Y-m-d') : '') }}" placeholder="Masukkan tanggal peminjaman">
                            @error('tanggal_peminjaman')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Tanggal Pengembalian</label>
                            <input type="date" class="form-control @error('tanggal_pengembalian') is-invalid @enderror" name="tanggal_pengembalian" value="{{ old('tanggal_pengembalian', $peminjaman->tanggal_pengembalian ? \Carbon\Carbon::parse($peminjaman->tanggal_pengembalian)->format('Y-m-d') : '') }}" placeholder="Masukkan tanggal pengembalian">
                            @error('tanggal_pengembalian')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" name="status">
                                <option value="dipinjam" {{ old('status', $peminjaman->status) == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                <option value="kembali" {{ old('status', $peminjaman->status) == 'kembali' ? 'selected' : '' }}>Kembali</option>
                            </select>
                            @error('status')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                        <a href="{{ route('peminjaman.index') }}" class="btn btn-sm btn-danger">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
