@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-md-10 col-lg-10">
        <div class="card">
            <div class="card-header">
                <h4>Detail Pengguna</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="nama_user">Nama User</label>
                    <input type="text" class="form-control" id="nama_user" value="{{ $user->nama_user }}" readonly>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" value="{{ $user->username }}" readonly>
                </div>
                <div class="form-group">
                    <label for="jabatan">Jabatan</label>
                    <input type="text" class="form-control" id="jabatan" value="{{ $user->jabatan }}" readonly>
                </div>
                <a href="{{ route('users.index') }}" class="btn btn-danger">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
