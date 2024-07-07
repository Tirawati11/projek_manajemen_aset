@extends('layouts.main')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <h4 class="mb-4" style="text-align: center;">Detail Lokasi</h4>
                    <hr>
                <div class="card-body">
                    <p><strong>Lokasi:</strong> {{$location->name}}</p>
                    <h5>Data Peminjaman Barang:</h5>
                    <ul>
                        @forelse ($location->peminjamanBarangs as $peminjamanBarang)
                            <li>
                                <strong>Nama Barang:</strong> {{ $peminjamanBarang->barang ? $peminjamanBarang->barang->nama_barang : 'Barang tidak ditemukan' }}
                                <br>
                                <strong>Penanggungjawab:</strong> {{ $peminjamanBarang->nama_peminjam }}
                                <br>
                                <strong>Jumlah:</strong> {{ $peminjamanBarang->jumlah }}
                            </li>
                        @empty
                            <li>Tidak ada data peminjaman barang di lokasi ini.</li>
                        @endforelse
                    </ul>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('lokasi.index') }}" class="btn btn-sm btn-danger">Kembali</a>
                </div>
            </div>
        </div>
@endsection{{-- <!-- Modal -->
<div class="modal fade" id="modalShow{{$location->id}}" tabindex="-1" role="dialog" aria-labelledby="modalShowLabel{{$location->id}}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="modalShowLabel{{$location->id}}">Detail Lokasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Lokasi:</strong> {{$location->name}}</p>

                <h5>Data Peminjaman Barang:</h5>
                <ul>
                    @forelse ($location->peminjamanBarangs as $peminjamanBarang)
                        <li>
                            <strong>Nama Barang:</strong> {{ $peminjamanBarang->barang ? $peminjamanBarang->barang->nama_barang : 'Barang tidak ditemukan' }}
                            <br>
                            <strong>Penanggungjawab:</strong> {{ $peminjamanBarang->nama_peminjam }}
                            <br>
                            <strong>Jumlah:</strong> {{ $peminjamanBarang->jumlah }}
                        </li>
                    @empty
                        <li>Tidak ada data peminjaman barang di lokasi ini.</li>
                    @endforelse
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div> --}}
