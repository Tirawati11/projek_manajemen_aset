@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<section class="section">
    <div class="section-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h1 class="section-title" style="font-family: 'Roboto', sans-serif; color: #333;"> Data Aset</h1>
    </div>
</section>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header-action" style="display: flex; justify-content: space-between; align-items: center;">
                <a href="{{ route('aset.create') }}" class="btn btn-primary" style="margin-right: 10px;">
                    <i class="fa-solid fa-circle-plus"></i> Tambah Aset
                </a>
                <div class="btn-group">
                    <button type="button" data-toggle="dropdown" class="btn btn-info btn-sm dropdown-toggle"><i class="ion-android-download"></i>Simpan <span class="caret"></span></button>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="javascript:void(0)" id="print"><i class="ion-printer"></i>&nbsp;&nbsp;Print</a></li>
                        <li><a href="javascript:void(0)" id="save_to_excel"><i class="ion-android-document">Simpan Excel</a></li>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-md" id="table1">
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
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

    function performAction() {
        var action = document.getElementById("actionDropdown").value;
        if (action === "print") {
            window.print();
        } else if (action === "export") {
            exportToExcel();
        }
    }

    function exportToExcel() {
        /* Assuming the table has an id of "table1" */
        var table = document.getElementById("table1");
        var wb = XLSX.utils.table_to_book(table, {sheet: "Sheet JS"});
        var wbout = XLSX.write(wb, {bookType: "xlsx", bookSST: true, type: "binary"});

        function s2ab(s) {
            var buf = new ArrayBuffer(s.length);
            var view = new Uint8Array(buf);
            for (var i = 0; i < s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
            return buf;
        }

        var blob = new Blob([s2ab(wbout)], {type: "application/octet-stream"});
        var fileName = "export.xlsx";
        if (navigator.msSaveBlob) { // IE 10+
            navigator.msSaveBlob(blob, fileName);
        } else {
            var link = document.createElement("a");
            if (link.download !== undefined) { // Feature detection
                var url = URL.createObjectURL(blob);
                link.setAttribute("href", url);
                link.setAttribute("download", fileName);
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        }
    }
</script>
@endsection
