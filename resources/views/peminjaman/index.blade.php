@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://code.jquery.com/jquery-3.6.1.js"></script>
<section class="section">
    <div class="section-header">
        <h1 class="section-title">Data Peminjaman Aset</h1>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header-action">
                    <a href="{{ route('peminjaman.create') }}" class="btn btn-primary"><i class="fa-solid fa-circle-plus"></i> Buat Peminjaman</a>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    $('#mytable1').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('peminjaman.index') }}",
            type: 'GET',
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'barang.nama_barang', name: 'barang.nama_barang' },
            { data: 'nama_peminjam', name: 'nama_peminjam' },
            { data: 'tanggal_peminjaman', name: 'tanggal_peminjaman', render: function(data) {
                return data ? moment(data, 'DD-MM-YYYY').format('DD-MM-YYYY') : '';
            }},
            { data: 'tanggal_pengembalian', name: 'tanggal_pengembalian', render: function(data) {
                return data ? moment(data, 'DD-MM-YYYY').format('DD-MM-YYYY') : '';
            }},
            { data: 'status', name: 'status', render: function(data, type, row) {
                return '<span class="badge ' + (data === 'dipinjam' ? 'badge-success' : 'badge-primary') + '">' + data + '</span>';
            }},
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[1, 'asc']]
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
            confirmButtonText: 'Ya, hapus saja!',
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
