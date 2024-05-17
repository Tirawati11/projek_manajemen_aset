<!DOCTYPE html>
@extends('layouts.main')

@section('content')
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Kategori - Kategori</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
    <body style="background: lightgray">

<div class="container">
    <h1>Create New Category</h1>
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Category</button>
    </form>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(document).ready(function() {
        // Saat tombol "Tambah Kategori" diklik, tampilkan modal
        $('#btn-tambah-kategori').click(function() {
            $('#modal-tambah-kategori').modal('show');
        });

        @if(session()->has('success'))
            toastr.success('{!! session('success') !!}', 'BERHASIL!');
        @elseif(session()->has('error'))
            toastr.error('{!! session('error') !!}', 'GAGAL!');
        @endif
    });
</script>
@endsection