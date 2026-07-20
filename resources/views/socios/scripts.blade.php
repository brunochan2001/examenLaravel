<script>
    const API_SOCIO = '/api/socios'

    // ============================
    // SERVICIOS API
    // ============================
    const socioServicios = {

        async obtenerTodos() {
            const response = await fetch(API_SOCIO);
            return await response.json();
        },

        async obtenerPorId(id) {
            const response = await fetch(`${API_SOCIO}/${id}`);
            return await response.json();
        },

        async crear(data) {
            return await fetch(API_SOCIO, {
                method: "POST",
                headers: {
                    "Accept": "application/json"
                },
                body: data
            });
        },

        async actualizar(id, data) {
            data.append("_method", "PUT");
            return await fetch(`${API_SOCIO}/${id}`, {
                method: "POST",
                headers: {
                    "Accept": "application/json"
                },
                body: data
            });
        },

        async eliminar(id) {
            return await fetch(`${API_SOCIO}/${id}`, {
                method: "DELETE",
                headers: {
                    "Accept": "application/json"
                }
            });
        },
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
    // LISTAR SOCIOS
    // ============================
    async function listarSocios() {
        try {
            Loading.show();

            const socios = await socioServicios.obtenerTodos();
            const bodySocios = document.getElementById('tbody-socios');

            const html = socios.map(socio => {
                const totalReservas = socio.reservas?.length ?? 0;

                return `
                <tr>
                    <td>${socio.nombre}</td>
                    <td>${socio.apellido}</td>
                    <td>${socio.dni}</td>
                    <td>${socio.email ?? '-'}</td>
                    <td>${socio.telefono ?? '-'}</td>
                    <td>${totalReservas}</td>
                    <td>
                        <button class="btn btn-primary btn-sm" title="Editar" onclick="editarSocio(${socio.id})">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" title="Eliminar" onclick="eliminarSocio(${socio.id})">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </td>
                </tr>
                `;
            }).join('');

            bodySocios.innerHTML = html;
        } catch (error) {
            console.log(error);
        } finally {
            Loading.hide();
        }
    }

    // ============================
    // NUEVO SOCIO
    // ============================
    function nuevoSocio() {
        document.getElementById('tituloModalSocio').textContent = 'Nuevo Socio';
        document.getElementById('formSocio').reset();
        document.getElementById('id').value = '';
    }

    // ============================
    // EDITAR SOCIO
    // ============================
    async function editarSocio(id) {
        try {
            Loading.show();

            new bootstrap.Modal(document.getElementById('modalSocio')).show();

            const socio = await socioServicios.obtenerPorId(id);

            document.getElementById('id').value = socio.id;
            document.getElementById('nombre').value = socio.nombre;
            document.getElementById('apellido').value = socio.apellido;
            document.getElementById('dni').value = socio.dni;
            document.getElementById('email').value = socio.email ?? '';
            document.getElementById('telefono').value = socio.telefono ?? '';
            document.getElementById('tituloModalSocio').textContent = 'Editar Socio';
        } catch (error) {
            console.log(error);
        } finally {
            Loading.hide();
        }
    }

    // ============================
    // ELIMINAR SOCIO
    // ============================
    async function eliminarSocio(id) {
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

            const response = await socioServicios.eliminar(id);
            const resultado = await response.json();

            await listarSocios();

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
    document.getElementById("formSocio").addEventListener("submit", async function(e) {
        e.preventDefault();

        try {
            Loading.show();

            const id = document.getElementById("id").value;
            const data = new FormData(this);

            const response = id ?
                await socioServicios.actualizar(id, data) :
                await socioServicios.crear(data);

            if (response.ok) {
                this.reset();
                bootstrap.Modal
                    .getOrCreateInstance(document.getElementById("modalSocio"))
                    .hide();
                await listarSocios();
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
        listarSocios()
    );
</script>