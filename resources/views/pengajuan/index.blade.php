@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<section class="section">
    <div class="section-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h1 class="section-title" style="font-family: 'Roboto', sans-serif; color: #333;">Pengajuan Aset</h1>
    </div>
</section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header-action" style="display: flex; justify-content: space-between; align-items: center;">
                    <a href="{{ route('pengajuan.create') }}" class="btn btn-primary" style="margin-right: 10px;">
                        <i class="fa-solid fa-circle-plus"></i> Tambah Pengajuan
                    </a>
                    <form action="{{ route('pengajuan.index') }}" method="GET" class="form-inline">
                    <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search" value="{{ $search ?? '' }}">
                    <div class="input-group-btn">
                    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                    </div>
                    </div>
                    </form>
                </div>
                <div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                  <table class="table table-striped" id="sortable-table">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">
                                    </th>
                                    <th style="width: 50px;">No</th>
                                    <th class="nowrap" style="width: 150px;">Nama Barang</th>
                                    <th class="nowrap" style="width: 150px;">Nama Pemohon</th>
                                    <th style="text-align: center; width: 100px;">Status</th>
                                    <th style="width: 100px;">Jumlah</th>
                                    <th style="text-align: center; width: 150px;">Catatan</th>
                                    <th style="text-align: center; width: 150px;">Aksi</th>
                                </tr>
                            </thead>
                        <tbody>
                        @forelse ($pengajuan as $index => $item)
                    <tr>
                 <td class="align-middle">
                <div class="sort-handler">
                    <i class="fas fa-th"></i>
                </div>
                </td>
                <td class="align-middle">{{ ($pengajuan->currentPage() - 1) * $pengajuan->perPage() + $index + 1 }}</td>
                <td class="align-middle">{{ $item->nama_barang }}</td>
                <td class="align-middle">{{ $item->nama_pemohon}}</td>
                <td class="align-middle">
            <span class="{{ $item->status === 'pending' ? 'badge badge-warning' : ($item->status === 'approved' ? 'badge badge-success' : ($item->status === 'rejected' ? 'badge badge-danger' : '')) }}">
                {{ $item->status }}
            </span>
                </td>
                <td class="align-middle">{{ $item->jumlah }}</td>
                <td class="align-middle">{{ $item->deskripsi }}</td>
                <td>
                    <div class="btn-group" role="group">
                        @if(Auth::check() && Auth::user()->jabatan == 'admin')
                        @if ($item->status === 'pending')
                            <form id="approvalForm{{ $item->id }}" action="{{ route('pengajuan.approve', $item->id) }}" method="POST" class="d-inline mr-1">
                                @csrf
                                <button type="button" class="btn btn-primary approvalButton" data-pengajuanid="{{ $item->id }}" title="Approve">
                                    <i class="far fa-thumbs-up"></i>
                                </button>
                            </form>
                            <form id="rejectForm{{ $item->id }}" action="{{ route('pengajuan.reject', $item->id) }}" method="POST" class="d-inline mr-1">
                                @csrf
                                <button type="button" class="btn btn-danger rejectButton" data-pengajuanid="{{ $item->id }}" title="Reject">
                                    <i class="far fa-thumbs-down"></i>
                                </button>
                            </form>
                            @endif
                            @endif
                            <a href="{{ route('pengajuan.show', $item->id) }}" class="btn btn-dark mr-1" title="Show">
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('pengajuan.edit', $item->id) }}" class="btn btn-primary mr-1" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form id="delete-form-{{ $item->id }}" action="{{ route('pengajuan.destroy', $item->id) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger delete-confirm" title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                            </div>
                            </td>
                            </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Data Pengajuan belum Tersedia.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $pengajuan->appends(['search' => $search])->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).on('click', '.delete-confirm', function(e) {
        e.preventDefault();
        var form = $(this).closest('form');

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak dapat mengembalikan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    $(document).on('click', '.approvalButton', function(e) {
        e.preventDefault();
        var pengajuanId = $(this).data('pengajuanid');
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda akan menyetujui pengajuan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, setujui!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#approvalForm' + pengajuanId).submit();
            }
        });
    });

    $(document).on('click', '.rejectButton', function(e) {
        e.preventDefault();
        var pengajuanId = $(this).data('pengajuanid');
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda akan menolak pengajuan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, tolak!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#rejectForm' + pengajuanId).submit();
            }
        });
    });

    @if (session('delete'))
    Swal.fire({
        title: 'Berhasil',
        text: '{{ session('delete') }}',
        icon: 'success',
        showConfirmButton: true
    });
    @endif

    @if (session('success'))
    Swal.fire({
        title: 'Berhasil',
        text: '{{ session('success') }}',
        icon: 'success',
        showConfirmButton: true
    });
    @endif

    @if (session('update'))
    Swal.fire({
        title: 'Berhasil',
        text: 'Data berhasil diperbarui',
        icon: 'success',
        showConfirmButton: true
    });
    @endif
</script>
@endsection
