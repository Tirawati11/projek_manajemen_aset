@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-md-10 col-lg-10">
        <div class="card">
            <div class="card-header">
                <h4>Data Pengguna</h4>
            </div>
            <div class="card-body">
                <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Tambah Pengguna</a>
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
                                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-primary">Show</a>
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">Hapus</button>
                                        </form>
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
@endsection
