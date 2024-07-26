@extends('layouts.main')

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css">

@section('content')
<section class="section">
    <div class="section-header">
        <h1 class="section-title">Detail Data Kategori: {{ $category->name }}</h1>
    </div>
</section>
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <h3 class="mb-4" style="text-align: center;">Data Aset</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered table-md" id="dataTable">
                            <thead>
                                <tr>
                                    <th style="text-align: center; width:50px">No</th>
                                    <th style="text-align: center;">Nama Barang</th>
                                    <th style="text-align: center;">Jumlah</th>
                                    <th style="text-align: center;">Kondisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data akan diisi oleh DataTables -->
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('categories.index') }}" class="btn btn-sm btn-danger mt-3">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.1.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('categories.asets.data', ['categoryId' => $category->id]) }}',
            columns: [
                { data: 'id', name: 'id', render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }, className: 'text-center' },
                { data: 'nama_barang', name: 'nama_barang', className: 'text-center' },
                { data: 'jumlah', name: 'jumlah', className: 'text-center' },
                { data: 'kondisi', name: 'kondisi', className: 'text-center' },
            ]
        });
    });
</script>
@endsection
