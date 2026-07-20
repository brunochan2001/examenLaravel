<div class="modal fade" id="modalAutoria" tabindex="-1" aria-labelledby="crearAutoriaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="tituloModalAutoria">Nueva Autoría</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formAutoria">
                <div class="modal-body">
                    <input type="hidden" id="id">
                    <div class="mb-3">
                        <label for="autor_id" class="form-label">Autor</label>
                        <select class="form-select" id="autor_id" name="autor_id" required>
                            <option value="">Seleccione un autor</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="libro_id" class="form-label">Libro</label>
                        <select class="form-select" id="libro_id" name="libro_id" required>
                            <option value="">Seleccione un libro</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">
                        Guardar
                        <i class="fa-solid fa-floppy-disk"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>