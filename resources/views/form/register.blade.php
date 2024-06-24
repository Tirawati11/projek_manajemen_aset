@extends('form.app')
@section('content')
<style>
    .card-header {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 50px;
    }
</style>
<div class="card card-primary">
    <div class="card-header">
        <h4>REGISTER</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input id="nama_user" type="text" class="form-control @error('nama_user') is-invalid @enderror"
                    name="nama_user" value="{{ old('nama_user') }}" required>
                @error('nama_user')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                    name="email"  placeholder="example@email.com" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="password" class="control-label">Password</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password">
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="password" class="control-label">Password Confirmation</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password_confirmation">
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label class="font-weight-bold">Role</label>
                <select class="form-control @error('jabatan') is-invalid @enderror" name="jabatan">
                    <option value="">----</option>
                    <option value="admin">Admin</option>
                    <option value="user">Karyawan</option>
                    <option value="HRD">HRD</option>
                    </select>
                @error('jabatan')
                    <div class="alert alert-danger mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block">
                    Register
                </button>
            </div>
        </form>
    </div>
</div>
<div class="mt-5 text-muted text-center">
    Already have a account? <a href="{{ route('login') }}">Sign In Now</a>
</div>
@endsection
