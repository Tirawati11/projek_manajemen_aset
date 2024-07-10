@extends('layouts.main')

@section('content')
<style>

    h1, h4, {
        font-family: 'serif';
    }
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<section class="section">
    <div class="section-header">
        <h1 class="section-title">Edit Peminjaman Barang</h1>
    </div>
</section>
<div class="container mt-5 mb-5">
    <div class="row">
        <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST">
         @csrf
        @method('PUT')
         </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                        <div class="form-group">
                            <label class="font-weight-bold">Nama Barang</label>
                            <select class="form-control @error('nama_barang_id') is-invalid @enderror" name="nama_barang_id">
                                <option value="">Pilih Nama Barang</option>
                                @foreach($barangs as $barang)
                                    <option value="{{ $barang->id }}" {{ $barang->id == $peminjaman->nama_barang_id ? 'selected' : '' }}>{{ $barang->nama_barang }}</option>
                                @endforeach
                            </select>
                            @error('nama_barang_id')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Ruang</label>
                            <select class="form-control @error('location_id') is-invalid @enderror" name="location_id">
                                <option value="">Pilih Ruang</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}" {{ $location->id == $peminjaman->location_id ? 'selected' : '' }}>{{ $location->name }}</option>
                                @endforeach
                            </select>
                            @error('location_id')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Jumlah</label>
                            <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" step="1" oninput="this.value = Math.abs(this.value)" value="{{ old('jumlah', $peminjaman->jumlah) }}" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Tanggal Peminjaman</label>
                                    <input type="date" class="form-control @error('tanggal_peminjaman') is-invalid @enderror" name="tanggal_peminjaman" value="{{ old('tanggal_peminjaman', $peminjaman->tanggal_peminjaman) }}" placeholder="Masukkan tanggal peminjaman">
                                    @error('tanggal_peminjaman')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Tanggal Pengembalian</label>
                                    <input type="date" class="form-control @error('tanggal_pengembalian') is-invalid @enderror" name="tanggal_pengembalian" value="{{ old('tanggal_pengembalian', $peminjaman->tanggal_pengembalian) }}" placeholder="Masukkan tanggal pengembalian">
                                    @error('tanggal_pengembalian')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" name="status">
                                <option value="dipinjam" {{ old('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                <option value="kembali" {{ old('status') == 'kembali' ? 'selected' : '' }}>Kembali</option>
                            </select>
                            @error('status')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ route('peminjaman.index') }}" class="btn btn-sm btn-danger mr-1">Kembali</a>
                            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                    </form>
                </div>
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

        // Tambahan script untuk mengaktifkan Select2 setelah konten di-load
        $(document).ajaxComplete(function () {
            $('.select2').select2();
        });
    });
</script>
@endsection
