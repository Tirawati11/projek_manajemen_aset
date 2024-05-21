@extends('layouts.main')

@section('content')
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
<style>
    .card-header-action {
        padding: 4.8px, 12.8px; /* Gunakan titik (.) sebagai penghubung antara property dan nilai */
    }
</style>
<section class="section">
    <div class="section-header">
        <h1 class="section-title" style="font-family: 'Roboto', sans-serif; color: #333;">Aset</h1>
        <form action="" method="GET" class="form-inline ml-auto">
            <div class="input-group">
                <input class="form-control" type="search" name="search" placeholder="Search" aria-label="Search" value="{{ $search ?? '' }}">
                <div class="input-group-btn">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header-action">
                    <a href="{{ route('pengajuan.create') }}" class="btn btn-primary">Tambah Pengajuan</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Nama Pemohon</th>
                                    <th>Status</th>
                                    <th>Kategori</th>
                                    <th>Jumlah</th>
                                    <th>Catatan</th>
                                    <th style= "width:300px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pengajuan as  $index => $item)
                                <tr>
                                    <td>{{ ($pengajuan->currentPage() - 1) * $pengajuan->perPage() + $index + 1 }}</td>
                                    <td class="align-middle">{{ $item->nama_barang }}</td>
                                    <td class="align-middle">{{ $item->user_id }}</td>
                                    <td class="align-middle">{{ $item->status }}</td>
                                    <td class="align-middle">{{ $item->categories->nama }}</td>
                                    <td class="align-middle">{{ $item->jumlah}}</td>
                                    <td class="align-middle">{{ $item->deskripsi}}</td>
                                    <td>
                                            <a href="{{ url('pengajuan', $item->id) }}" class="btn btn-sm btn-dark">
                                            <i class="far fa-eye"></i>
                                            LIHAT
                                        </a>
                                        <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('pengajuan.destroy', $item->id) }}" method="POST" class="d-inline">
                                            <a href="{{ route('pengajuan.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                                EDIT
                                            </a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash-alt"></i>
                                                HAPUS
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada pengajuan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $pengajuan->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    //message with toastr
    @if(session()->has('success'))
    toastr.success('{{ session('success') }}', 'BERHASIL!');
    @elseif(session()->has('error'))
    toastr.error('{{ session('error') }}', 'GAGAL!');
    @endif
</script>
@endsection

