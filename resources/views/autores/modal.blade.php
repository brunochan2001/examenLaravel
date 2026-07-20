<div class="modal fade" id="modalAutor" tabindex="-1" aria-labelledby="crearAutorLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="tituloModal">Nuevo Autor</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formAutor">
                <div class="modal-body">
                    <input type="hidden" id="id">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input
                            type="text"
                            class="form-control"
                            id="nombre"
                            name="nombre"
                            placeholder="Luis"
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
                            placeholder="Torres"
                            maxlength="255"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="nacionalidad" class="form-label">Nacionalidad</label>
                        <input
                            type="text"
                            class="form-control"
                            id="nacionalidad"
                            name="nacionalidad"
                            placeholder="Peruana"
                            maxlength="255">
                    </div>
                    <div class="mb-3">
                        <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
                        <input
                            type="date"
                            class="form-control"
                            id="fecha_nacimiento"
                            name="fecha_nacimiento">
                    </div>
                    <div class="mb-3">
                        <label for="libro_ids" class="form-label">Libros</label>
                        <select class="form-select" id="libro_ids" name="libro_ids[]" multiple>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar<i class="fa-solid fa-floppy-disk"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>