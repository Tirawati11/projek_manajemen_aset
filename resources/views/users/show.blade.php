@extends('layouts.main')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Detail Data User</h1>
    </div>
    </section>
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded">
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
