@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>Autores</h1>
        <p class="text-muted">
            Listado de autores registrados, con su nacionalidad, fecha de nacimiento y los libros que han escrito.
        </p>
        <table class="table">
            <thead>
                <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Apellido</th>
                <th scope="col">Nacionalidad</th>
                <th scope="col">Fecha de Nacimiento</th>
                <th scope="col">Libros</th>
                <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody id="tbody-autores">
                
            </tbody>
        </table>
    </div>

    <script>
        const API = '/api/autores'

        document.addEventListener(
            'DOMContentLoaded',
            cargarAutores()
        )

        async function cargarAutores(){
            const response = await fetch(API)

            const autores = await response.json()

            let bodyAutores = document.getElementById('tbody-autores')

            let html = '';

            autores.forEach( autor => {

                let tituloLibros = autor.libros.length > 0
                    ? autor.libros.map(libro => libro.titulo).join(', ')
                    : '-'

                let fechaNacimiento = new Date(autor.fecha_nacimiento).toLocaleDateString('es-PE')

                html += `
                    <tr>
                        <td>
                            ${autor.nombre}
                        </td>
                        <td>
                            ${autor.apellido}
                        </td>
                        <td>
                            ${autor.nacionalidad ?? '-'}
                        </td>
                        <td>
                            ${fechaNacimiento}
                        </td>
                        <td>
                            ${tituloLibros}
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
            bodyAutores.innerHTML = html
            console.log(bodyAutores)

        }
    </script>
@endsection