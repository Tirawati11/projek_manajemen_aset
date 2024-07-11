@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://code.jquery.com/jquery-3.6.1.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
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
                <div class="card-header-action mt-3 ml-3">
                    <a href="{{ route('pengajuan.create') }}" class="btn btn-sm btn-primary" style="margin-right: 10px;">
                        <i class="fa-solid fa-circle-plus"></i> Tambah Pengajuan
                    </a>
                    @if(Auth::check() && Auth::user()->jabatan == 'admin')
                    <button class="btn btn-sm btn-danger" id="btn-delete-selected" style="display: none;"><i class="fas fa-trash-alt"></i> Hapus Terpilih</button>
                    <button class="btn btn-sm btn-success" id="btn-approve-selected" style="display: none;"><i class="far fa-thumbs-up"></i> Approved Terpilih</button>
                    <button class="btn btn-sm btn-warning" id="btn-reject-selected" style="display: none;"><i class="far fa-thumbs-down"></i> Reject Terpilih</button>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-pengajuan">
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
                        </table>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
<script src="assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
$(document).ready(function() {
    var table = $('#table-pengajuan').DataTable({
        processing: true,
        serverSide: true,
        ajax:  "{{ route('pengajuan.index') }}",
        columns: [
            { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'nama_barang', name: 'nama_barang' },
            { data: 'nama_pemohon', name: 'nama_pemohon' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[3, 'desc']] // Default order, misalnya berdasarkan indeks
    });

    // Menambahkan event listener untuk seleksi semua checkbox
    $('#select-all').click(function(event) {
        var isChecked = this.checked;
        $('.checkbox-input').each(function() {
            this.checked = isChecked;
        });
        toggleActionButtons();
    });

    // Toggle action buttons berdasarkan checkbox yang dipilih
    $('#table-pengajuan tbody').on('change', '.checkbox-input', function() {
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

    // Event untuk menghapus item terpilih
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
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
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
                                    table.ajax.reload();
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

    // Event untuk menyetujui dan menolak item terpilih
    $('#btn-approve-selected').click(function() {
        handleBulkAction('{{ route('pengajuan.bulk-approve') }}', 'approve');
    });

    $('#btn-reject-selected').click(function() {
        handleBulkAction('{{ route('pengajuan.bulk-reject') }}', 'reject');
    });

    function handleBulkAction(url, action) {
        var selectedItems = [];
        $('.checkbox-input:checked').each(function() {
            selectedItems.push($(this).val());
        });

        if (selectedItems.length === 0) {
            Swal.fire({
                title: 'Pilih Setidaknya Satu Item',
                text: 'Anda harus memilih setidaknya satu item untuk di' + action + '.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        } else {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Anda akan ' + action + ' item terpilih.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, ' + action + '!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            ids: selectedItems
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'Item terpilih telah di' + action + '.',
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    table.ajax.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: 'Terjadi kesalahan saat ' + action + ' item terpilih.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat ' + action + ' item terpilih.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        }
    }

    // Event untuk menampilkan SweetAlert2 saat menyetujui pengajuan
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
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $('#approvalForm' + pengajuanId).submit();
            }
        });
    });

    // Event untuk menampilkan SweetAlert2 saat menolak pengajuan
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
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $('#rejectForm' + pengajuanId).submit();
            }
        });
    });

    // Event untuk menampilkan SweetAlert2 saat mengkonfirmasi penghapusan
    $('#table-pengajuan').on('click', '.delete-confirm', function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
        var id = form.data('id');
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    // Tampilkan pesan berhasil setelah menyimpan
    @if (session('success'))
        Swal.fire({
            title: 'Berhasil',
            text: '{{ session('success') }}',
            icon: 'success',
            showConfirmButton: true
        });
    @endif

    // Tampilkan pesan berhasil setelah memperbarui
    @if (session('update'))
        Swal.fire({
            title: 'Berhasil',
            text: 'Tag berhasil diperbarui',
            icon: 'success',
            showConfirmButton: true
        });
    @endif
});
</script>
@endsection
