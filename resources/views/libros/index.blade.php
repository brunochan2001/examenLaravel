@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>Libros</h1>
        <p class="text-muted">
            Catálogo de libros registrados en la biblioteca, con su descripción, cantidad de páginas, stock disponible e idioma.
        </p>
        <table class="table">
            <thead>
                <tr>
                <th scope="col">Título</th>
                <th scope="col">Descripción</th>
                <th scope="col">Páginas</th>
                <th scope="col">Stock</th>
                <th scope="col">Idioma</th>
                <th scope="col">Autores</th>
                <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody id="tbody-libros">
                
            </tbody>
        </table>
    </div>

    <script>
        const API = '/api/libros'

        document.addEventListener(
            'DOMContentLoaded',
            cargarLibros()
        )

        async function cargarLibros(){
            const response = await fetch(API)

            const libros = await response.json()

            let bodyLibros = document.getElementById('tbody-libros')

            let html = '';

            libros.forEach( libro => {

                let nombresAutores = libro.autores.map(
                    autor => `${autor.nombre} ${autor.apellido}`
                ).join(', ')

                html += `
                    <tr>
                        <td>
                            ${libro.titulo}
                        </td>
                        <td>
                            ${libro.descripcion ?? '-'}
                        </td>
                        <td>
                            ${libro.paginas ?? '-'}
                        </td>
                        <td>
                            ${libro.stock ?? '-'}
                        </td>
                        <td>
                            ${libro.idioma ?? '-'}
                        </td>
                        <td>
                            ${nombresAutores}
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
            bodyLibros.innerHTML = html
        }
    </script>
@endsection