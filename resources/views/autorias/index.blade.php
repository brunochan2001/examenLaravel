@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <h1 class="mb-0">Autorías</h1>
        </div>
        <div>
            <button class="btn btn-success btn-sm" title="Agregar Autoría" onclick="nuevoAutoria()" data-bs-toggle="modal" data-bs-target="#modalAutoria">
                <i class="bi bi-plus-lg"></i>
            </button>
        </div>
    </div>
    <div class="border rounded-3 shadow-sm p-3 bg-white">
        @include('autorias.tabla')
    </div>
</div>

@include('autorias.modal')
@endsection

@section('scripts')
@include('autorias.scripts')
@endsection