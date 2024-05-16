@extends('layouts.main')
@section('content')
<style>
    .card-header-action {
    padding: 4.8px 12.8px;
}
</style>
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>DATA ASET</h4>
                </div>
                <div class="card-header-action">
                    <a href="{{ route('aset.create') }}" class="btn btn-primary">Tambah Aset</a>
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
                                    <th>Status</th>
                                    <th>Deskripsi</th>
                                    <th>Lokasi</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($aset as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->kode }}</td>
                                    <td>{{ $item->gambar }}</td>
                                    <td>{{ $item->nama_barang }}</td>
                                    <td>{{ $item->merek }}</td>
                                    <td>{{ $item->tahun }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>{{ $item->deskripsi }}</td>
                                    <td>{{ $item->lokasi }}</td>
                                    <td>
                                        <a href="#" class="btn btn-secondary">Detail</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    </div>
                <div class="card-footer text-right">
                    <nav class="d-inline-block">
                        <ul class="pagination mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1 <span
                                        class="sr-only">(current)</span></a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">2</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
