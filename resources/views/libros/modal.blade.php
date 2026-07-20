<div class="modal fade" id="modalLibro" tabindex="-1" aria-labelledby="crearLibroLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="tituloModalLibro"> Nuevo Libro</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form id="formLibro">
                <div class="modal-body">
                    <input type="hidden" id="id">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input
                            type="text"
                            class="form-control"
                            id="titulo"
                            name="titulo"
                            placeholder="Clean Code"
                            maxlength="255"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea
                            class="form-control"
                            id="descripcion"
                            name="descripcion"
                            rows="3"
                            placeholder="Descripción del libro">
                        </textarea>
                    </div>
                    <div class="mb-3">
                        <label for="paginas" class="form-label">Páginas</label>
                        <input
                            type="number"
                            class="form-control"
                            id="paginas"
                            name="paginas"
                            placeholder="464"
                            min="1"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stock</label>
                        <input
                            type="number"
                            class="form-control"
                            id="stock"
                            name="stock"
                            placeholder="10"
                            min="0"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_publicacion" class="form-label">Fecha de publicación</label>
                        <input
                            type="date"
                            class="form-control"
                            id="fecha_publicacion"
                            name="fecha_publicacion"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="idioma" class="form-label">Idioma</label>
                        <input
                            type="text"
                            class="form-control"
                            id="idioma"
                            name="idioma"
                            placeholder="Español"
                            maxlength="100"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="autor_ids" class="form-label">Autores</label>
                        <select
                            class="form-select"
                            id="autor_ids"
                            name="autor_ids[]"
                            multiple>
                        </select>
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