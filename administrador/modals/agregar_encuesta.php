<div class="modal fade" id="modal_agregar" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
            	<h4 class="modal-title">Agregar Nueva Encuesta</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <!-- Step Indicator -->
                <ul class="nav nav-tabs" id="stepTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="step1-tab" data-toggle="tab" href="#step1" role="tab">Paso 1: Detalles de Encuesta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="step2-tab" data-toggle="tab" href="#step2" role="tab">Paso 2: Agregar Preguntas</a>
                    </li>
                </ul>

                <div class="tab-content" id="stepContent">
                    <!-- Step 1: Survey Details -->
                    <div class="tab-pane fade show active" id="step1" role="tabpanel">
                        <br>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="titulo" placeholder="Título" autocomplete="off" autofocus>
                            <label for="titulo">Título</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="descripcion" placeholder="Descripción" style="height: 100px;"></textarea>
                            <label for="descripcion">Descripción</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="fecha_final" placeholder="Fecha de Creación" value="<?php echo $fecha_inicio ?>" autocomplete="off" readonly>
                            <label for="fecha_final">Fecha de Creación</label>
                        </div>
                        <p>Formato: año-mes-día horas:minutos:segundos</p>
                    </div>

                    <!-- Step 2: Add Questions -->
                    <div class="tab-pane fade" id="step2" role="tabpanel">
                        <br>
                        <p>Aquí puedes agregar preguntas a la encuesta. Haz clic en "Agregar Pregunta" para añadir más.</p>
                        <div id="questions-container">
                            <!-- Questions will be added here dynamically -->
                        </div>
                        <button type="button" class="btn btn-secondary" id="addQuestionBtn">Agregar Pregunta</button>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-secondary" id="prevBtn" style="display:none;">Anterior</button>
                <button type="button" class="btn btn-primary" id="nextBtn">Siguiente</button>
                <button type="button" class="btn btn-success" id="finishBtn" style="display:none;">Finalizar</button>
                <input type="hidden" id="hidden_id_usuario" value="<?php echo $_SESSION['id_usuario'] ?>">
                <input type="hidden" id="hidden_id_encuesta">
            </div>

        </div>
    </div>
</div>

<!-- Warning Modal -->
<div class="modal fade" id="modal_warning" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Advertencia</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Por favor complete todos los campos del Paso 1 antes de continuar.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Volver</button>
            </div>
        </div>
    </div>
</div>
