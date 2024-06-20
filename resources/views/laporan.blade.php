@extends('layouts.main')

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">

<style>
    @media print {
        body * {
            visibility: hidden;
        }

        .printableArea,
        .printableArea * {
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

        /* CSS untuk membuat tombol sejajar dan kecil */
        .form-select,
        .btn {
            height: 38px; /* Atur tinggi yang sama untuk input fields dan tombol */
            font-size: 14px; /* Atur ukuran font yang lebih kecil */
        }

        .form-group {
            margin-bottom: 0; /* Hapus margin bawah pada form-group */
        }

        .btn-primary {
            padding: 0.375rem 0.75rem; /* Atur padding agar tombol tidak terlalu besar */
        }
    }
</style>

@section('content')
<section class="section">
    <div class="section-header no-print">
        <h1 class="section-title" style="font-family: 'Roboto', sans-serif; color: #333;">Data Laporan</h1>
    </div>
    <div class="card card-primary">
        <div class="card-body">
            <form action="{{ url('/laporan') }}" method="GET">
                <div class="row">
                    <div class="col-md-6">
                        <label for="bulan" class="form-label">Pilih Bulan</label>
                        <select name="bulan" id="bulan" class="form-select">
                            <option value="">-- Pilih Bulan --</option>
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="tahun" class="form-label">Pilih Tahun</label>
                        <select name="tahun" id="tahun" class="form-select">
                            <option value="">-- Pilih Tahun --</option>
                            @for ($i = date('Y'); $i >= 2010; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-primary btn-sm" style="width: auto;">
                    Tampilkan
                </button>
            </form>
        </div>
    </div>
    <div class="row mt-4">
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
                                @php $no = 1; @endphp
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
