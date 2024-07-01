@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>  
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> 
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
                    <div class="table-responsive">
                        <table class="table table-striped" id="table1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Lokasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($locations as $index => $location)
                                <tr data-id="{{ $location->id }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $location->name }}</td>
                                    <td>
                                        <!-- Show Button -->
                                        <button type="button" class="btn btn-sm btn-dark" data-toggle="modal" data-target="#modalShow{{$location->id}}" title="Show"> <i class="far fa-eye"></i></button>

                                        <!-- Edit Button -->
                                        <button type="button" class="btn btn-sm btn-primary btn-edit" data-id="{{ $location->id }}" data-name="{{ $location->name }}" title="Edit"> <i class="fas fa-edit"></i></button>

                                        <!-- Delete Button -->
                                        @if (!$location->has_related_data)
                                        <form action="{{ route('lokasi.destroy', $location->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger delete-confirm" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                        @else
                                        <button type="button" class="btn btn-sm btn-danger" disabled>
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada data lokasi.</td>
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

@include('lokasi.create')
@foreach($locations as $location)
    @include('lokasi.show', ['location' => $location])
    @include('lokasi.edit', ['location' => $location])
@endforeach

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
<script>
    $(document).ready(function() {
        $('#formTambah').on('submit', function(e) {
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

                    localStorage.setItem('saveSuccess', 'true');
                    location.reload();
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
        var form = $(this).closest('form');

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
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil',
                            text: response.message,
                            icon: 'success',
                            showConfirmButton: true
                        }).then((result) => {
                            form.closest('tr').remove();
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            Swal.fire({
                                title: 'Error',
                                text: xhr.responseJSON.error,
                                icon: 'error',
                                showConfirmButton: true
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'Terjadi kesalahan saat menghapus data.',
                                icon: 'error',
                                showConfirmButton: true
                            });
                        }
                    }
                });
            }
        });
    });
  // Tampilkan modal edit saat tombol edit diklik
        $(document).on('click', '.btn-edit', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');

            $(`#location${id}`).val(name); // Isi nilai input dengan nama lokasi yang akan diedit
            $(`#modalEdit${id}`).modal('show'); // Tampilkan modal edit
        });

        // Tangani form submit untuk update lokasi dengan AJAX
        $(document).on('submit', '[id^=formEdit]', function(e) {
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
                    $(`#modalEdit${response.data.id}`).modal('hide'); // Sembunyikan modal edit setelah sukses update
                    $('.modal-backdrop').remove();
                    Swal.fire({
                        title: 'Berhasil',
                        text: response.message,
                        icon: 'success',
                        showConfirmButton: true
                    }).then((result) => {
                        // Tampilkan perubahan langsung setelah berhasil update
                        var row = $('tr[data-id="' + response.data.id + '"]');
                        row.find('td:eq(1)').text(response.data.name); // Update nama lokasi dalam tabel
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

        $('.modal').on('hidden.bs.modal', function() {
            $('.modal-backdrop').remove();
        });

        // Tampilkan pesan sukses jika lokasi berhasil disimpan
        if (localStorage.getItem('saveSuccess') === 'true') {
            Swal.fire({
                title: 'Berhasil',
                text: 'Lokasi berhasil disimpan!',
                icon: 'success',
                showConfirmButton: true
            });
            localStorage.removeItem('saveSuccess');
        }
    });
</script>
@endsection
