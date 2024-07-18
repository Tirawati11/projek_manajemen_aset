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
                    <a href="#" class="btn btn-sm btn-primary mb-3" id="btn-tambah-kategori"><i class="fa-solid fa-circle-plus"></i> Tambah Kategori</a>
                    <div class="table-responsive">
                        <table class="table table-bordered table-md" id="table1">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">No</th>
                                    <th style="text-align: center;">Kategori</th>
                                    <th style="text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $category)
                            <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-dark btn-show" data-id="{{ $category->id }}" title="Show">
                                    <i class="far fa-eye"></i>
                                </a>
                                <a href="#" class="btn btn-sm btn-primary btn-edit" data-id="{{ $category->id }}" data-name="{{ $category->name }}" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger btn-delete" data-id="{{ $category->id }}" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Data Kategori belum tersedia.</td>
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

        // Fetch category data using AJAX
        $.ajax({
            url: '/categories/' + id + '/edit',
            type: 'GET',
            success: function(data) {
                $('#edit_nama_kategori').val(data.name);
                $('#form-edit-kategori').attr('action', '/categories/' + id);
                $('#modal-edit-kategori').modal('show');
            },
            error: function(xhr) {
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat mengambil data kategori.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });


        // Event handler untuk tombol "Show Kategori"
        $(document).on('click', '.btn-show', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            window.location.href = '/categories/' + id;
        });

    $(document).on('click', '.btn-delete', function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    var form = $(this).closest('form'); // Ambil form terdekat

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
            $.ajax({
                url: form.attr('action'), // Ambil URL dari atribut action pada form
                type: 'POST',
                data: form.serialize(), // Serialize form data untuk dikirimkan
                success: function(response) {
                    if (response.success) {
                        Swal.fire(
                            'Terhapus!',
                            response.message,
                            'success'
                        ).then(() => {
                            location.reload(); // Reload halaman setelah penghapusan berhasil
                        });
                    } else {
                        Swal.fire(
                            'Gagal!',
                            response.message,
                            'error'
                        );
                    }
                },
                error: function(xhr) {
                    Swal.fire(
                        'Gagal!',
                        'Terjadi kesalahan saat menghapus data.',
                        'error'
                    );
                }
            });
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

