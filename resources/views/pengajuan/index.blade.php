@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .dropdown-item {
        font-family: Arial, sans-serif;
        font-size: 14px;
        color: #000;
    }
    .dropdown-item i {
        font-family: FontAwesome, sans-serif;
        font-size: inherit;
        color: inherit;
    }
    .custom-control {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .custom-control-input {
        margin-top: 0.3rem;
    }
</style>
<section class="section">
    <div class="section-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h1 class="section-title" style="font-family: 'Roboto', sans-serif; color: #333;">Pengajuan Aset</h1>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header-action">
                    <a href="{{ route('pengajuan.create') }}" class="btn btn-sm btn-primary" style="margin-right: 10px;">
                        <i class="fa-solid fa-circle-plus"></i> Tambah Pengajuan
                    </a>
                    <button style="margin-bottom: 10px" class="btn btn-sm btn-danger delete_all" data-url="{{ route('pengajuan.bulk-delete') }}">
                        <i class="fas fa-trash-alt"></i> Hapus Terpilih
                    </button>
                    @csrf
                    @method('DELETE')
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table1">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        <input type="checkbox" id="master">
                                    </th>
                                    <th style="width: 50px;">No</th>
                                    <th class="nowrap" style="width: 150px;">Nama Barang</th>
                                    <th class="nowrap" style="width: 150px;">Nama Pemohon</th>
                                    <th style="text-align: center; width: 100px;">Status</th>
                                    <th style="text-align: center; width: 200px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pengajuan as $index => $item)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="sub_chk" data-id="{{ $item->id }}" name="selected_ids[]" value="{{ $item->id }}">
                                    </td>
                                    <td class="align-middle">{{ ($pengajuan->currentPage() - 1) * $pengajuan->perPage() + $index + 1 }}</td>
                                    <td class="align-middle">{{ $item->nama_barang }}</td>
                                    <td class="align-middle">
                                        @if (auth()->check())
                                            {{ auth()->user()->nama_user }}
                                        @else
                                            Pengguna Tidak Ditemukan
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="{{ $item->status === 'pending' ? 'badge badge-warning' : ($item->status === 'approved' ? 'badge badge-success' : ($item->status === 'rejected' ? 'badge badge-danger' : '')) }}">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <div class="dropdown d-inline mr-2">
                                            @if(Auth::check() && Auth::user()->jabatan == 'admin' && $item->status === 'pending')
                                            <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton{{ $item->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="far fa-thumbs-up"></i> Approve
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $item->id }}">
                                                <form id="approvalForm{{ $item->id }}" action="{{ route('pengajuan.approve', $item->id) }}" method="POST" class="dropdown-item">
                                                    @csrf
                                                    <button type="submit" class="btn btn-link text-primary approvalButton" data-pengajuanid="{{ $item->id }}" title="Approve">
                                                        <i class="far fa-thumbs-up"></i> Approve
                                                    </button>
                                                </form>
                                                <form id="rejectForm{{ $item->id }}" action="{{ route('pengajuan.reject', $item->id) }}" method="POST" class="dropdown-item">
                                                    @csrf
                                                    <button type="submit" class="btn btn-link text-danger rejectButton" data-pengajuanid="{{ $item->id }}" title="Reject">
                                                        <i class="far fa-thumbs-down"></i> Reject
                                                    </button>
                                                </form>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="dropdown d-inline">
                                            <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton3{{ $item->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-cogs"></i> Aksi
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3{{ $item->id }}">
                                                <a href="{{ route('pengajuan.show', $item->id) }}" class="dropdown-item">
                                                    <i class="far fa-eye"></i> Lihat
                                                </a>
                                                <a href="{{ route('pengajuan.edit', $item->id) }}" class="dropdown-item">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form id="delete-form-{{ $item->id }}" action="{{ route('pengajuan.destroy', $item->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item delete-confirm" style="cursor:pointer;">
                                                        <i class="fas fa-trash-alt"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Data Pengajuan belum Tersedia.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    $('#master').on('click', function(e) {
        if ($(this).is(':checked')) {
            $(".sub_chk").prop('checked', true);
        } else {
            $(".sub_chk").prop('checked', false);
        }
    });

    $('.delete_all').on('click', function(e) {
        var allVals = [];
        $(".sub_chk:checked").each(function() {
            allVals.push($(this).val());
        });
        if (allVals.length <= 0) {
            Swal.fire({
                icon: 'info',
                title: 'Tidak ada item yang terpilih',
                text: 'Silakan pilih item untuk dihapus',
            });
            return;
        }
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Anda akan menghapus ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("pengajuan.bulk-delete") }}',
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        ids: allVals
                    },
                    success: function(response) {
                        console.log('Success:', response);
                        Swal.fire(
                            'Terhapus!',
                            'Berhasil dihapus',
                            'success'
                        ).then(function() {
                            location.reload(); // Refresh the page
                        });
                    },

                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        Swal.fire(
                            'Error!',
                            'Gagal menghapus item',
                            'error'
                        );
                    }
                });
            }
        });
    });

    $(document).on('click', '.approvalButton', function(e) {
        e.preventDefault();
        var pengajuanId = $(this).data('pengajuanid');
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda akan menyetujui pengajuan ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, setujui',
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
            text: "Anda akan menolak pengajuan ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, tolak',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#rejectForm' + pengajuanId).submit();
            }
        });
    });

    $(document).on('click', '.delete-confirm', function(e) {
        e.preventDefault();
        var form = $(this).closest('form');

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak dapat mengembalikan ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    // Show success messages if available
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
});
</script>
@endsection
