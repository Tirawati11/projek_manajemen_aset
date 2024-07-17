@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.1.js"></script>
<section class="section">
    <div class="section-header">
        <h1 class="section-title">Data Peminjaman Aset</h1>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header-action mt-3 ml-3">
                    <a href="{{ route('peminjaman.create') }}" class="btn btn-sm btn-primary"><i class="fa-solid fa-circle-plus"></i> Buat Peminjaman</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-md" id="mytable1">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">No</th>
                                    <th class="nowrap" style="width: 150px; text-align: center;">Nama Barang</th>
                                    <th style="text-align: center;">Penanggungjawab</th>
                                    <th class="nowrap" style="text-align: center; width:150px;">Tanggal Pinjam</th>
                                    <th class="nowrap" style="text-align: center; width:150px">Tanggal Kembali</th>
                                    <th style="text-align: center;">Status</th>
                                    <th style="text-align: center; width:150px;">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<!-- NiceScroll -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    $('#mytable1').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
                url: "{{ route('peminjaman.index') }}",
                data: function (d) {
                    var tanggal_peminjaman = $('#tanggal_peminjaman').val();
                    var tanggal_pengembalian = $('#tanggal_pengembalian').val();

                    if (tanggal_peminjaman) {
                        var parts = tanggal_peminjaman.split('-');
                        if (parts.length === 3) {
                            // Tanggal lengkap
                            tanggal_peminjaman = parts[2] + '-' + parts[1] + '-' + parts[0];
                        } else if (parts.length === 2) {
                            // Bulan dan tahun
                            tanggal_peminjaman = parts[1] + '-' + parts[0];
                        } else if (parts.length === 1) {
                            // Hanya tahun
                            tanggal_peminjaman = parts[0];
                        }
                        d.tanggal_peminjaman = tanggal_peminjaman;
                    }

                    if (tanggal_pengembalian) {
                        var parts = tanggal_pengembalian.split('-');
                        if (parts.length === 3) {
                            // Tanggal lengkap
                            tanggal_pengembalian = parts[2] + '-' + parts[1] + '-' + parts[0];
                        } else if (parts.length === 2) {
                            // Bulan dan tahun
                            tanggal_pengembalian = parts[1] + '-' + parts[0];
                        } else if (parts.length === 1) {
                            // Hanya tahun
                            tanggal_pengembalian = parts[0];
                        }
                        d.tanggal_pengembalian = tanggal_pengembalian;
                    }
                }
            },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'barang.nama_barang', name: 'barang.nama_barang', className: 'text-center' },
            { data: 'nama_peminjam', name: 'nama_peminjam', className: 'text-center' },
            { data: 'tanggal_peminjaman', name: 'tanggal_peminjaman', className: 'text-center', render: function(data) {
                return data ? moment(data, 'DD-MM-YYYY').format('DD-MM-YYYY') : '';
            }},
            { data: 'tanggal_pengembalian', name: 'tanggal_pengembalian', className: 'text-center', render: function(data) {
                return data ? moment(data, 'DD-MM-YYYY').format('DD-MM-YYYY') : '';
            }},
            { data: 'status', name: 'status', render: function(data, type, row) {
                return '<span class="badge ' + (data === 'dipinjam' ? 'badge-success' : 'badge-primary') + '">' + data + '</span>';
            }},
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[1, 'asc']]
    });
    $('#tanggal_peminjaman, #tanggal_pengembalian').change(function() {
            table.draw();
        });
    $(document).on('click', '.delete-confirm', function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
        Swal.fire({
            title: 'Hapus',
            text: "Anda yakin akan menghapus ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus saja',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
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
            text: 'Tag berhasil diperbarui',
            icon: 'success',
            showConfirmButton: true
        });
    @endif
});
</script>
@endsection
