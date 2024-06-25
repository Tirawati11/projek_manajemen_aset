@extends('layouts.main')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<section class="section">
    <div class="section-header">
        <h1 class="section-title" style="font-family: 'Roboto', sans-serif; color: #333;">Buat Peminjaman</h1>
    </div>
</section>
<div class="container mt-5 mb-5">
    <div class="row">
        <!-- Form 1: Informasi Peminjam -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <form action="{{ route('peminjaman.store') }}" method="POST">
                        @csrf
                        <h4 class="font-weight-bold">Informasi Peminjam</h4>
                        <div class="form-group">
                            <label class="font-weight-bold">Nama Peminjam</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama">
                            @error('nama')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Ruang</label>
                            <select class="form-control @error('location_id') is-invalid @enderror" name="location_id">
                                <option value="">Pilih Ruang</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
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

        <!-- Form 2: Informasi Barang -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <h4 class="font-weight-bold">Informasi Barang</h4>
                        <div class="form-group">
                            <label class="font-weight-bold">Nama Barang</label>
                            <select class="form-control @error('nama_barang_id') is-invalid @enderror" name="nama_barang_id">
                                <option value="">Pilih Nama Barang</option>
                                @foreach($barangs as $barang)
                                    <option value="{{ $barang->id }}">{{ $barang->nama_barang }}</option>
                                @endforeach
                            </select>
                            @error('nama_barang_id')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Jumlah</label>
                            <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" step="1" oninput="this.value = Math.abs(this.value)" value="{{ old('jumlah') }}" required>
                        </div>
                        <div class="form-group d-flex">
                            <div class="form-group mr-3 w-50">
                                <label class="font-weight-bold">Tanggal Peminjaman</label>
                                <input type="date" class="form-control @error('tanggal_peminjaman') is-invalid @enderror" name="tanggal_peminjaman" value="{{ old('tanggal_peminjaman') }}" placeholder="Masukkan tanggal peminjaman">
                                @error('tanggal_peminjaman')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group w-50">
                                <label class="font-weight-bold">Tanggal Pengembalian</label>
                                <input type="date" class="form-control @error('tanggal_pengembalian') is-invalid @enderror" name="tanggal_pengembalian" value="{{ old('tanggal_pengembalian') }}" placeholder="Masukkan tanggal pengembalian">
                                @error('tanggal_pengembalian')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" name="status">
                                <option value="dipinjam" {{ old('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                <option value="kembali" {{ old('status') == 'kembali' ? 'selected' : '' }}>Kembali</option>
                            </select>
                            @error('status')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>

<script>
    $(document).ready(function () {
        $('.select2').select2();
    });
</script>
@endsection
