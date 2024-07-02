@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<section class="section">
    <div class="section-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h1 class="section-title"> Data Inventaris</h1>
    </div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header-action">
                <a href="{{ route('aset.create') }}" class="btn btn-primary" style="margin-right: 10px;">
                    <i class="fa-solid fa-circle-plus"></i> Tambah Aset
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-md" id="tables">
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
                                    <a href="{{ route('aset.show', $aset->id) }}" class="btn btn-sm btn-dark" title="LIHAT">
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
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
     $('#tables').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true
        });
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

        // Display success messages based on session status
        @if (session('delete'))
            Swal.fire({
                title: 'Berhasil',
                text: '{{ session('delete') }}',
                icon: 'success',
                showConfirmButton: true
            });
        @endif

        @if (session('success'))
            Swal.fire({
                title: 'Berhasil',
                text: '{{ session('success') }}',
                icon: 'success',
                showConfirmButton: true
            });
        @endif

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
