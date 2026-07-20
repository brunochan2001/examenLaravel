@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <h1 class="mb-0">Reservas</h1>
        </div>
        <div>
            <button class="btn btn-success btn-sm" title="Agregar Reserva" onclick="nuevaReserva()" data-bs-toggle="modal" data-bs-target="#modalReserva">
                <i class="bi bi-plus-lg"></i>
            </button>
        </div>
    </div>
    <div class="border rounded-3 shadow-sm p-3 bg-white">
        @include('reservas.tabla')
    </div>
</div>

@include('reservas.modal')
@endsection

@section('scripts')
@include('reservas.scripts')
@endsection