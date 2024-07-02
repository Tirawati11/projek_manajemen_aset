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
        <h1 class="section-title">Pengajuan Aset</h1>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header-action">
                    <a href="{{ route('pengajuan.create') }}" class="btn btn-sm btn-primary" style="margin-right: 10px;">
                        <i class="fa-solid fa-circle-plus"></i> Tambah Pengajuan
                    </a>
                    @if(Auth::check() && Auth::user()->jabatan == 'admin')
                    <button class="btn btn-sm btn-danger" id="btn-delete-selected" style="display: none;"><i class="fas fa-trash-alt"></i> Hapus Terpilih</button>
                    <button class="btn btn-sm btn-success" id="btn-approve-selected" style="display: none;"><i class="far fa-thumbs-up"></i> Approved Terpilih</button>
                    <button class="btn btn-sm btn-danger" id="btn-reject-selected" style="display: none;"><i class="far fa-thumbs-down"></i> Reject Terpilih</button>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table1">
                            <thead>
                                <tr>
                                <th style="width: 30px;">
                                @if(Auth::check() && Auth::user()->jabatan == 'admin')
                                    <input type="checkbox" id="select-all">
                                @endif
                                </th>
                                <th style="width: 50px;">No</th>
                                <th class="nowrap" style="width: 150px;">Nama Barang</th>
                                <th class="nowrap" style="width: 150px;">Nama Pemohon</th>
                                <th style="text-align: center; width: 100px;">Status</th>
                                <th style="text-align: center; width: 200px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengajuan as $index => $item)
                                    @if(Auth::user()->jabatan == 'admin' || $item->nama_pemohon == Auth::user()->nama_user)
                                        <tr>
                                            <td>
                                                @if(Auth::check() && Auth::user()->jabatan == 'admin')
                                                    <input type="checkbox" class="checkbox-input" value="{{ $item->id }}">
                                                @endif
                                            </td>
                                            <td class="align-middle">{{ ($pengajuan->currentPage() - 1) * $pengajuan->perPage() + $index + 1 }}</td>
                                            <td class="align-middle">{{ $item->nama_barang }}</td>
                                            <td class="align-middle">{{ $item->nama_pemohon }}</td>
                                            <td class="align-middle text-center">
                                                <span class="{{ $item->status === 'pending' ? 'badge badge-warning' : ($item->status === 'approved' ? 'badge badge-success' : ($item->status === 'rejected' ? 'badge badge-danger' : '')) }}">
                                                    {{ $item->status }}
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <div class="dropdown d-inline">
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
                                                            <form id="delete-form-{{ $item->id }}" action="{{ route('pengajuan.destroy', $item->id) }}" method="POST" class="dropdown-item">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="delete-confirm" style="cursor:pointer;">
                                                                    <i class="fas fa-trash-alt"></i> Hapus
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
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
</section>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    $('#table1').DataTable(); // Initialize DataTables

    // Memilih semua checkbox
    $('#select-all').click(function(event) {
        if (this.checked) {
            $('.checkbox-input').each(function() {
                this.checked = true;
            });
        } else {
            $('.checkbox-input').each(function() {
                this.checked = false;
            });
        }
        toggleActionButtons();
    });

    // Toggling action buttons
    $('.checkbox-input').change(function() {
        toggleActionButtons();
    });

    function toggleActionButtons() {
        var selectedItems = $('.checkbox-input:checked').length;
        if (selectedItems > 0) {
            $('#btn-delete-selected').show();
            @if(Auth::check() && Auth::user()->jabatan == 'admin')
            $('#btn-approve-selected, #btn-reject-selected').show();
            @endif
        } else {
            $('#btn-delete-selected, #btn-approve-selected, #btn-reject-selected').hide();
        }
    }

    // Menghapus terpilih
    $('#btn-delete-selected').click(function() {
        var selectedItems = [];

        $('.checkbox-input:checked').each(function() {
            selectedItems.push($(this).val());
        });

        if (selectedItems.length === 0) {
            Swal.fire({
                title: 'Pilih Setidaknya Satu Item',
                text: 'Anda harus memilih setidaknya satu item untuk dihapus.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        } else {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Anda tidak akan dapat mengembalikan tindakan ini',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('pengajuan.bulk-delete') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            ids: selectedItems
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'Item terpilih telah dihapus.',
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: 'Terjadi kesalahan saat menghapus item terpilih.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat menghapus item terpilih.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        }
    });

    // Approve terpilih
    $('#btn-approve-selected').click(function() {
        var selectedItems = [];

        $('.checkbox-input:checked').each(function() {
            selectedItems.push($(this).val());
        });

        if (selectedItems.length === 0) {
            Swal.fire({
                title: 'Pilih Setidaknya Satu Item',
                text: 'Anda harus memilih setidaknya satu item untuk diapprove.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        } else {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Anda tidak akan dapat mengembalikan tindakan ini',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, approve!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('pengajuan.bulk-approve') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            ids: selectedItems
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'Item terpilih telah diapprove.',
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: 'Terjadi kesalahan saat melakukan approve item terpilih.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat melakukan approve item terpilih.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        }
    });

    // Reject terpilih
    $('#btn-reject-selected').click(function() {
        var selectedItems = [];

        $('.checkbox-input:checked').each(function() {
            selectedItems.push($(this).val());
        });

        if (selectedItems.length === 0) {
            Swal.fire({
                title: 'Pilih Setidaknya Satu Item',
                text: 'Anda harus memilih setidaknya satu item untuk direject.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        } else {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Anda tidak akan dapat mengembalikan tindakan ini',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, reject!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('pengajuan.bulk-reject') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            ids: selectedItems
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'Item terpilih telah direject.',
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: 'Terjadi kesalahan saat melakukan reject item terpilih.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat melakukan reject item terpilih.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        }
    });
});
// SweetAlert2 untuk menampilkan pesan berhasil setelah menyimpan
@if (session('success'))
        Swal.fire({
            title: 'Berhasil',
            text: '{{ session('success') }}',
            icon: 'success',
            showConfirmButton: true
        });
    @endif

    // SweetAlert2 untuk menampilkan pesan berhasil setelah memperbarui
    @if (session('update'))
        Swal.fire({
            title: 'Berhasil',
            text: 'Tag berhasil diperbarui',
            icon: 'success',
            showConfirmButton: true
        });
    @endif
</script>
@endsection
