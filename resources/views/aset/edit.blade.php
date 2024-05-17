@extends('layouts.main')
@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card-header-action">
                <div class="card-body">
                    <form action="{{ route('aset.update',  $aset->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label class="font-weight-bold">KODE</label>
                            <select class="form-control @error('kode') is-invalid @enderror" name="code_id">{{ old('kode', $aset->codes->kode) }}
                                <option value=""></option>
                                @foreach($codes as $code)
                                <option value="{{ $code->id }}" {{ old('code_id', $aset->code_id) == $code->id ? 'selected' : '' }}>
                                    {{ $code->kode }}
                                @endforeach
                            </select>
                            @error('kode')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">GAMBAR</label>
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
                            <label class="font-weight-bold">MEREK</label>
                            <input type="text" class="form-control @error('merek') is-invalid @enderror" name="merek" value="{{ old('merek', $aset->merek) }}" placeholder="Masukkan merek">
                            @error('merek')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">TAHUN</label>
                            <select class="form-control @error('year_id') is-invalid @enderror" name="year_id">
                                <option value="">Pilih Tahun</option>
                                @foreach($years as $year)
                                    <option value="{{ $year->id }}" {{ old('year_id', $aset->year_id) == $year->id ? 'selected' : '' }}>
                                        {{ $year->tahun }}
                                    </option>
                                @endforeach
                            </select>
                            @error('year_id')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">JUMLAH</label>
                            <input type="text" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{ old('jumlah', $aset->jumlah) }}" placeholder="Masukkan jumlah">
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
                            <label class="font-weight-bold">DESKRIPSI</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" rows="5" placeholder="Masukkan deskripsi">{{ old('deskripsi', $aset->deskripsi) }}</textarea>
                            @error('deskripsi')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-md btn-primary">SIMPAN</button>
                        <a href="{{ route('aset.index') }}" class="btn btn-danger">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
