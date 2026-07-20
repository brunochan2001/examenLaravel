@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <h1 class="mb-0">Socios</h1>
        </div>
        <div>
            <button class="btn btn-success btn-sm" title="Agregar Socio" onclick="nuevoSocio()" data-bs-toggle="modal" data-bs-target="#modalSocio">
                <i class="bi bi-plus-lg"></i>
            </button>
        </div>
    </div>
    <div class="border rounded-3 shadow-sm p-3 bg-white">
        @include('socios.tabla')
    </div>
</div>

@include('socios.modal')
@endsection

@section('scripts')
@include('socios.scripts')
@endsection