<script>
    const API_AUTORIA = '/api/autorias';

    // ============================
    // SERVICIOS API
    // ============================
    const autoriaServicios = {

        async obtenerTodos() {
            const response = await fetch(API_AUTORIA);
            return await response.json();
        },

        async obtenerPorId(id) {
            const response = await fetch(`${API_AUTORIA}/${id}`);
            return await response.json();
        },

        async crear(data) {
            return await fetch(API_AUTORIA, {
                method: "POST",
                headers: {
                    "Accept": "application/json"
                },
                body: data
            });
        },

        async actualizar(id, data) {
            data.append("_method", "PUT");

            return await fetch(`${API_AUTORIA}/${id}`, {
                method: "POST",
                headers: {
                    "Accept": "application/json"
                },
                body: data
            });
        },

        async eliminar(id) {
            return await fetch(`${API_AUTORIA}/${id}`, {
                method: "DELETE",
                headers: {
                    "Accept": "application/json"
                }
            });
        }
    };

    const autorServicios = {

        async obtenerTodos() {
            const response = await fetch('/api/autores');
            return await response.json();
        }
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
            document.getElementById('loading').classList.remove('d-none');
        },

        hide() {
            document.getElementById('loading').classList.add('d-none');
        }

    };

    // ============================
    // MANEJO DE ERRORES API
    // ============================
    const Alertas = {

        async errorValidacion(response) {

            const error = await response.json();
            let mensajes = '';

            if (error.errors) {
                Object.values(error.errors).forEach(campo => {
                    mensajes += `• ${campo[0]}<br>`;
                });
            } else {
                mensajes = error.message ?? 'Ocurrió un error inesperado';
            }

            Swal.fire({
                title: "Error de validación",
                html: mensajes,
                icon: "error"
            });
        },

        success(message) {
            Swal.fire({
                title: "Correcto",
                text: message,
                icon: "success"
            });
        }
    };

    // ============================
    // LISTAR AUTORIAS
    // ============================
    async function listarAutorias() {
        try {
            Loading.show();

            const autorias = await autoriaServicios.obtenerTodos();
            const bodyAutorias = document.getElementById('tbody-autorias');

            const html = autorias.map(autoria => `
                <tr>
                    <td>${autoria.autor.nombre} ${autoria.autor.apellido}</td>
                    <td>${autoria.libro.titulo}</td>
                    <td>
                        <button class="btn btn-primary btn-sm" title="Editar" onclick="editarAutoria(${autoria.id})">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" title="Eliminar" onclick="eliminarAutoria(${autoria.id})">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </td>
                </tr>
            `).join('');

            bodyAutorias.innerHTML = html;
        } catch (error) {
            console.log(error);
        } finally {
            Loading.hide();
        }
    }

    // ============================
    // LISTAR AUTORES
    // ============================
    async function listarAutores(selectedId = null) {
        const select = document.getElementById('autor_id');
        const autores = await autorServicios.obtenerTodos();

        select.innerHTML = '<option value="">Seleccione un autor</option>';

        autores.forEach(autor => {
            select.innerHTML += `
                <option value="${autor.id}" ${selectedId == autor.id ? 'selected' : ''}>
                    ${autor.nombre} ${autor.apellido}
                </option>
            `;
        });
    }

    // ============================
    // LISTAR LIBROS
    // ============================
    async function listarLibros(selectedId = null) {
        const select = document.getElementById('libro_id');
        const libros = await libroServicios.obtenerTodos();

        select.innerHTML = '<option value="">Seleccione un libro</option>';

        libros.forEach(libro => {
            select.innerHTML += `
                <option value="${libro.id}" ${selectedId == libro.id ? 'selected' : ''}>
                    ${libro.titulo}
                </option>
            `;
        });
    }

    // ============================
    // NUEVA AUTORIA
    // ============================
    async function nuevoAutoria() {
        try {
            Loading.show();

            document.getElementById('tituloModalAutoria').textContent = 'Nueva Autoría';
            document.getElementById('formAutoria').reset();
            document.getElementById('id').value = '';

            await listarAutores();
            await listarLibros();
        } catch (error) {
            console.log(error);
        } finally {
            Loading.hide();
        }
    }

    // ============================
    // EDITAR AUTORIA
    // ============================
    async function editarAutoria(id) {
        try {
            Loading.show();

            new bootstrap.Modal(document.getElementById('modalAutoria')).show();

            const autoria = await autoriaServicios.obtenerPorId(id);

            document.getElementById('id').value = autoria.id;
            document.getElementById('tituloModalAutoria').textContent = 'Editar Autoría';

            await listarAutores(autoria.autor_id);
            await listarLibros(autoria.libro_id);
        } catch (error) {
            console.log(error);
        } finally {
            Loading.hide();
        }
    }

    // ============================
    // ELIMINAR AUTORIA
    // ============================
    async function eliminarAutoria(id) {
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

            const response = await autoriaServicios.eliminar(id);
            const resultado = await response.json();

            await listarAutorias();

            Swal.fire({
                title: "¡Eliminado!",
                text: resultado.message,
                icon: "success"
            });
        } catch (error) {
            console.log(error);
        } finally {
            Loading.hide();
        }
    }

    // ============================
    // FORMULARIO CREAR / ACTUALIZAR
    // ============================
    document
        .getElementById("formAutoria")
        .addEventListener("submit", async function(e) {
            e.preventDefault();

            try {
                Loading.show();

                const id = document.getElementById("id").value;
                const data = new FormData(this);

                const response = id ?
                    await autoriaServicios.actualizar(id, data) :
                    await autoriaServicios.crear(data);

                if (response.ok) {
                    this.reset();
                    bootstrap.Modal
                        .getOrCreateInstance(document.getElementById("modalAutoria"))
                        .hide();
                    await listarAutorias();
                } else {
                    await Alertas.errorValidacion(response);
                }
            } catch (error) {
                console.log(error);
            } finally {
                Loading.hide();
            }
        });

    // ============================
    // INICIO
    // ============================
    document.addEventListener(
        'DOMContentLoaded',
        listarAutorias()
    );
</script>