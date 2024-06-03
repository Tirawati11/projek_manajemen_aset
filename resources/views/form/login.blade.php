@extends('form.app')
@section('content')
<style>
    .card-header {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 50px;
        margin-bottom: 10px;
    }
    .card-body {
        padding: 20px;
    }
    .form-group label {
        margin-bottom: 5px;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .btn-block {
        margin-top: 10px;
    }
    .alert {
        margin-top: 10px;
    }
    .alert-custom-blue {
        background-color: rgba(0, 123, 255, 0.5); /* Warna biru transparan */
        border: 1px solid rgba(0, 123, 255, 0.5); /* Border biru transparan */
        color: #fff; /* Warna teks putih */
        padding: 15px; /* Padding default untuk alert */
        margin-bottom: 20px; /* Margin bawah untuk spasi antar elemen */
        border-radius: 4px;
    }
</style>

@if(session()->has('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if(Session::has('success'))
<div class="alert alert-custom-blue">
    {{ Session::get('success') }}
</div>
@endif

@if(session()->has('hasLoggedIn'))
<div class="alert alert-danger alert-dismissible fade show my-1" role="alert">
    Anda belum login!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="card card-primary">
    <div class="card-header">
        <h4>LOGIN</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="name@example.com" autofocus required>
                @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="password" class="control-label">Password</label>
                <div class="input-group">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                </div>
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
                    Login
                </button>
            </div>
        </form>
    </div>
</div><div class="mt-3 text-muted text-center">
    Don't have an account? <a href="{{ url('register') }}">Create now</a>
</div>
@endsection
