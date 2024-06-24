@extends('layouts.main')

@section('content')
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
                <a href="#" class="btn btn-primary mb-3" id="btn-tambah-kategori">Tambah Kategori</a>
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

@include('categories.create')
@include('categories.edit')
@include('categories.show')

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
