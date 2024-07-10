@extends('layouts.main')

@section('content')
<section class="section">
    <div class="section-header">
        <h1 class="section-title">Edit Inventaris</h1>
    </div>
</section>
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card-header-action">
                <div class="card-body">
                    <form action="{{ route('aset.update',  $aset->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">KODE</label>
                                    <input type="text" class="form-control @error('kode') is-invalid @enderror" name="kode" value="{{ old('kode', $aset->kode) }}" placeholder="Masukkan kode barang">
                                    @error('kode')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">GAMBAR</label>
                                    <div class="mb-3">
                                        <img src="{{ asset('/storage/aset/'.$aset->gambar) }}" class="rounded img-thumbnail" style="width: 150px; display: block; margin-bottom: 10px;">
                                    </div>
                                    <input type="file" class="form-control @error('gambar') is-invalid @enderror" name="gambar">
                                    @error('gambar')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">NAMA BARANG</label>
                                    <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" name="nama_barang" value="{{ old('nama_barang', $aset->nama_barang) }}" placeholder="Masukkan nama barang">
                                    @error('nama_barang')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">HARGA</label>
                                    <input type="number" class="form-control @error('harga') is-invalid @enderror" name="harga" value="{{ old('harga', $aset->harga) }}" placeholder="Masukkan harga barang" step="0.01" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                    @error('harga')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">KATEGORI</label>
                                    <select class="form-control @error('category_id') is-invalid @enderror" name="category_id">
                                        <option value=""></option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $aset->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">MEREK</label>
                                    <input type="text" class="form-control @error('merek') is-invalid @enderror" name="merek" value="{{ old('merek', $aset->merek) }}" placeholder="Masukkan merek">
                                    @error('merek')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Tanggal Masuk</label>
                                    <input type="date" class="form-control @error('tanggal_masuk') is-invalid @enderror" name="tanggal_masuk" value="{{ old('tanggal_masuk', $aset->tanggal_masuk ? $aset->tanggal_masuk : '') }}" placeholder="Masukkan tanggal">
                                    @error('tanggal_masuk')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">JUMLAH</label>
                                    <input type="number" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{ old('jumlah', $aset->jumlah) }}" placeholder="Masukkan jumlah" min="1" step="1" oninput="this.value = Math.abs(this.value)">
                                    @error('jumlah')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">KONDISI</label>
                                    <input type="text" class="form-control @error('kondisi') is-invalid @enderror" name="kondisi" value="{{ old('kondisi', $aset->kondisi) }}">
                                    @error('kondisi')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">KETERANGAN</label>
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" rows="5" placeholder="Masukkan deskripsi">{{ old('deskripsi', $aset->deskripsi) }}</textarea>
                                    @error('deskripsi')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                <br>
                                <div class="d-flex justify-content-end mt-3">
                                    <a href="{{ route('aset.index') }}" class="btn btn-sm btn-danger mr-1">Kembali</a>
                                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
