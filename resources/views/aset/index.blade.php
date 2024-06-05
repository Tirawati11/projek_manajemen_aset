@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<section class="section">
    <div class="section-header">
        <h1 class="section-title" style="font-family: 'Roboto', sans-serif; color: #333;">Data Aset</h1>
    </section>
        <form action="" method="GET" class="form-inline ml-auto">
            <div class="input-group">
                <input class="form-control" type="search" name="search" placeholder="Search" aria-label="Search" value="{{ $search ?? '' }}">
                <div class="input-group-btn">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
    </div>
    <div class="card-header-action">
        <a href="{{ route('aset.create') }}" class="btn btn-primary"><i class="fa-solid fa-circle-plus"></i> Tambah Aset</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-md">
                <thead>
                    <tr>
                        <th style="text-align: center; width:20px;">No</th>
                        <th style="text-align: center;">Kode</th>
                        <th style="text-align: center;">Gambar</th>
                        <th style="text-align: center;">Nama Barang</th>
                        <th style="text-align: center;">Merek</th>
                        <th style="text-align: center;">Tanggal Masuk</th>
                        <th style="text-align: center;">Jumlah</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($asets as $aset)
                    <tr>
                        <td>{{ ($asets->currentPage() - 1) * $asets->perPage() + $loop->iteration }}</td>
                        <td>{{ $aset->kode }}</td>
                        <td>
                            <img src="{{ asset('/storage/aset/'.$aset->gambar) }}" class="rounded" style="width: 150px">
                        </td>
                        <td>{{ $aset->nama_barang }}</td>
                        <td>{{ $aset->merek }}</td>
                        <td>{{ \Carbon\Carbon::parse($aset->tanggal_masuk)->format('d-m-Y') }}</td>
                        <td>{{ $aset->jumlah }}</td>
                        <td>
                            <a href="{{ route('aset.show', $aset->id) }}" class="btn btn-sm btn-dark" title="SHOW">
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('aset.edit', $aset->id) }}" class="btn btn-sm btn-primary" title=" EDIT">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form id="delete-form-{{ $aset->id }}" action="{{ route('aset.destroy', $aset->id) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger delete-confirm" title=" HAPUS">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                     <td colspan="8" class="text-center">Belum ada aset.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $asets->appends(['search' => $search])->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
   $(document).on('click', '.delete-confirm', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak dapat mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
// Session delete
    @if (session('delete'))
        Swal.fire({
            title: 'Berhasil',
            text: '{{ session('delete') }}',
            icon: 'success',
            showConfirmButton: true
        });
    @endif
// Session sukses
    @if (session('success'))
        Swal.fire({
            title: 'Berhasil',
            text: '{{ session('success') }}',
            icon: 'success',
            showConfirmButton: true
        });
    @endif
// Session update
    @if (session('update'))
        Swal.fire({
            title: 'Berhasil',
            text: 'Data berhasil diperbarui',
            icon: 'success',
            showConfirmButton: true
        });
    @endif
</script>
@endsection
