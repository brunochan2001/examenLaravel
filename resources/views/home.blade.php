@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="mb-4">
                <h1>📊 Panel de Control</h1>
                <p class="text-muted">
                    Resumen general del sistema de biblioteca: consulta de un vistazo el total de libros, autores y autorías registradas.
                </p>
            </div>

            <div class="row" id="resumen-cards">
                <div class="col-md-4">
                    <div class="card text-center border-primary mb-3">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted">Total de Libros</h6>
                            <h2 class="card-title text-primary" id="total-libros">...</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-center border-success mb-3">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted">Total de Autores</h6>
                            <h2 class="card-title text-success" id="total-autores">...</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-center border-warning mb-3">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted">Total de Autorías</h6>
                            <h2 class="card-title text-warning" id="total-autorias">...</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-center border-warning mb-3">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted">Total de Reservas</h6>
                            <h2 class="card-title text-warning" id="total-reservas">...</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-center border-warning mb-3">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted">Total de Socios</h6>
                            <h2 class="card-title text-warning" id="total-socios">...</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', cargarResumen)

    async function cargarResumen() {
        try {
            const [resLibros, resAutores, resAutorias, resReservas, resSocios] = await Promise.all([
                fetch('/api/libros'),
                fetch('/api/autores'),
                fetch('/api/autorias'),
                fetch('/api/reservas'),
                fetch('/api/socios')
            ])

            const libros = await resLibros.json()
            const autores = await resAutores.json()
            const autorias = await resAutorias.json()
            const reservas = await resReservas.json()
            const socios = await resSocios.json()

            document.getElementById('total-libros').innerText = libros.length
            document.getElementById('total-autores').innerText = autores.length
            document.getElementById('total-autorias').innerText = autorias.length
            document.getElementById('total-reservas').innerText = reservas.length
            document.getElementById('total-socios').innerText = socios.length
        } catch (error) {
            console.error('Error al cargar el resumen:', error)
        }
    }
</script>
@endsection