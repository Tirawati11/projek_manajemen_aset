@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<section class="section">
    <div class="section-header">
        <h1 class="section-title">Data Kategori</h1>
    </div>
</section>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <a href="#" class="btn btn-primary mb-3" id="btn-tambah-kategori"><i class="fa-solid fa-circle-plus"></i> Tambah Kategori</a>
                    <div class="table-responsive">
                        <table class="table table-bordered table-md" id="table1">
                            <thead>
                                <tr>
                                    <th class="col-no">No</th>
                                    <th class="col-name">Kategori</th>
                                    <th class="col-action">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $category)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-dark btn-show" data-id="{{ $category->id }}" data-name="{{ $category->name }}"><i class="far fa-eye" title="Show"></i></a>
                                            <a href="#" class="btn btn-sm btn-primary btn-edit" data-id="{{ $category->id }}" data-name="{{ $category->name }}"><i class="fas fa-edit" title="Edit"></i></a>
                                            <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $category->id }}"><i class="fas fa-trash-alt" title="Hapus"></i></button>
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
</div>

    <!-- Modal Tambah Kategori -->
    <div class="modal fade" id="modal-tambah-kategori" tabindex="-1" role="dialog" aria-labelledby="modal-tambah-kategori-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-tambah-kategori-title">Tambah Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-tambah-kategori" action="{{ route('categories.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama_kategori">Nama Kategori</label>
                            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Kategori -->
    <div class="modal fade" id="modal-edit-kategori" tabindex="-1" role="dialog" aria-labelledby="modal-edit-kategori-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-edit-kategori-title">Edit Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-edit-kategori" action="" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="edit_nama_kategori">Nama Kategori</label>
                            <input type="text" class="form-control" id="edit_nama_kategori" name="nama_kategori" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Event handler untuk tombol "Tambah Kategori"
        $('#btn-tambah-kategori').click(function(e) {
            e.preventDefault(); // Hindari navigasi ke link
            $('#modal-tambah-kategori').modal('show');
        });

        // Event handler untuk tombol "Edit Kategori"
        $(document).on('click', '.btn-edit', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var name = $(this).data('name');
            $('#edit_nama_kategori').val(name);
            $('#form-edit-kategori').attr('action', '/categories/' + id);
            $('#modal-edit-kategori').modal('show');
        });

        $('.btn-show').click(function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            $('#show_nama_kategori').val(name);

            $.ajax({
                url: '/categories/' + id + '/assets',
                method: 'GET',
                success: function(data) {
                    $('#aset_list').html(data);
                    $('#modal-show-kategori').modal('show');
                }
            });
        });

        $('.btn-delete').click(function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        @if(session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                title: 'Gagal!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif
    });
</script>
@endsection
