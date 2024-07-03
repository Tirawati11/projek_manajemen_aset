@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="anonymous" referrerpolicy="no-referrer" />

<section class="section">
    <div class="section-header">
        <h1 class="section-title" style="font-family: 'Roboto', sans-serif; color: #333;">Data User</h1>
    </div>
</section>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                <div class="card-header-action">
                    <button class="btn btn-sm btn-primary" id="btn-tambah-user" data-toggle="modal" data-target="#modal-tambah-user">
                        <i class="fa-solid fa-circle-plus"></i> Tambah Pengguna
                    </button>
                    <button class="btn btn-sm btn-danger" id="btn-import-excel" data-toggle="modal" data-target="#modal-import-excel">
                        <i class="fa-solid fa-file-import"></i> Import File
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-md">
                        <thead>
                            <tr>
                                <th style="text-align: center;">No</th>
                                <th style="text-align: center;">Nama User</th>
                                <th style="text-align: center;">Email</th>
                                <th style="text-align: center;">Jabatan</th>
                                <th style="text-align: center;">Approved</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->nama_user }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->jabatan }}</td>
                                <td>
                                    @if($user->approved)
                                        <span class="badge badge-success">Approved</span>
                                    @elseif($user->rejected)
                                        {{-- <span class="badge badge-danger">Rejected</span> --}}
                                    @else
                                        <span class="badge badge-warning">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary btn-edit" data-id="{{ $user->id }}" data-name="{{ $user->nama_user }}" data-email="{{ $user->email }}" data-jabatan="{{ $user->jabatan }}" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline form-delete" data-id="{{ $user->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger btn-delete" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    @if(!$user->approved && !$user->rejected)
                                        <form action="{{ route('users.approve', $user->id) }}" method="POST" class="d-inline form-approve" data-id="{{ $user->id }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="button" class="btn btn-sm btn-primary btn-approve" title="Approve">
                                                <i class="far fa-thumbs-up"></i>
                                            </button>
                                        </form>
                                        {{-- <form action="{{ route('users.reject', $user->id) }}" method="POST" class="d-inline form-reject" data-id="{{ $user->id }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="button" class="btn btn-sm btn-danger btn-reject" title="Reject">
                                                <i class="far fa-thumbs-down"></i>
                                            </button>
                                        </form> --}}
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Data Pengguna belum tersedia.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Pengguna -->
<div class="modal fade" id="modal-tambah-user" tabindex="-1" role="dialog" aria-labelledby="modal-tambah-user-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-tambah-user-label">Tambah Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_user">Nama User</label>
                        <input type="text" class="form-control" id="nama_user" name="nama_user" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="jabatan">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" required>
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

<!-- Modal Edit Pengguna -->
<div class="modal fade" id="modal-edit-user" tabindex="-1" role="dialog" aria-labelledby="modal-edit-user-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-edit-user-label">Edit Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-edit-user" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_nama_user">Nama User</label>
                        <input type="text" class="form-control" id="edit_nama_user" name="nama_user" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_email_user">Email</label>
                        <input type="email" class="form-control" id="edit_email_user" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_jabatan_user">Jabatan</label>
                        <input type="text" class="form-control" id="edit_jabatan_user" name="jabatan" required>
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

<!-- Modal Import Excel -->
<div class="modal fade" id="modal-import-excel" tabindex="-1" role="dialog" aria-labelledby="modal-import-excel-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-import-excel-label">Import File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="file">File (CSV, TXT, XLS, XLSX)</label>
                        <input type="file" class="form-control-file" id="file" name="file" accept=".csv, .txt, .xls, .xlsx" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js"></script>

<script>
    $(document).ready(function () {
        // Tambah User
        $('#modal-tambah-user').on('shown.bs.modal', function () {
            $('#nama_user').focus();
        });

        // Edit User
        $('.btn-edit').click(function () {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var email = $(this).data('email');
            var jabatan = $(this).data('jabatan');

            $('#edit_nama_user').val(name);
            $('#edit_email_user').val(email);
            $('#edit_jabatan_user').val(jabatan);
            $('#form-edit-user').attr('action', '/users/' + id);

            $('#modal-edit-user').modal('show');
        });

        // Delete User
    $(document).ready(function() {
        $('.btn-delete').click(function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            var id = $(this).closest('form').data('id');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
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
    });

        // Event handler untuk tombol approve
        $('.btn-approve').click(function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Apakah Anda ingin menyetujui pengguna ini?",
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

       // Handling for successful or failed operations
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
        // // Event handler untuk tombol reject
        // $('.btn-reject').click(function(e) {
        //     e.preventDefault();
        //     var form = $(this).closest('form');
        //     Swal.fire({
        //         title: 'Apakah Anda yakin?',
        //         text: "Apakah Anda ingin menolak pengguna ini?",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Ya, tolak!'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             form.submit();
        //         }
        //     });
        // });
</script>
@endsection
