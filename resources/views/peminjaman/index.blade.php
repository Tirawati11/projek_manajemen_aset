@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    <style>
    .badge-success {
        background-color: green;
        color: white;
    }

    .badge-primary {
        background-color: blue;
        color: white;
    }
</style>
<section class="section">
    <div class="section-header">
        <h1 class="section-title" style="font-family: 'Roboto', sans-serif; color: #333;">Data Peminjaman Aset</h1>
        <form action="" method="GET" class="form-inline ml-auto">
            <div class="input-group">
                <input class="form-control" type="search" name="search" placeholder="Search" aria-label="Search" value="{{ $search ?? '' }}">
                <div class="input-group-btn">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header-action">
                    <a href="{{ route('peminjaman.create') }}" class="btn btn-primary"><i class="fa-solid fa-circle-plus"></i> Buat Peminjaman</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-md">
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
                            <tbody>
                                @forelse ($peminjaman as $index => $item)
                                    <tr>
                                        <td class="align-middle">{{ ($peminjaman->currentPage() - 1) * $peminjaman->perPage() + $index + 1 }}</td>
                                        <td class="align-middle">{{ $item->barang ? $item->barang->nama_barang : 'Barang tidak tersedia' }}</td>
                                        <td class="align-middle">{{ $item->nama }}</td>
                                        <td class="align-middle">{{ $item->tanggal_peminjaman }}</td>
                                        <td class="align-middle">{{ $item->tanggal_pengembalian }}</td>
                                        <td class="align-middle">
                                            <span class="badge {{ $item->status == 'dipinjam' ? 'badge-success' : ($item->status == 'kembali' ? 'badge-primary' : '') }}">
                                                {{ $item->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('peminjaman.show', $item->id) }}" class="btn btn-sm btn-dark" title="Lihat">
                                                <i class="far fa-eye"></i>
                                            </a>
                                            <form id="delete-form-{{ $item->id }}" action="{{ route('peminjaman.destroy', $item->id) }}" method="POST" class="d-inline">
                                                <a href="{{ route('peminjaman.edit', $item->id) }}" title="Edit" class="btn btn-sm btn-primary edit-confirm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Hapus" class="btn btn-sm btn-danger delete-confirm">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">Belum ada data peminjaman.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $peminjaman->appends(['search' => $search])->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).on('click', '.delete-confirm', function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
        var name = $(this).data('name');

        Swal.fire({
            title: 'Hapus',
            text: "Anda yakin akan menghapus ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus saja!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // Submit form jika pengguna mengonfirmasi
            }
        });
    });

    // SweetAlert2 untuk menampilkan pesan berhasil setelah menghapus
    @if (session('delete'))
        Swal.fire({
            title: 'Berhasil',
            text: '{{ session('delete') }}',
            icon: 'success',
            showConfirmButton: true
        });
    @endif

    // SweetAlert2 untuk menampilkan pesan berhasil setelah menyimpan
    @if (session('success'))
        Swal.fire({
            title: 'Berhasil',
            text: '{{ session('success') }}',
            icon: 'success',
            showConfirmButton: true
        });
    @endif

    // SweetAlert2 untuk menampilkan pesan berhasil setelah memperbarui
    @if (session('update'))
        Swal.fire({
            title: 'Berhasil',
            text: 'Tag berhasil diperbarui',
            icon: 'success',
            showConfirmButton: true
        });
    @endif
</script>
@endsection
