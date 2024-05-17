@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-md-10 col-lg-10">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Data Kategori</h4>
                <div class="card-header-form">
                </div>
            </div>
            <div class="card-body">
                <a href="#" class="btn btn-primary mb-3" id="btn-tambah-kategori">Tambah Kategori</a>
                <div class="table-responsive">
                    <table class="table table-bordered table-md">
                        <thead>
                            <tr>
                                <th class="col-no">No</th>
                                <th class="col-id">ID</th>
                                <th class="col-name">Nama</th>
                                <th class="col-action">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <a href="{{ route('categories.show', $category) }}" class="btn btn-sm btn-primary">Show</a>
                                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <div class="alert alert-danger">
                                            Data Kategori belum Tersedia.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Kategori -->
<div class="modal fade" id="modal-tambah-kategori" tabindex="-1" role="dialog" aria-labelledby="modal-tambah-kategori-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-tambah-kategori-title">Tambah Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form tambah kategori disini -->
                <form id="form-tambah-kategori" action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nama_kategori">Nama Kategori</label>
                        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(document).ready(function() {
        // Saat tombol "Tambah Kategori" diklik, tampilkan modal
        $('#btn-tambah-kategori').click(function() {
            $('#modal-tambah-kategori').modal('show');
        });

        @if(session()->has('success'))
            toastr.success('{!! session('success') !!}', 'BERHASIL!');
        @elseif(session()->has('error'))
            toastr.error('{!! session('error') !!}', 'GAGAL!');
        @endif
    });
</script>
@endsection
