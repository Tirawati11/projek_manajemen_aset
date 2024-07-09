@extends('layouts.main')

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://code.jquery.com/jquery-3.6.1.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
{{--
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css"> --}}

@section('content')
<section class="section">
    <div class="section-header no-print">
        <h1 class="section-title">Data Laporan Inventaris</h1>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center no-print">
                    <div>
                        <button onclick="prepareForPrint()" class="btn btn-primary"><i class="bi bi-printer"></i> Cetak Laporan</button>
                        <button onclick="exportToExcel()" class="btn btn-success"><i class="bi bi-file-earmark-excel"></i> Simpan ke Excel</button>
                    </div>
                </div>
                <div class="card-body printableArea">
                    <h4 id="tableTitle" style="text-align: center;">Laporan Inventaris</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-print" cellspacing="0" width="100%" id="table1">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">No</th>
                                    <th style="text-align: center;">Nama Barang</th>
                                    <th style="text-align: center;">Harga</th>
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
                                    <td style="text-align: center;">{{ $item->nama_barang }}</td>
                                    <td style="text-align: center;">{{ 'Rp'   . number_format($item->harga, 2, ',', '.')}}</td>
                                    <td style="text-align: center;">{{ $item->jumlah }}</td>
                                    <td style="text-align: center;">
                                        @if(isset($item->tanggal_masuk))
                                        {{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d-m-Y') }}
                                        @else
                                        Tanggal Masuk Tidak Tersedia
                                        @endif
                                    </td>
                                    <td style="text-align: center;">{{ $item->kondisi }}</td>
                                    <td style="text-align: center;">{{ $item->deskripsi }}</td>
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
@section('scripts')
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
<script>
    function prepareForPrint() {
        // Clone the table to keep original untouched
        const tableToPrint = document.getElementById('table1').cloneNode(true);

        // Remove DataTables classes and attributes from cloned table
        tableToPrint.classList.remove('dataTable', 'no-footer');
        tableToPrint.removeAttribute('role');

        // Adjust styles if needed for printing
        tableToPrint.style.width = '100%'; // Example: Adjust width for better printing

        // Create a new window for printing
        const printWindow = window.open('', '_blank');
        printWindow.document.open();
        printWindow.document.write(`
            <html>
            <head>
                <title>Laporan Inventaris</title>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
                <style>
                    /* Optional: Add custom styles for printing */
                    body {
                        padding: 20px;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
                    th, td {
                        border: 1px solid #dddddd;
                        text-align: left;
                        padding: 8px;
                    }
                    th {
                        background-color: #f2f2f2;
                    }
                </style>
            </head>
            <body>
                <h4 style="text-align: center;">Laporan Inventaris</h4>
        `);
        printWindow.document.write(tableToPrint.outerHTML);
        printWindow.document.write(`
            </body>
            </html>
        `);
        printWindow.document.close();

        // Call print function after content is loaded
        printWindow.onload = function() {
            printWindow.print();
            printWindow.close();
        };
    }
    // eksport data ke excel
    function exportToExcel() {
        const table = document.getElementById('table1');
        const workbook = XLSX.utils.table_to_book(table, { sheet: "Laporan Inventaris" });
        const worksheet = workbook.Sheets["Laporan Inventaris"];

        // Apply border styles to all cells
        const range = XLSX.utils.decode_range(worksheet['!ref']);
        for (let R = range.s.r; R <= range.e.r; ++R) {
            for (let C = range.s.c; C <= range.e.c; ++C) {
                const cell_address = { c: C, r: R };
                const cell_ref = XLSX.utils.encode_cell(cell_address);
                if (!worksheet[cell_ref]) worksheet[cell_ref] = {};
                if (!worksheet[cell_ref].s) worksheet[cell_ref].s = {};
                worksheet[cell_ref].s.border = {
                    top: { style: "thin", color: { auto: 1 } },
                    right: { style: "thin", color: { auto: 1 } },
                    bottom: { style: "thin", color: { auto: 1 } },
                    left: { style: "thin", color: { auto: 1 } }
                };
            }
        }

        // Export the workbook
        XLSX.writeFile(workbook, 'Laporan Inventaris.xlsx');
    }
</script>
@endsection


