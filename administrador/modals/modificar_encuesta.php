<div class="modal fade " id="modal_modificar" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
            	<h4 class="modal-title">Modificar Producto</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

            	<div class="form-floating mb-3">
      					<input type="text" class="form-control" id="modificar_titulo" placeholder="Título">
      					<label for="modificar_titulo">Título</label>
      				</div>

              <div class="form-floating mb-3">
                <textarea class="form-control" id="modificar_descripcion" placeholder="Descripción" style="height: 100px;"></textarea>
                <label for="modificar_descripcion">Descripción</label>
              </div>

              <div class="form-floating mb-3">
                <input type="text" class="form-control" id="modificar_fecha_final" placeholder="Fecha de Creación" autocomplete="off"
                value="<?php echo $fecha_inicio ?>" readonly>
                <label for="modificar_fecha_final">Fecha de Creación</label>
              </div>
              <p>Formato: año-mes-día horas:minutos:segundos</p>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="modificarDetallesEncuesta()">Modificar Encuesta</button>
                <input type="hidden" id="hidden_id_encuesta">
            </div>

        </div>
    </div>
</div>
