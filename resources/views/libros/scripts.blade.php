<script>
    const API_LIBRO = '/api/libros'

    // ============================
    // SERVICIOS API
    // ============================
    const libroServicios = {

        async obtenerTodos() {
            const response = await fetch(API_LIBRO);
            return await response.json();
        },

        async obtenerPorId(id) {
            const response = await fetch(`${API_LIBRO}/${id}`);
            return await response.json();
        },

        async crear(data) {
            return await fetch(API_LIBRO, {
                method: "POST",
                headers: {
                    "Accept": "application/json"
                },
                body: data
            });
        },

        async actualizar(id, data) {
            data.append("_method", "PUT");
            return await fetch(`${API_LIBRO}/${id}`, {
                method: "POST",
                headers: {
                    "Accept": "application/json"
                },
                body: data
            });
        },

        async eliminar(id) {
            return await fetch(`${API_LIBRO}/${id}`, {
                method: "DELETE",
                headers: {
                    "Accept": "application/json"
                }
            });
        },
    };


    const autorServicios = {

        async obtenerTodos() {
            const response = await fetch('/api/autores');
            return await response.json();
        }
    };

    // ============================
    // LOADING
    // ============================
    const Loading = {

        show() {
            const loading = document.getElementById('loading');
            loading.classList.remove('d-none');
        },


        hide() {
            const loading = document.getElementById('loading');
            loading.classList.add('d-none');
        }

    };

    // ============================
    // LISTAR LIBROS
    // ============================
    async function listarLibros() {
        try {
            Loading.show();

            const libros = await libroServicios.obtenerTodos();
            const bodyLibros = document.getElementById('tbody-libros');

            const html = libros.map(libro => {
                let nombresAutores = libro.autores.length > 0 ?
                    libro.autores.map(autor => `${autor.nombre} ${autor.apellido}`).join(', ') :
                    '-';

                return `
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
                    <td>
                        <button class="btn btn-primary btn-sm" title="Editar" onclick="editarLibro(${libro.id})">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" title="Eliminar" onclick="eliminarLibro(${libro.id})">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </td>
                </tr>
            `
            }).join('');

            bodyLibros.innerHTML = html

        } catch (error) {
            console.log(error)
        } finally {
            Loading.hide();
        }
    }

    // ============================
    // LISTAR AUTORES
    // ============================
    async function listarAutores(selectedIds = []) {
        const select = $('#autor_ids');
        const autores = await autorServicios.obtenerTodos();

        select.empty();

        autores.forEach(autor => {

            const option = new Option(
                `${autor.nombre} ${autor.apellido}`,
                autor.id,
                false,
                selectedIds.includes(autor.id)
            );

            select.append(option);
        });

        select.trigger('change');
    }

    // ============================
    // NUEVO LIBRO
    // ============================
    async function nuevoLibro() {
        try {
            Loading.show();

            document.getElementById('tituloModalLibro').textContent = 'Nuevo Libro'
            document.getElementById('formLibro').reset()
            document.getElementById("id").value = "";

            await listarAutores();
        } catch (error) {
            console.log(error)
        } finally {
            Loading.hide();
        }
    }

    // ============================
    // EDITAR LIBRO
    // ============================
    async function editarLibro(id) {
        try {
            Loading.show();

            new bootstrap.Modal(document.getElementById('modalLibro')).show();

            const libro = await libroServicios.obtenerPorId(id);

            document.getElementById('id').value = libro.id;
            document.getElementById('titulo').value = libro.titulo;
            document.getElementById('descripcion').value = libro.descripcion ?? '';
            document.getElementById('paginas').value = libro.paginas;
            document.getElementById('stock').value = libro.stock;
            document.getElementById('fecha_publicacion').value = libro.fecha_publicacion ?
                libro.fecha_publicacion.substring(0, 10) :
                '';
            document.getElementById('idioma').value = libro.idioma ?? '';
            document.getElementById('tituloModalLibro').textContent = 'Editar Libro';

            const autoresSeleccionados = libro.autores.map(autor => autor.id);

            await listarAutores(autoresSeleccionados);
        } catch (error) {
            console.log(error)
        } finally {
            Loading.hide();
        }
    }


    // ============================
    // ELIMINAR LIBRO
    // ============================
    async function eliminarLibro(id) {
        const result = await Swal.fire({
            title: "¿Estás seguro(a)?",
            text: "¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar",
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33"
        });

        if (!result.isConfirmed) {
            return;
        }

        try {
            Loading.show();

            const response = await libroServicios.eliminar(id);
            const resultado = await response.json();

            await listarLibros();

            Swal.fire({
                title: "¡Eliminado!",
                text: resultado.message,
                icon: "success"
            });
        } catch (error) {
            console.log(error)
        } finally {
            Loading.hide();
        }
    }


    // ============================
    // FORMULARIO CREAR / ACTUALIZAR
    // ============================
    document
        .getElementById("formLibro")
        .addEventListener("submit", async function(e) {
            e.preventDefault();

            try {
                Loading.show();

                const id = document.getElementById("id").value;
                const data = new FormData(this);

                const autores = data.getAll('autor_ids[]');

                if (autores.includes('none') || autores.length === 0) {
                    data.append('autor_ids[]', []);
                }

                const response = id ?
                    await libroServicios.actualizar(id, data) :
                    await libroServicios.crear(data);

                if (response.ok) {
                    this.reset();
                    bootstrap.Modal
                        .getOrCreateInstance(
                            document.getElementById("modalLibro")
                        )
                        .hide();
                    await listarLibros();
                }
            } catch (error) {
                console.log(error)
            } finally {
                Loading.hide();
            }
        });

    // ============================
    // INICIO
    // ============================
    document.addEventListener(
        'DOMContentLoaded',
        listarLibros()
    )

    // ============================
    // SELECT2 PARA AUTORES
    // ============================
    document.addEventListener('DOMContentLoaded', () => {
        $('#autor_ids').select2({
            placeholder: 'Seleccione autores',
            allowClear: true,
            width: '100%',
            dropdownParent: $('#modalLibro')
        });
    });
</script>