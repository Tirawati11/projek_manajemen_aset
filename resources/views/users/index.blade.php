@extends('layouts.main')
@section('content')
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
                    <button class="btn btn-primary mb-3" id="btn-tambah-user">Tambah Pengguna</button>
                    <div class="table-responsive">
                        <table class="table table-bordered table-md">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama User</th>
                                    <th>Username</th>
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
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->jabatan }}</td>
                                        <td>{{ $user->approved ? 'Yes' : 'No' }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary btn-show-user" data-id="{{ $user->id }}">Show</button>
                                            <button class="btn btn-sm btn-warning btn-edit-user" data-id="{{ $user->id }}">Edit</button>
                                            <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $user->id }}">Hapus</button>
                                            @if(!$user->approved)
                                                <form action="{{ route('users.approve', $user->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Apakah Anda yakin ingin menyetujui pengguna ini?')">Approve</button>
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

<!-- Modal -->
<!-- Modal Tambah User -->
<div class="modal fade" id="tambahUserModal" tabindex="-1" aria-labelledby="tambahUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahUserModalLabel">Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-tambah-user" action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nama_user">Nama User</label>
                        <input type="text" class="form-control" id="nama_user" name="nama_user" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="jabatan">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Show User -->
<div class="modal fade" id="showUserModal" tabindex="-1" aria-labelledby="showUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showUserModalLabel">Detail User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="userDetail">
                <!-- Detail user akan dimuat lewat AJAX -->
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit User -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="userEditForm">
                <!-- Form edit user akan dimuat lewat AJAX -->
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(document).ready(function() {
      // AJAX untuk menampilkan detail user
$('.btn-show-user').click(function() {
    var id = $(this).data('id');
    $.get('/users/' + id, function(data) {
        $('#showUserModalLabel').text('Detail User');
        $('#userDetail').html(`
            <p>Nama: ${data.nama_user}</p>
            <p>Username: ${data.username}</p>
            <p>Jabatan: ${data.jabatan}</p>
        `);
        $('#showUserModal').modal('show');
    });
});

// AJAX untuk menampilkan form edit user
$('.btn-edit-user').click(function() {
    var id = $(this).data('id');
    $.get('/users/' + id + '/edit', function(data) {
        $('#editUserModalLabel').text('Edit User');
        $('#userEditForm').html(`
            <form id="form-edit-user" action="/users/${id}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nama_user">Nama User</label>
                    <input type="text" class="form-control" id="nama_user" name="nama_user" value="${data.nama_user}" required>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="${data.username}" required>
                </div>
                <div class="form-group">
                    <label for="jabatan">Jabatan</label>
                    <input type="text" class="form-control" id="jabatan" name="jabatan" value="${data.jabatan}" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        `);
        $('#editUserModal').modal('show');
    });
});


        // AJAX untuk menambahkan user
        $('#btn-tambah-user').click(function() {
            $('#tambahUserModal').modal('show');
        });
    });
</script>
@endsection
