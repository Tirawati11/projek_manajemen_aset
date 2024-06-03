@extends('layouts.main')

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">

<style>
@media print {
    body * {
        visibility: hidden;
    }
    .printableArea, .printableArea * {
        visibility: visible;
    }
    .printableArea {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    .no-print {
        display: none !important;
    }
}
</style>

@section('content')
<section class="section">
    <div class="section-header no-print">
        <h1 class="section-title" style="font-family: 'Roboto', sans-serif; color: #333;">Data Laporan</h1>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center no-print">
                    <button onclick="window.print()" class="btn btn-primary no-print"><i class="bi bi-printer"></i> Cetak Laporan</button>
                </div>
                <div class="card-body printableArea">
                    <h4 style="text-align: center;" class="printableTitle">Laporan Aset</h4>
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">No</th>
                                    <th style="text-align: center;">Nama Barang</th>
                                    <th style="text-align: center;">Jumlah</th>
                                    <th style="text-align: center;">Tanggal masuk</th>
                                    <th style="text-align: center;">Kondisi</th>
                                    <th style="text-align: center;">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @forelse ($aset as $item)
                                    <tr>
                                        <td style="text-align: center;">{{ $no++ }}</td>
                                        <td>{{ $item->nama_barang }}</td>
                                        <td style="text-align: center;">{{ $item->jumlah }}</td>
                                        <td style="text-align: center;">
                                            @if(isset($item->tanggal_masuk))
                                                {{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d-m-Y') }}
                                            @else
                                                Tanggal Masuk Tidak Tersedia
                                            @endif
                                        </td>
                                        <td style="text-align: center;">{{ $item->kondisi }}</td>
                                        <td style="text-align: center;">{{ $item->deskripsi}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center;">Data aset tidak ditemukan.</td>
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