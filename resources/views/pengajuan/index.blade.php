@extends('layouts.main')

@section('content')
<style>
    .card-header-action {
        padding: 4.8px, 12.8px; /* Gunakan titik (.) sebagai penghubung antara property dan nilai */
    }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        /* th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        } */
        th {
            background-color: #f2f2f2;
        }
        .nowrap {
            white-space: nowrap;
        }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.5.2/css/bootstrap.min.css">
<section class="section">
    <div class="section-header">
        <h1 class="section-title" style="font-family: 'Roboto', sans-serif; color: #333;">Pengajuan Aset</h1>
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
                    <a href="{{ route('pengajuan.create') }}" class="btn btn-primary"><i class="fa-solid fa-circle-plus"></i> Tambah Pengajuan</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th class="nowrap" style="width: 150px;">Nama Barang</th>
                                    <th class="nowrap" style="width: 150px;">Nama Pemohon</th>
                                    <th style="width: 100px;">Status</th>
                                    <th style="width: 100px;">Kategori</th>
                                    <th style="width: 100px;">Jumlah</th>
                                    <th style="width: 200px;">Catatan</th>
                                    <th style="width: 300px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pengajuan as  $index => $item)
                                <tr>
                                    <td>{{ ($pengajuan->currentPage() - 1) * $pengajuan->perPage() + $index + 1 }}</td>
                                    <td class="align-middle">{{ $item->nama_barang }}</td>
                                    <td class="align-middle">{{ $item->user_id }}</td>
                                    <td class="align-middle">{{ $item->status }}</td>
                                    {{-- <td class="align-middle">{{ $item->categories->nama }}</td> --}}
                                    <td class="align-middle">{{ $item->jumlah}}</td>
                                    <td class="align-middle">{{ $item->deskripsi}}</td>
                                    <td>
                                        <a href="{{ url('pengajuan', $item->id) }}" class="btn btn-sm btn-dark">
                                        <i class="far fa-eye"></i>
                                            LIHAT
                                        </a>
                                        <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('pengajuan.destroy', $item->id) }}" method="POST" class="d-inline">
                                            <a href="{{ route('pengajuan.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                                EDIT
                                            </a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger delete-confirm" data-id="{{ $item->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                                HAPUS
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                  <div class="alert alert-danger">
                                      Data Pengajuan belum Tersedia.
                                  </div>
                              @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $pengajuan->links() }}
                    </div>
                    </div>
                </div>
            </div>
        </div>
  </div>
</section>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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


