// Cargar modal de boostrap para agregar nueva encuesta
// Usaremos el "shorter method"
$(function() {
	$("#boton_agregar").click(function() {
		$("#modal_agregar").modal("show");
	});
});

// Mostrar encuestas
function mostrarEncuestas() {
    // Mostrar encuestas con el método ajax POST
    $.post("ajax_encuesta/mostrarEncuestas.php", {}, function(data, status) {
        $("#tabla_encuestas").html(data);
    });
}

// Mostrar encuestas al cargar la página
$(function() {
    mostrarEncuestas(); // Llamando a la función
});

// Agregar nueva encuesta (Paso 1)
function agregarEncuesta() {
    // Obtener los valores de los inputs
    var id_usuario  = $("#hidden_id_usuario").val();
    var titulo      = $("#titulo").val();
    var descripcion = $("#descripcion").val();
    var fecha_final = $("#fecha_final").val();
    // Agregar encuesta con el método ajax POST
    $.post("ajax_encuesta/agregarEncuesta.php",
        {
            titulo      : titulo,
            descripcion : descripcion,
            fecha_final : fecha_final,
            id_usuario  : id_usuario
        },
        function (data, status) {
            var response = JSON.parse(data);
            if (response.status === 'success') {
                // Guardar el id_encuesta
                $("#hidden_id_encuesta").val(response.id_encuesta);
                // Ir al paso 2
                showStep2();
            } else {
                alert("Error: " + response.message);
            }
        }
    ) ;
}

// Eliminar encuesta
function eliminarEncuesta(id_encuesta) {
    var conf = confirm("Estas seguro de eliminar la Encuesta");
    if (conf == true) {
        // Eliminar encuesta con el método ajax POST
        $.post("ajax_encuesta/eliminarEncuesta.php", {id_encuesta: id_encuesta}, function (data, status) {
            // Volver a cargar la tabla de encuestas
            mostrarEncuestas();
        });
    }
}

function eliminarEncuestasSeleccionadas() {
    var ids = [];
    $(".selectEncuesta:checked").each(function() {
        ids.push($(this).val());
    });

    if (ids.length === 0) {
        alert("Por favor seleccione al menos una encuesta para eliminar.");
        return;
    }

    var conf = confirm("¿Está seguro de eliminar las encuestas seleccionadas?");
    if (!conf) return;

    $.post("ajax_encuesta/eliminarEncuestas.php", {ids: ids}, function(response) {
        var res = JSON.parse(response);
        if (res.status === "success") {
            alert(res.message);
            mostrarEncuestas();
        } else {
            alert("Error: " + res.message);
        }
    });
}

function toggleSelectAll(source) {
    $(".selectEncuesta").prop('checked', source.checked);
}

// Publicar encuesta
function publicarEncuesta(id_encuesta) {
    var conf = confirm("Estas seguro de publicar la Encuesta");
    if (conf == true) {
        // Publicar encuesta con el método ajax POST
        $.post("ajax_encuesta/publicarEncuesta.php", {id_encuesta: id_encuesta}, function (data, status) {
            // Volver a cargar la tabla de encuestas
            mostrarEncuestas();
        });
    }
}

// Finalizar encuesta
function finalizarEncuesta(id_encuesta) {
    var conf = confirm("Estas seguro de finalizar la Encuesta");
    if (conf == true) {
        // Publicar encuesta con el método ajax POST
        $.post("ajax_encuesta/finalizarEncuesta.php", {id_encuesta: id_encuesta}, function (data, status) {
            // Volver a cargar la tabla de encuestas
            mostrarEncuestas();
        });
    }
}

function obtenerDetallesEncuesta(id_encuesta) {
    // Agregar id_encuesta al campo oculto
    $("#hidden_id_encuesta").val(id_encuesta);

    $.post("ajax_encuesta/mostrarDetallesEncuesta.php", {id_encuesta: id_encuesta}, function (data, status) {
        // PARSE json data
        var encuesta = JSON.parse(data);
        // Asignamos valores de la encuesta al modal
        $("#modificar_titulo").val(encuesta.titulo);
        $("#modificar_descripcion").val(encuesta.descripcion);
        $("#modificar_fecha_final").val(encuesta.fecha_final);
    });
    // Abrir modal de modificar
    $("#modal_modificar").modal("show");
}

// Funcion modificarDetallesEncuesta del modal modificar producto
function modificarDetallesEncuesta() {
    // Obtener valores
    var titulo      = $("#modificar_titulo").val();
    var id_encuesta = $("#hidden_id_encuesta").val();
    var descripcion = $("#modificar_descripcion").val();
    var fecha_final = $("#modificar_fecha_final").val();

    // Modificar detalles consultando al servidor usando ajax
    $.post("ajax_encuesta/modificarDetallesEncuesta.php",
        {
            id_encuesta : id_encuesta,
            titulo      : titulo,
            descripcion : descripcion,
            fecha_final : fecha_final
        },
        function (data, status) {
            // Ocultar el modal utilizando jQuery
            $("#modal_modificar").modal("hide");
            // Volver a cargar la tabla productos
            mostrarEncuestas();
        }
    ) ;
}

