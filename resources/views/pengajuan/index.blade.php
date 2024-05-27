@extends('layouts.main')

@section('content')
<style>
    .card-header-action {
        padding: 4.8px, 12.8px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th {
        background-color: #f2f2f2;
    }
    .nowrap {
        white-space: nowrap;
    }
    /* CSS Terpisah */
.pending-status {
    background-color: yellow;
    color: #fff;
    padding: 4px 8px;
    border-radius: 4px;
}

.approved-status {
    background-color: green;
    color: #fff;
    padding: 4px 8px;
    border-radius: 4px;
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<section class="section">
    <div class="section-header">
        <h1 class="section-title" style="font-family: 'Roboto', sans-serif; color: #333;">Pengajuan Aset</h1>
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
                    <a href="{{ route('pengajuan.create') }}" class="btn btn-primary"><i class="fa-solid fa-circle-plus"></i> Tambah Pengajuan</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-md">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th class="nowrap" style="width: 150px;">Nama Barang</th>
                                    <th class="nowrap" style="width: 150px;">Nama Pemohon</th>
                                    <th style="text-align: center; width: 100px;">Status</th>
                                    <th style="width: 100px;">Jumlah</th>
                                    <th style="text-align: center; width: 150px">Catatan</th>
                                    <th style="text-align: center; width: 350px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pengajuan as  $index => $item)
                                <tr>
                                    <td class="align-middle">{{ ($pengajuan->currentPage() - 1) * $pengajuan->perPage() + $index + 1 }}</td>
                                    <td class="align-middle">{{ $item->nama_barang }}</td>
                                    <td class="align-middle">{{ $item->user_id }}</td>
                                    <td class="align-middle">
                                        <span class="{{ $item->status === 'pending' ? 'pending-status' : ($item->status === 'disetujui' ? 'approved-status' : '') }}">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                    <td class="align-middle">{{ $item->jumlah }}</td>
                                    <td class="align-middle">{{ $item->deskripsi }}</td>
                                    <td>
                                        <a href="{{ route('pengajuan.show', $item->id) }}" class="btn btn-sm btn-dark">
                                            <i class="far fa-eye"></i>
                                            SHOW
                                        </a>
                                        <a href="{{ route('pengajuan.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                            EDIT
                                        </a>
                                        <form id="delete-form-{{ $item->id }}" action="{{ route('pengajuan.destroy', $item->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger delete-confirm">
                                                <i class="fas fa-trash-alt"></i>
                                                HAPUS
                                            </button>
                                        </form>
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
</section>
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
// Session delete
    @if (session('delete'))
        Swal.fire({
            title: 'Berhasil',
            text: '{{ session('delete') }}',
            icon: 'success',
            showConfirmButton: true
        });
    @endif
// Session sukses
    @if (session('success'))
        Swal.fire({
            title: 'Berhasil',
            text: '{{ session('success') }}',
            icon: 'success',
            showConfirmButton: true
        });
    @endif
// Session update
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
