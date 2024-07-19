@extends('layouts.main')

@section('content')
<section class="section">
    <div class="section-header">
        <h1 class="section-title" style="font-family: 'Roboto', sans-serif; color: #333;">Detail Data Kategori: {{ $category->name }}</h1>
    </div>
</section>
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <h3 class="mb-4" style="text-align: center;" >Data Aset</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered table-md">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">No</th>
                                    <th style="text-align: center;">Nama Barang</th>
                                    <th style="text-align: center;">Jumlah</th>
                                    <th style="text-align: center;">Kondisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($asets && count($asets) > 0)
                                @foreach($asets as $index => $aset)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td class="text-center">{{ $aset->nama_barang }}</td>
                                        <td class="text-center">{{ $aset->jumlah }}</td>
                                        <td class="text-center">{{ $aset->kondisi }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada aset yang terkait dengan kategori ini.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('categories.index') }}" class="btn btn-sm btn-primary mt-3">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
