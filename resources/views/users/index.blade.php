@extends('layouts.main')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="anonymous" referrerpolicy="no-referrer" />
<section class="section">
    <div class="section-header">
        <h1>Data User</h1>
    </div>
</section>
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-header-action">
                    <button class="btn btn-primary" id="btn-tambah-user" data-toggle="modal" data-target="#modal-tambah-user">
                        <i class="fa-solid fa-circle-plus"></i> Tambah Pengguna
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-md">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama User</th>
                                <th>Email</th>
                                <th>Jabatan</th>
                                <th>Status</th>
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
                                        @elseif($user->rejected)
                                            <span class="badge badge-danger">Rejected</span>
                                        @else
                                            <span class="badge badge-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-primary btn-edit" data-id="{{ $user->id }}" data-name="{{ $user->nama_user }}" data-email="{{ $user->email }}" data-jabatan="{{ $user->jabatan }}" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="{{ $user->id }}" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                        <form id="approvalForm{{ $user->id }}" action="{{ route('users.approve', $user->id) }}" method="POST" class="d-inline mr-1">
                                            @csrf
                                            <button type="button" class="btn btn-sm btn-primary approvalButton" data-userid="{{ $user->id }}" title="Approve">
                                                <i class="far fa-thumbs-up"></i>
                                            </button>
                                        </form>
                                        <form id="rejectForm{{ $user->id }}" action="{{ route('users.reject', $user->id) }}" method="POST" class="d-inline mr-1">
                                            @csrf
                                            <button type="button" class="btn btn-sm btn-danger rejectButton" data-userid="{{ $user->id }}" title="Reject">
                                                <i class="far fa-thumbs-down"></i>
                                            </button>
                                        </form>
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

@include('users.create')
@include('users.edit')

<!-- SweetAlert CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.css">
<!-- SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Event handler untuk tombol edit
        const editButtons = document.querySelectorAll('.btn-edit');
        editButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const id = this.dataset.id;
                const name = this.dataset.name;
                const email = this.dataset.email;
                const jabatan = this.dataset.jabatan;
                const formEditUser = document.getElementById('form-edit-user');

                // Set form action URL dynamically
                formEditUser.action = `/users/${id}`;

                // Populate form fields with user data
                document.getElementById('edit_nama_user').value = name;
                document.getElementById('edit_email').value = email;
                document.getElementById('edit_jabatan').value = jabatan;

                // Show modal
                $('#modal-edit-user').modal('show');
            });
        });

       // Event handler untuk tombol approve
const approveButtons = document.querySelectorAll('.approvalButton');
approveButtons.forEach(button => {
    button.addEventListener('click', function (e) {
        e.preventDefault();
        const form = this.closest('form');
        const action = form.action;
        const formData = new FormData(form);

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda akan menyetujui pengguna ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, setujui!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(action, {
                    method: 'PUT',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': formData.get('_token'),
                    },
                }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Disetujui!', 'Pengguna telah disetujui.', 'success').then(() => {
                                // Sembunyikan tombol approve
                                form.querySelector('.approvalButton').style.display = 'none';
                                // Sembunyikan tombol reject
                                form.querySelector('.rejectButton').style.display = 'none';
                            });
                        } else {
                            Swal.fire('Error!', 'Terjadi kesalahan.', 'error');
                        }
                    });
            }
        });
    });
});

// Event handler untuk tombol reject
const rejectButtons = document.querySelectorAll('.rejectButton');
rejectButtons.forEach(button => {
    button.addEventListener('click', function (e) {
        e.preventDefault();
        const form = this.closest('form');
        const action = form.action;
        const formData = new FormData(form);

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda akan menolak pengguna ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, tolak!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(action, {
                    method: 'PUT',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': formData.get('_token'),
                    },
                }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Ditolak!', 'Pengguna telah ditolak.', 'success').then(() => {
                                // Sembunyikan tombol approve
                                form.querySelector('.approvalButton').style.display = 'none';
                                // Sembunyikan tombol reject
                                form.querySelector('.rejectButton').style.display = 'none';
                            });
                        } else {
                            Swal.fire('Error!', 'Terjadi kesalahan.', 'error');
                        }
                    });
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

        // Tampilkan SweetAlert konfirmasi penghapusan
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda akan menghapus pengguna ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(form.action, {
                    method: 'DELETE',
                    body: new FormData(form),
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Berhasil!', data.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Gagal!', data.message, 'error');
                        }
                    });
            }
        });
    });
});
</script>
@endsection
