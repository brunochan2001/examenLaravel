<script>
    const API_AUTOR = '/api/autores'

    // ============================
    // SERVICIOS API
    // ============================
    const autorServicios = {

        async obtenerTodos() {
            const response = await fetch(API_AUTOR);
            return await response.json();
        },

        async obtenerPorId(id) {
            const response = await fetch(`${API_AUTOR}/${id}`);
            return await response.json();
        },

        async crear(data) {
            return await fetch(API_AUTOR, {
                method: "POST",
                headers: {
                    "Accept": "application/json"
                },
                body: data
            });

        },

        async actualizar(id, data) {
            data.append("_method", "PUT");
            return await fetch(`${API_AUTOR}/${id}`, {
                method: "POST",
                headers: {
                    "Accept": "application/json"
                },
                body: data
            });
        },

        async eliminar(id) {
            return await fetch(`${API_AUTOR}/${id}`, {
                method: "DELETE",
                headers: {
                    "Accept": "application/json"
                }
            });
        },
    };

    const libroServicios = {

        async obtenerTodos() {
            const response = await fetch('/api/libros');
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
    // LISTAR AUTORES
    // ============================
    async function listarAutores() {
        try {
            Loading.show();

            const autores = await autorServicios.obtenerTodos();
            const bodyAutores = document.getElementById('tbody-autores');

            const html = autores.map(autor => {
                let tituloLibros = autor.libros.length > 0 ?
                    autor.libros.map(libro => libro.titulo).join(', ') :
                    '-'
                let fechaNacimiento = autor.fecha_nacimiento ?
                    autor.fecha_nacimiento.substring(0, 10).split('-').reverse().join('/') :
                    '-';

                return `
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
                    <td>
                        <button class="btn btn-primary btn-sm" title="Editar" onclick="editarAutor(${autor.id})">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" title="Eliminar" onclick="eliminarAutor(${autor.id})">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </td>
                </tr>
            `
            }).join('');

            bodyAutores.innerHTML = html
        } catch (error) {
            console.log(error)
        } finally {
            Loading.hide();
        }


    }

    // ============================
    // LISTAR LIBROS
    // ============================
    async function listarLibros(selectedIds = []) {
        const select = $('#libro_ids');
        const libros = await libroServicios.obtenerTodos();

        select.empty();

        libros.forEach(libro => {
            const option = new Option(
                libro.titulo,
                libro.id,
                false,
                selectedIds.includes(libro.id)
            );
            select.append(option);
        });

        select.trigger('change');
    }

    // ============================
    // NUEVO AUTOR
    // ============================
    async function nuevoAutor() {
        try {
            Loading.show();

            document.getElementById('tituloModal').textContent = 'Nuevo Autor'
            document.getElementById('formAutor').reset()
            document.getElementById("id").value = "";

            await listarLibros();
        } catch (error) {
            console.log(error)
        } finally {
            Loading.hide();
        }
    }

    // ============================
    // EDITAR AUTOR
    // ============================
    async function editarAutor(id) {
        try {
            Loading.show();

            new bootstrap.Modal(document.getElementById('modalAutor')).show();

            const autor = await autorServicios.obtenerPorId(id);

            document.getElementById('id').value = autor.id;
            document.getElementById('nombre').value = autor.nombre;
            document.getElementById('apellido').value = autor.apellido;
            document.getElementById('nacionalidad').value = autor.nacionalidad ?? '';
            document.getElementById('fecha_nacimiento').value = autor.fecha_nacimiento ?
                autor.fecha_nacimiento.substring(0, 10) :
                '';
            document.getElementById('tituloModal').textContent = 'Editar Autor';

            const librosSeleccionados = autor.libros.map(libro => libro.id);

            await listarLibros(librosSeleccionados);

        } catch (error) {
            console.log(error)
        } finally {
            Loading.hide();
        }


    }

    // ============================
    // ELIMINAR AUTOR
    // ============================
    async function eliminarAutor(id) {
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

        const response = await autorServicios.eliminar(id);
        const resultado = await response.json();

        await listarAutores();

        Swal.fire({
            title: "¡Eliminado!",
            text: resultado.message,
            icon: "success"
        });

    }

    // ============================
    // FORMULARIO CREAR / ACTUALIZAR
    // ============================
    document
        .getElementById("formAutor")
        .addEventListener("submit", async function(e) {
            e.preventDefault();

            try {
                Loading.show();

                const id = document.getElementById("id").value;
                const data = new FormData(this);

                const libros = data.getAll('libro_ids[]');

                if (libros.includes('none') || libros.length === 0) {
                    data.append('libro_ids', []);
                }

                const response = id ?
                    await autorServicios.actualizar(id, data) :
                    await autorServicios.crear(data);

                if (response.ok) {
                    this.reset();
                    bootstrap.Modal
                        .getOrCreateInstance(
                            document.getElementById("modalAutor")
                        )
                        .hide();
                    await listarAutores();
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
        listarAutores()
    )

    // ============================
    // SELECT2 PARA LIBROS
    // ============================
    document.addEventListener('DOMContentLoaded', () => {
        $('#libro_ids').select2({
            placeholder: 'Seleccione libros',
            allowClear: true,
            width: '100%',
            dropdownParent: $('#modalAutor')
        });
    });
</script>