@extends('layouts.main')
<style>
    .card-header-action {
        padding: 4.8px 12.8px;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .pagination {
        display: flex;
        justify-content: center;
        list-style-type: none;
        padding: 0;
    }

    .pagination li {
        margin: 0 5px;
    }

    .pagination li a {
        display: block;
        padding: 5px 10px;
        background-color: #f8f9fa;
        border: 1px solid #ccc;
        color: #333;
        text-decoration: none;
        border-radius: 3px;
    }

    .pagination li.active a {
        background-color: #007bff;
        color: #fff;
    }

    .pagination li.disabled a {
        pointer-events: none;
        cursor: not-allowed;
        background-color: #ccc;
        color: #666;
    }
     /* Style untuk input search */
     .search-input {
        width: 250px;
        max-width: 100%;
    }
</style>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>DATA ASET</h4>
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="250">
                        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                </div>
                <div class="card-header-action">
                    <a href="{{ route('aset.create') }}" class="btn btn-primary">Tambah Aset</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-md">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Gambar</th>
                                    <th>Nama Barang</th>
                                    <th>Merek</th>
                                    <th>Tahun</th>
                                    <th>Jumlah</th>
                                    <th style="width:150px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($asets as $aset)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $aset->codes->first()->kode ?? 'N/A' }}</td>
                                    <td>
                                        <img src="{{ asset('/storage/aset/'.$aset->gambar) }}" class="rounded" style="width: 150px">
                                    </td>
                                    <td>{{ $aset->nama_barang }}</td>
                                    <td>{{ $aset->merek }}</td>
                                    <td>{{ $aset->years->tahun ?? 'N/A' }}</td>
                                    <td>{{ $aset->jumlah }}</td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('aset.show', $aset->id) }}" class="btn btn-sm btn-dark">
                                                <i class="far fa-eye"></i>
                                                LIHAT
                                            </a>
                                            <a href="{{ route('aset.edit', $aset->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                                EDIT
                                            </a>
                                        </div>
                                            <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('aset.destroy', $aset->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                    HAPUS
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">Belum ada aset.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $asets->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    //message with toastr
    @if(session()->has('success'))

        toastr.success('{{ session('success') }}', 'BERHASIL!');

    @elseif(session()->has('error'))

        toastr.error('{{ session('error') }}', 'GAGAL!');

    @endif
</script>
@endsection
