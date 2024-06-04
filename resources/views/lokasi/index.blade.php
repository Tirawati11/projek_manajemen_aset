@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<section class="section">
    <div class="section-header">
        <h1 class="section-title" style="font-family: 'Roboto', sans-serif; color: #333;">Data Lokasi</h1>
        <form action="{{ route('lokasi.index') }}" method="GET" class="form-inline ml-auto">
            <div class="input-group">
                <input class="form-control" type="search" name="search" placeholder="Search" aria-label="Search" value="{{ $search ?? '' }}">
                <div class="input-group-btn">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambah"><i class="fa-solid fa-circle-plus"></i> Tambah Lokasi</button>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped text-center">
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

                                        <!-- Delete Form -->
                                        <form action="{{ route('lokasi.destroy', $location->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger delete-confirm" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada data lokasi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $locations->appends(['search' => $search])->links('pagination::bootstrap-5') }}
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
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
   $(document).ready(function() {
    // Code for handling modal form submit using AJAX for creating a new location
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
                Swal.fire({
                    title: 'Berhasil',
                    text: response.message,
                    icon: 'success',
                    showConfirmButton: true
                }).then((result) => {
                    location.reload();
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

    // Code for handling delete confirmation
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

      // Tampilkan modal edit dengan data lokasi
   // Tampilkan modal edit saat tombol edit diklik
   $('.btn-edit').click(function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            $('#name{{$location->id}}').val(name); // Isi nilai input dengan nama lokasi yang akan diedit
            $('#modalEdit{{$location->id}}').modal('show'); // Tampilkan modal edit
        });
        // Tangani form submit untuk update lokasi dengan AJAX
        $('#formEdit{{$location->id}}').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<section class="section">
    <div class="section-header">
        <h1 class="section-title" style="font-family: 'Roboto', sans-serif; color: #333;">Data Lokasi</h1>
        <form action="{{ route('lokasi.index') }}" method="GET" class="form-inline ml-auto">
            <div class="input-group">
                <input class="form-control" type="search" name="search" placeholder="Search" aria-label="Search" value="{{ $search ?? '' }}">
                <div class="input-group-btn">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambah"><i class="fa-solid fa-circle-plus"></i> Tambah Lokasi</button>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped text-center">
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

                                        <!-- Delete Form -->
                                        <form action="{{ route('lokasi.destroy', $location->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger delete-confirm" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada data lokasi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $locations->appends(['search' => $search])->links('pagination::bootstrap-5') }}
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
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
   $(document).ready(function() {
    // Code for handling modal form submit using AJAX for creating a new location
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
                Swal.fire({
                    title: 'Berhasil',
                    text: response.message,
                    icon: 'success',
                    showConfirmButton: true
                }).then((result) => {
                    location.reload();
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

    // Code for handling delete confirmation
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

      // Tampilkan modal edit dengan data lokasi
   // Tampilkan modal edit saat tombol edit diklik
   $(document).on('click', '.btn-edit', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');

        // Gunakan template literal untuk menyisipkan variabel id
        $(#location${id}).val(name); // Isi nilai input dengan nama lokasi yang akan diedit
        $(#modalEdit${id}).modal('show'); // Tampilkan modal edit
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
                $(#modalEdit${response.data.id}).modal('hide'); // Sembunyikan modal edit setelah sukses update
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
});
</script>
@endsection

            var method = form.attr('method');
            var data = form.serialize();

            $.ajax({
                url: url,
                method: method,
                data: data,
                success: function(response) {
                    $('#modalEdit{{$location->id}}').modal('hide'); // Sembunyikan modal edit setelah sukses update
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
    });
</script>
@endsection