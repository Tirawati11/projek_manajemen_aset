<!-- Modal -->
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
                            <strong>Penanggungjawab:</strong> {{ $peminjamanBarang->user->nama_user }}
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
</div>
