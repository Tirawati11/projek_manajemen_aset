@extends('layouts.main')

@section('content')
<section class="section">
    <div class="section-header">
        <h1 class="section-title">Detail Data di Lokasi: {{ $location->name }}</h1>
    </div>
</section>
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <h3 class="mb-4" style="text-align: center;">Data Peminjaman</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered table-md" id="peminjaman-barang-table">
                            <thead>
                                <tr>
                                    <th style="text-align: center; width:25px">No</th>
                                    <th style="text-align: center; width:100px">Nama Barang</th>
                                    <th style="text-align: center; width:100px">Nama Peminjam</th>
                                    <th style="text-align: center; width:100px">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <br>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('lokasi.index') }}" class="btn btn-sm btn-danger">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var table = $('#peminjaman-barang-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('lokasi.show', $location->id) }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                { data: 'barang.nama_barang', name: 'barang.nama_barang', className: 'text-center' },
                { data: 'nama_peminjam', name: 'nama_peminjam', className: 'text-center' },
                { data: 'jumlah', name: 'jumlah', className: 'text-center' }
            ]
        });
    });
</script>
@endsection
