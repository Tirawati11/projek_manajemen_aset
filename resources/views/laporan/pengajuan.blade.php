@extends('layouts.main')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://code.jquery.com/jquery-3.6.1.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">

@section('content')
<section class="section">
    <div class="section-header no-print">
        <h1 class="section-title">Data Laporan Pengajuan</h1>
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
                    <h4 id="tableTitle" style="text-align: center;">Laporan Pengajuan</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-print" id="pengajuanTable">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th class="nowrap" style="width: 200px;">Nama Barang</th>
                                    <th class="nowrap" style="width: 200px;">Nama Pemohon</th>
                                    <th class="nowrap" style="width: 200px;">Jumlah Permintaan</th>
                                    <th class="nowrap" style="width: 200px;">Stok Divisi</th>
                                    <th class="nowrap" style="width: 150px;">Catatan</th>
                                    <th style="text-align: center; width: 50px;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<!-- XLSX Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>

<script>
    $(document).ready(function() {
        $('#pengajuanTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('laporan.pengajuan') }}",
                type: 'GET'
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'nama_barang', name: 'nama_barang', className: 'text-center' },
                { data: 'nama_pemohon', name: 'nama_pemohon', className: 'text-center' },
                { data: 'jumlah', name: 'jumlah', className: 'text-center' },
                { data: 'stok', name: 'stok', className: 'text-center' },
                { data: 'deskripsi', name: 'deskripsi', className: 'text-center' },
                { data: 'status', name: 'status', orderable: false, searchable: false }
            ]
        });
    });

    function prepareForPrint() {
        const tableToPrint = document.getElementById('pengajuanTable').cloneNode(true);

        tableToPrint.classList.remove('dataTable', 'no-footer');
        tableToPrint.removeAttribute('role');


        tableToPrint.style.width = '100%';

        const printWindow = window.open('', '_blank');
        printWindow.document.open();
        printWindow.document.write(`
            <html>
            <head>
                <title>Laporan Pengajuan</title>
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
                <h4 style="text-align: center;">Laporan Pengajuan</h4>
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

    function exportToExcel() {
        const table = document.getElementById('pengajuanTable');
        const workbook = XLSX.utils.table_to_book(table, { sheet: "Laporan Pengajuan" });
        const worksheet = workbook.Sheets["Laporan Pengajuan"];

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
        XLSX.writeFile(workbook, 'Laporan Pengajuan.xlsx');
    }
</script>
@endsection

@section('styles')
<style>
    .table th,
    .table td {
        text-align: center;
    }
</style>
@endsection
