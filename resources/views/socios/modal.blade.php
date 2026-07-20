<div class="modal fade" id="modalSocio" tabindex="-1" aria-labelledby="crearSocioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="tituloModalSocio">Nuevo Socio</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formSocio">
                <div class="modal-body">
                    <input type="hidden" id="id">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input
                            type="text"
                            class="form-control"
                            id="nombre"
                            name="nombre"
                            placeholder="Juan"
                            maxlength="255"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input
                            type="text"
                            class="form-control"
                            id="apellido"
                            name="apellido"
                            placeholder="Pérez"
                            maxlength="255"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="dni" class="form-label">DNI</label>
                        <input
                            type="text"
                            class="form-control"
                            id="dni"
                            name="dni"
                            placeholder="12345678"
                            maxlength="20"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input
                            type="email"
                            class="form-control"
                            id="email"
                            name="email"
                            placeholder="juan@email.com"
                            maxlength="255">
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input
                            type="text"
                            class="form-control"
                            id="telefono"
                            name="telefono"
                            placeholder="987654321"
                            maxlength="20">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar <i class="fa-solid fa-floppy-disk"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>