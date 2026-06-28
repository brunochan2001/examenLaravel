@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>Autorías</h1>
        <table class="table">
            <thead>
                <tr>
                <th scope="col">Autor</th>
                <th scope="col">Nacionalidad</th>
                <th scope="col">Libro</th>
                <th scope="col">Idioma</th>
                <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody id="tbody-autorias">
                
            </tbody>
        </table>
    </div>

    <script>
        const API = '/api/autorias'

        document.addEventListener(
            'DOMContentLoaded',
            cargarAutorias()
        )

        async function cargarAutorias(){
            const response = await fetch(API)

            const autorias = await response.json()

            let bodyAutorias = document.getElementById('tbody-autorias')

            let html = '';

            autorias.forEach( autoria => {
                html += `
                    <tr>
                        <td>
                            ${autoria.autor.nombre} ${autoria.autor.apellido}
                        </td>
                        <td>
                            ${autoria.autor.nacionalidad ?? '-'}
                        </td>
                        <td>
                            ${autoria.libro.titulo}
                        </td>
                        <td>
                            ${autoria.libro.idioma ?? '-'}
                        </td>
                        <td class="d-flex gap-2">
                            <button class="btn btn-primary btn-sm" title="Actualizar">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" title="Eliminar">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </td>
                    </tr>
                `
            })
            bodyAutorias.innerHTML = html
            console.log(bodyAutorias)

        }
    </script>
@endsection