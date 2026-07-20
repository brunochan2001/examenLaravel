<div class="modal fade" id="modalReserva" tabindex="-1" aria-labelledby="crearReservaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="tituloModalReserva">Nueva Reserva</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formReserva">
                <div class="modal-body">
                    <input type="hidden" id="id">
                    <div class="mb-3">
                        <label for="socio_id" class="form-label">Socio</label>
                        <select class="form-select" id="socio_id" name="socio_id" required>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="libro_id" class="form-label">Libro</label>
                        <select class="form-select" id="libro_id" name="libro_id" required>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_reserva" class="form-label">Fecha de reserva</label>
                        <input
                            type="date"
                            class="form-control"
                            id="fecha_reserva"
                            name="fecha_reserva"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_devolucion" class="form-label">Fecha de devolución</label>
                        <input
                            type="date"
                            class="form-control"
                            id="fecha_devolucion"
                            name="fecha_devolucion">
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado">
                            <option value="pendiente">Pendiente</option>
                            <option value="devuelta">Devuelta</option>
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