// Multi-step modal functions
var currentStep = 1;

$(function() {
    $('#modal_agregar').on('show.bs.modal', function () {
        resetModal();
    });

    // Prevent clicking on step2-tab if step 1 not completed
    $('#step2-tab').on('click', function(e) {
        if (currentStep === 1 && (!$("#titulo").val() || !$("#descripcion").val() || !$("#fecha_final").val())) {
            e.preventDefault();
            alert("Por favor complete todos los campos del Paso 1 antes de continuar.");
        }
    });

    // Bind click events to buttons
    $("#prevBtn").click(prevStep);
    $("#nextBtn").click(nextStep);
    $("#addQuestionBtn").click(agregarCampoPregunta);
    $("#finishBtn").click(finalizarEncuesta);

function resetModal() {
    currentStep = 1;
    $('#step1-tab').addClass('active');
    $('#step2-tab').removeClass('active');
    $('#step1').addClass('show active');
    $('#step2').removeClass('show active');
    $('#prevBtn').hide();
    $('#nextBtn').show();
    $('#finishBtn').hide();
    $("#titulo").val("");
    $("#descripcion").val("");
    $("#fecha_final").val("");
    $("#hidden_id_encuesta").val("");
    $("#questions-container").empty();
}

function nextStep() {
    if (currentStep === 1) {
        // Validate step 1
    if (!$("#titulo").val() || !$("#descripcion").val() || !$("#fecha_final").val()) {
        alert("Por favor complete todos los campos del Paso 1 antes de continuar.");
        return;
    }
        agregarEncuesta();
    } else if (currentStep === 2) {
        // Go to finish
        $('#finishBtn').show();
        $('#nextBtn').hide();
    }
}

function showStep2() {
    currentStep = 2;
    $('#step1-tab').removeClass('active');
    $('#step2-tab').addClass('active');
    $('#step1').removeClass('show active');
    $('#step2').addClass('show active');
    $('#prevBtn').show();
    $('#nextBtn').hide();
    $('#finishBtn').show();
}

function prevStep() {
    if (currentStep === 2) {
        currentStep = 1;
        $('#step1-tab').addClass('active');
        $('#step2-tab').removeClass('active');
        $('#step1').addClass('show active');
        $('#step2').removeClass('show active');
        $('#prevBtn').hide();
        $('#nextBtn').show();
        $('#finishBtn').hide();
    }
}

function agregarCampoPregunta() {
    var questionIndex = $("#questions-container .question-item").length;
    var questionHtml = '<div class="question-item border p-3 mb-3">' +
        '<div class="form-group">' +
        '<label>Pregunta ' + (questionIndex + 1) + '</label>' +
        '<input type="text" class="form-control question-title" placeholder="Texto de la pregunta">' +
        '</div>' +
        '<div class="form-group">' +
        '<label>Tipo de Pregunta</label>' +
        '<select class="form-control question-type">' +
        '<option value="1">Texto abierto</option>' +
        '<option value="2">Opción múltiple</option>' +
        '<option value="3">Selección única</option>' +
        '<option value="4">Opción única</option>' +
        '<option value="5">Opción única</option>' +
        '</select>' +
        '</div>' +
        '<div class="form-group">' +
        '<label>Límite de opciones (opcional)</label>' +
        '<input type="number" class="form-control question-limit" placeholder="Límite">' +
        '</div>' +
        '<button type="button" class="btn btn-danger btn-sm" onclick="$(this).closest(\'.question-item\').remove()">Eliminar</button>' +
        '</div>';
    $("#questions-container").append(questionHtml);
}

function finalizarEncuesta() {
    var id_encuesta = $("#hidden_id_encuesta").val();
    var questions = [];

    $("#questions-container .question-item").each(function() {
        var title = $(this).find('.question-title').val();
        var type = $(this).find('.question-type').val();
        var limit = $(this).find('.question-limit').val() || null;

        if (title) {
            questions.push({
                titulo: title,
                id_tipo_pregunta: type,
                limite_opciones: limit
            });
        }
    });

    if (questions.length === 0) {
        alert("Agregue al menos una pregunta.");
        return;
    }

    // Add questions via AJAX
    var promises = questions.map(function(q) {
        return $.post("ajax_pregunta/agregarPregunta.php", {
            id_encuesta: id_encuesta,
            titulo: q.titulo,
            id_tipo_pregunta: q.id_tipo_pregunta,
            limite_opciones: q.limite_opciones
        });
    });

    $.when.apply($, promises).done(function() {
        $("#modal_agregar").modal("hide");
        mostrarEncuestas();
        alert("Encuesta y preguntas agregadas correctamente.");
    }).fail(function() {
        alert("Error al agregar algunas preguntas.");
    });
}

}); // <-- Add this closing bracket and semicolon to properly close the main $(function() { ... }) block