@extends('layouts.main')

@section('styles')
<style>
    .card-header-action {
        padding: 8px 12px;
    }
</style>
@endsection
@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>DATA ASET</h4>
                    <form action="{{ route('aset.index') }}" method="GET" class="form-inline ml-auto">
                        <input class="form-control search-input" type="search" name="search" placeholder="Search" aria-label="Search" value="{{ $search ?? '' }}">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <div class="card-header-action">
                    <a href="{{ route('aset.create') }}" class="btn btn-primary"><i class="fas fa-plus-square"></i> Tambah Aset</a>
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
                                    <th style="width:250px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($asets as $aset)
                                <tr>
                                    <td>{{ ($asets->currentPage() - 1) * $asets->perPage() + $loop->iteration }}</td>
                                    <td>{{ $aset->codes->first()->kode ?? 'N/A' }}</td>
                                    <td>
                                        <img src="{{ asset('/storage/aset/'.$aset->gambar) }}" class="rounded" style="width: 150px">
                                    </td>
                                    <td>{{ $aset->nama_barang }}</td>
                                    <td>{{ $aset->merek }}</td>
                                    <td>{{ $aset->years->first()->tahun ?? 'N/A' }}</td>
                                    <td>{{ $aset->jumlah }}</td>
                                    <td>
                                        <div class="d-flex justify-content-between">
                                            <div class="action-buttons">
                                                <a href="{{ route('aset.show', $aset->id) }}" class="btn btn-sm btn-dark">
                                                    <i class="far fa-eye"></i> LIHAT
                                                </a>
                                                <a href="{{ route('aset.edit', $aset->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i> EDIT
                                                </a>
                                            </div>
                                            <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('aset.destroy', $aset->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash-alt"></i> HAPUS
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
                        {{ $asets->appends(['search' => $search])->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    // message with toastr
    @if(session()->has('success'))
        toastr.success('{{ session('success') }}', 'BERHASIL!');
    @elseif(session()->has('error'))
        toastr.error('{{ session('error') }}', 'GAGAL!');
    @endif
</script>
@endsection

@endsection
