@extends('layouts.main')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <h4 class="mb-4" style="font-family: 'Roboto', sans-serif; color: #333; text-align: center;">Detail Lokasi</h4>
                    <hr>
                    <p class="mt-3" style="font-family: 'Roboto', sans-serif; color: #666;">
                        ID :  {{ $locations->id }}
                    </p>
                    <div class="mt-3" style="font-family: 'Roboto', sans-serif; color: #666;">
                        <p>Lokasi: {{ $locations->name }}</p>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('lokasi.index') }}" class="btn btn-sm btn-danger">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection