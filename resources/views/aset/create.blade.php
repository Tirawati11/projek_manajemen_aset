@extends('layouts.main')
@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card-header-action">
                <div class="card-body">
                    <form action="{{ route('aset.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="font-weight-bold">KODE</label>
                            <select class="form-control @error('kode') is-invalid @enderror" name="code_id">
                                <option value=""></option>
                                @foreach($codes as $code)
                                    <option value="{{ $code->id }}">{{ $code->kode }}</option>
                                @endforeach
                            </select>
                            @error('kode')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">KATEGORI</label>
                            <select class="form-control @error('category_id') is-invalid @enderror" name="category_id">
                                <option value=""></option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
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
                            <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" name="nama_barang" value="{{ old('nama_barang') }}" placeholder="Masukkan nama barang">
                            @error('nama_barang')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">MEREK</label>
                            <input type="text" class="form-control @error('merek') is-invalid @enderror" name="merek" value="{{ old('merek') }}" placeholder="Masukkan merek">
                            @error('merek')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">TAHUN</label>
                            <select class="form-control @error('tahun') is-invalid @enderror" name="year_id">
                                <option value=""></option>
                                @foreach($years as $year)
                                    <option value="{{ $year->id }}">{{ $year->tahun }}</option>
                                @endforeach
                            </select>
                            @error('tahun')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">JUMLAH</label>
                            <input type="number" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{ old('jumlah') }}" placeholder="Masukkan jumlah">
                            @error('jumlah')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">KONDISI</label>
                            <input type="text" class="form-control @error('kondisi') is-invalid @enderror" name="kondisi" value="{{ old('kondisi') }}">
                            @error('kondisi')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">KETERANGAN</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" rows="5" placeholder="Masukkan deskripsi"></textarea>
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

@section('scripts')
<!-- Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script>
    $(document).ready(function() {
        $('#kode_select').change(function() {
            var kode_id = $(this).val(); // Ambil ID kode yang dipilih
            if (kode_id) {
                $.ajax({
                    url: '/get-nama-barang/' + kode_id,
                    type: 'GET',
                    success: function(response) {
                        if (response && response.nama_barang) {
                            $('#nama_barang_input').val(response.nama_barang); // Update nilai input nama_barang
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText); // Tangani kesalahan jika permintaan gagal
                    }
                });
            } else {
                $('#nama_barang_input').val(''); // Kosongkan input nama_barang jika tidak ada kode yang dipilih
            }
        });
    });
    </script>
@endsection
