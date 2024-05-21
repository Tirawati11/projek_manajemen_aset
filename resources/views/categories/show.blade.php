@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-10 col-lg-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Detail Kategori</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="id">ID Kategori</label>
                        <input type="text" class="form-control" id="id" name="id" value="{{ $category->id }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nama_kategori">Nama Kategori</label>
                        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="{{ $category->name }}" readonly>
                    </div>
                    <a href="{{ route('categories.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            @if(session()->has('success'))
                toastr.success('{{ session('success') }}', 'BERHASIL!');
            @elseif(session()->has('error'))
                toastr.error('{{ session('error') }}', 'GAGAL!');
            @endif
        });
    </script>
@endsection
