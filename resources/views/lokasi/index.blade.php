@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
<style>
    .input-group .form-control {
        border-radius: 50px;
    }
</style>
<section class="section">
    <div class="section-header">
        <h1 class="section-title">Data Lokasi</h1>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambah"><i class="fa-solid fa-circle-plus"></i> Tambah Lokasi</button>
                </div>
                <div class="card-body">
                    <div id="alert-container"></div>
                    <div class="table-responsive">
                        <table class="table table-striped text-center" id="mytable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Lokasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data dari DataTables akan dimasukkan di sini -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('lokasi.create')

@foreach($locations as $location)
    @include('lokasi.show', ['location' => $location])
    @include('lokasi.edit', ['location' => $location])
@endforeach

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#mytable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('lokasi.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        $('#formTambah').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var method = form.attr('method');
            var data = form.serialize();

            $.ajax({
                url: url,
                method: method,
                data: data,
                success: function(response) {
                    $('#modalTambah').modal('hide');
                    $('.modal-backdrop').remove();
                    Swal.fire({
                        title: 'Success',
                        text: 'Data lokasi berhasil disimpan!',
                        icon: 'success',
                        showConfirmButton: true
                    }).then((result) => {
                        table.ajax.reload();
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Error',
                        text: xhr.responseJSON.message,
                        icon: 'error',
                        showConfirmButton: true
                    });
                }
            });
        });

        $(document).on('click', '.delete-confirm', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var url = "{{ route('lokasi.destroy', ':id') }}".replace(':id', id);

            Swal.fire({
                title: 'Hapus',
                text: "Anda yakin akan menghapus data ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus saja!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        method: 'DELETE',
                        success: function(response) {
                            Swal.fire({
                                title: 'Success',
                                text: response.message,
                                icon: 'success',
                                showConfirmButton: true
                            }).then((result) => {
                                table.ajax.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Error',
                                text: 'Data gagal dihapus.',
                                icon: 'error',
                                showConfirmButton: true
                            });
                        }
                    });
                }
            });
        });

        $(document).on('click', '.btn-edit', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');

            $(`#location${id}`).val(name);
            $(`#modalEdit${id}`).modal('show');
        });

        $('[id^=formEdit]').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var method = form.attr('method');
            var data = form.serialize();

            $.ajax({
                url: url,
                method: method,
                data: data,
                success: function(response) {
                    $(`#modalEdit${response.data.id}`).modal('hide');
                    $('.modal-backdrop').remove();
                    Swal.fire({
                        title: 'Success',
                        text: response.message,
                        icon: 'success',
                        showConfirmButton: true
                    }).then((result) => {
                        table.ajax.reload();
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Gagal melakukan update.',
                        icon: 'error',
                        showConfirmButton: true
                    });
                }
            });
        });

        $('.modal').on('hidden.bs.modal', function () {
            $('.modal-backdrop').remove();
        });
    });
</script>
@endsection
