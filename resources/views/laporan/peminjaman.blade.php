@extends('layouts.main')

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css">
<style>
    @media print {
        body * {
            visibility: hidden;
        }

        .printableArea, .printableArea * {
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

        /* Gaya border tabel saat cetak */
        .excel-table {
            border-collapse: collapse;
            width: 100%;
        }

        .excel-table th,
        .excel-table td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        /* Menghilangkan panah sortir */
        .sorting,
        .sorting_asc,
        .sorting_desc {
            background-image: none !important;
            cursor: default !important;
        }

        /* Mengatur tampilan teks di tengah untuk nomor urut dan tanggal */
        .excel-table td:nth-child(1),
        .excel-table td:nth-child(4),
        .excel-table td:nth-child(5),
        .excel-table td:nth-child(6) {
            text-align: center;
        }

        .dataTables_length, .dataTables_filter, .dataTables_info, .dataTables_paginate {
            display: none !important;
        }
    }
</style>

@section('content')
<section class="section">
    <div class="section-header no-print">
        <h1 class="section-title">Data Laporan Peminjaman</h1>
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
                    <h4 id="tableTitle" style="text-align: center;">Laporan Peminjaman</h4>
                    <div class="table-responsive">
                        <table class="table table-striped excel-table" cellspacing="0" width="100%" id="table1">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">No</th>
                                    <th style="text-align: center;">Penanggungjawab</th>
                                    <th style="width: 150px; text-align: center;">Nama Barang</th>
                                    <th style="text-align: center;">Jumlah</th>
                                    <th class="nowrap" style="text-align: center; width:150px;">Tanggal Pinjam</th>
                                    <th style="text-align: center; width:150px">Tanggal Kembali</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($peminjaman as $index => $item)
                                    <tr>
                                        <td class="align-middle" style="text-align: center;">{{ ($peminjaman->currentPage() - 1) * $peminjaman->perPage() + $index + 1 }}</td>
                                        <td class="align-middle" style="text-align: center;">{{ $item->barang ? $item->user->nama_user : 'User tidak tersedia'  }}</td>
                                        <td class="align-middle" style="text-align: center;">{{ $item->barang ? $item->barang->nama_barang : 'Barang tidak tersedia' }}</td>
                                        <td class="align-middle" style="text-align: center;">{{ $item->jumlah }}</td>
                                        <td class="align-middle" style="text-align: center;">{{ $item->tanggal_peminjaman }}</td>
                                        <td class="align-middle" style="text-align: center;">{{ $item->tanggal_pengembalian }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center;">Data aset tidak ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <!-- Pagination links -->
                        {{-- <div class="d-flex justify-content-center">
                            {{ $peminjaman->links() }}
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
                <title>Laporan Peminjaman</title>
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
                <h4 style="text-align: center;">Laporan Peminjaman</h4>
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
        const table = document.getElementById('table1');
        const workbook = XLSX.utils.table_to_book(table, { sheet: "Laporan Peminjaman" });
        const worksheet = workbook.Sheets["Laporan Peminjaman"];

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
        XLSX.writeFile(workbook, 'Laporan Peminjaman.xlsx');
    }
</script>
@endsection
