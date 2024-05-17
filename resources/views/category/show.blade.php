@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Category Details</h1>
    <div class="card">
        <div class="card-header">
            {{ $category->name }}
        </div>
        <div class="card-body">
            <p>Category ID: {{ $category->id }}</p>
            <p>Category Name: {{ $category->name }}</p>
        </div>
    </div>
    <a href="{{ route('category.index') }}" class="btn btn-secondary mt-3">Back to Categories</a>
</div>
@endsection