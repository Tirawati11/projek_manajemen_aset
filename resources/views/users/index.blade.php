@extends('layouts.main')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<section class="section">
    <div class="section-header">
        <h1>Data User</h1>
    </div>
</section>
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <button class="btn btn-primary mb-3" id="btn-tambah-user" data-toggle="modal" data-target="#modal-tambah-user"> <i class="fa-solid fa-circle-plus"></i> Tambah Pengguna</button>
                    <div class="table-responsive">
                        <table class="table table-bordered table-md">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama User</th>
                                    <th>Email</th>
                                    <th>Jabatan</th>
                                    <th>Approved</th>
                                    <th>Aksi</th>
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
                                        @else
                                            <span class="badge badge-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-dark btn-show" data-id="{{ $user->id }}" data-name="{{ $user->nama_user }}" title="Show">
                                            <i class="far fa-eye"></i>
                                        </a>
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary btn-edit" data-id="{{ $user->id }}" data-name="{{ $user->nama_user }}" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="{{ $user->id }}" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                        @if(!$user->approved)
                                            <form action="{{ route('users.approve', $user->id) }}" method="POST" class="d-inline form-approve">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-primary btn-approve" title="Approve">
                                                    <i class="far fa-thumbs-up"></i>
                                                </button>
                                            </form>
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
                        {{ $users->links() }}
                    </div>
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
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Kembali</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SweetAlert CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.css">
<!-- SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Event handler untuk tombol show
    const showButtons = document.querySelectorAll('.btn-show');
    showButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const id = this.dataset.id;
            const name = this.dataset.name;
            Swal.fire({
                title: 'Detail Pengguna',
                html: `ID: ${id}<br>Nama: ${name}`,
                icon: 'info',
                confirmButtonText: 'Close'
            });
        });
    });

    // Event handler untuk tombol edit
    const editButtons = document.querySelectorAll('.btn-edit');
    editButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const id = this.dataset.id;
            const name = this.dataset.name;
            Swal.fire({
                title: 'Edit Pengguna',
                html: `ID: ${id}<br>Nama: ${name}`,
                icon: 'info',
                confirmButtonText: 'Edit',
                showCancelButton: true,
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = this.href;
                }
            });
        });
    });

    // Event handler untuk tombol hapus
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('form');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak akan dapat mengembalikan aksi ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(form.action, {
                        method: form.method,
                        body: new FormData(form),
                        headers: {
                            'Accept': 'application/json'
                        }
                    }).then(response => response.json()).then(data => {
                        if (data.success) {
                            Swal.fire('Berhasil!', data.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Gagal!', data.message, 'error');
                        }
                    }).catch(error => {
                        Swal.fire('Gagal!', 'Terjadi kesalahan.', 'error');
                    });
                }
            });
        });
    });

    // Event handler untuk tombol approve
    const approveButtons = document.querySelectorAll('.btn-approve');
    approveButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('form');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan menyetujui pengguna ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, setujui!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(form.action, {
                        method: form.method,
                        body: new FormData(form),
                        headers: {
                            'Accept': 'application/json'
                        }
                    }).then(response => response.json()).then(data => {
                        if (data.success) {
                            Swal.fire('Berhasil!', data.message,
                            'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Gagal!', data.message, 'error');
                        }
                    }).catch(error => {
                        Swal.fire('Gagal!', 'Terjadi kesalahan.', 'error');
                    });
                }
            });
        });
    });

    // Event handler untuk tombol detail
    const detailButtons = document.querySelectorAll('.btn-detail');
    detailButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const id = this.dataset.id;
            const name = this.dataset.name;
            Swal.fire({
                title: 'Detail Pengguna',
                html: `ID: ${id}<br>Nama: ${name}`,
                icon: 'info',
                confirmButtonText: 'Close'
            });
        });
    });
});
</script>
@endsection
