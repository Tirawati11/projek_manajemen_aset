@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<section class="section">
<div class="section-header">
    <h1>Data Kategori</h1>
</div>
</section>
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                <a href="#" class="btn btn-primary mb-3" id="btn-tambah-kategori"><i class="fa-solid fa-circle-plus"></i> Tambah Kategori</a>
                <div class="table-responsive">
                    <table class="table table-bordered table-md">
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
                                        <a href="#" class="btn btn-sm btn-dark btn-show" data-id="{{ $category->id }}" data-name="{{ $category->name }}" title="Show">
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
                                    <td colspan="3" class="text-center">
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
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
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
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal Show Kategori --}}
<div class="modal fade" id="modal-show-kategori" tabindex="-1" role="dialog" aria-labelledby="modal-show-kategori-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-show-kategori-title">Detail Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="show_nama_kategori">Nama Kategori</label>
                    <input type="text" class="form-control" id="show_nama_kategori" name="nama_kategori" readonly>
                </div>
                <div class="form-group">
                    <label for="show_aset_kategori">Data Aset</label>
                    <ul id="aset-list" class="list-group">
                        <!-- Data aset akan dimuat di sini -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
<!-- SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        $('#btn-tambah-kategori').click(function() {
            $('#modal-tambah-kategori').modal('show');
        });

        $('.btn-edit').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var name = $(this).data('name');
            $('#edit_nama_kategori').val(name);
            $('#form-edit-kategori').attr('action', '/categories/' + id);
            $('#modal-edit-kategori').modal('show');
        });

        $('.btn-show').click(function(e) {
            e.preventDefault();
            var name = $(this).data('name');
            $('#show_nama_kategori').val(name);
            $('#modal-show-kategori').modal('show');
        });

        $('.btn-delete').click(function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            var id = $(this).data('id');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection
