<script>
    const API_RESERVA = '/api/reservas'

    // ============================
    // SERVICIOS API
    // ============================
    const reservaServicios = {

        async obtenerTodos() {
            const response = await fetch(API_RESERVA);
            return await response.json();
        },

        async obtenerPorId(id) {
            const response = await fetch(`${API_RESERVA}/${id}`);
            return await response.json();
        },

        async crear(data) {
            return await fetch(API_RESERVA, {
                method: "POST",
                headers: {
                    "Accept": "application/json"
                },
                body: data
            });
        },

        async actualizar(id, data) {
            data.append("_method", "PUT");

            return await fetch(`${API_RESERVA}/${id}`, {
                method: "POST",
                headers: {
                    "Accept": "application/json"
                },
                body: data
            });
        },

        async eliminar(id) {
            return await fetch(`${API_RESERVA}/${id}`, {
                method: "DELETE",
                headers: {
                    "Accept": "application/json"
                }
            });
        },
    };

    const socioServicios = {

        async obtenerTodos() {
            const response = await fetch('/api/socios');
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
            const loading = document.getElementById('loading');
            loading.classList.remove('d-none');
        },

        hide() {
            const loading = document.getElementById('loading');
            loading.classList.add('d-none');
        }

    };

    // ============================
    // LISTAR RESERVAS
    // ============================
    async function listarReservas() {
        try {
            Loading.show();

            const reservas = await reservaServicios.obtenerTodos();
            const bodyReservas = document.getElementById('tbody-reservas');

            const html = reservas.map(reserva => {
                const fechaReserva = reserva.fecha_reserva ?
                    reserva.fecha_reserva.substring(0, 10).split('-').reverse().join('/') :
                    '-';

                const fechaDevolucion = reserva.fecha_devolucion ?
                    reserva.fecha_devolucion.substring(0, 10).split('-').reverse().join('/') :
                    '-';

                return `
                <tr>
                    <td>
                        ${reserva.socio.nombre} ${reserva.socio.apellido}
                    </td>
                    <td>
                        ${reserva.libro.titulo}
                    </td>
                    <td>
                        ${fechaReserva}
                    </td>
                    <td>
                        ${fechaDevolucion}
                    </td>
                    <td>
                        ${reserva.estado}
                    </td>
                    <td>
                        <button class="btn btn-primary btn-sm" title="Editar" onclick="editarReserva(${reserva.id})">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" title="Eliminar" onclick="eliminarReserva(${reserva.id})">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </td>
                </tr>
                `;
            }).join('');

            bodyReservas.innerHTML = html;

        } catch (error) {
            console.log(error);
        } finally {
            Loading.hide();
        }
    }

    // ============================
    // LISTAR SOCIOS
    // ============================
    async function listarSocios(selectedId = null) {
        const select = document.getElementById('socio_id');
        const socios = await socioServicios.obtenerTodos();

        select.innerHTML = '<option value="">Seleccione un socio</option>';

        socios.forEach(socio => {
            select.innerHTML += `
            <option value="${socio.id}" ${selectedId == socio.id ? 'selected' : ''}>
                ${socio.nombre} ${socio.apellido}
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
    // NUEVA RESERVA
    // ============================
    async function nuevaReserva() {
        try {
            Loading.show();

            document.getElementById('tituloModalReserva').textContent = 'Nueva Reserva';
            document.getElementById('formReserva').reset();
            document.getElementById('id').value = '';

            await listarSocios();
            await listarLibros();
        } catch (error) {
            console.log(error);
        } finally {
            Loading.hide();
        }
    }

    // ============================
    // EDITAR RESERVA
    // ============================
    async function editarReserva(id) {
        try {
            Loading.show();

            new bootstrap.Modal(document.getElementById('modalReserva')).show();

            const reserva = await reservaServicios.obtenerPorId(id);

            document.getElementById('id').value = reserva.id;
            document.getElementById('fecha_reserva').value = reserva.fecha_reserva.substring(0, 10);
            document.getElementById('fecha_devolucion').value = reserva.fecha_devolucion ?
                reserva.fecha_devolucion.substring(0, 10) :
                '';
            document.getElementById('estado').value = reserva.estado;
            document.getElementById('tituloModalReserva').textContent = 'Editar Reserva';

            await listarSocios(reserva.socio_id);
            await listarLibros(reserva.libro_id);

        } catch (error) {
            console.log(error);
        } finally {
            Loading.hide();
        }
    }

    // ============================
    // ELIMINAR RESERVA
    // ============================
    async function eliminarReserva(id) {
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

            const response = await reservaServicios.eliminar(id);
            const resultado = await response.json();

            await listarReservas();

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
        .getElementById("formReserva")
        .addEventListener("submit", async function(e) {
            e.preventDefault();

            try {
                Loading.show();

                const id = document.getElementById("id").value;
                const data = new FormData(this);

                const response = id ?
                    await reservaServicios.actualizar(id, data) :
                    await reservaServicios.crear(data);

                const resultado = await response.json();

                if (response.ok) {
                    this.reset();
                    bootstrap.Modal
                        .getOrCreateInstance(
                            document.getElementById("modalReserva")
                        )
                        .hide();
                    await listarReservas();
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
        listarReservas()
    );
</script>