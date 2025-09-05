<?php

if (isset($_POST['id_encuesta']) && isset($_POST['titulo']) && isset($_POST['id_tipo_pregunta'])) {
    // Incluir archivo de conexión a base de datos
    include("../../conexion.php");

    // Obtener valores
    $id_encuesta 		= $_POST['id_encuesta'];
    $titulo     		= $_POST['titulo'];
    $id_tipo_pregunta 	= $_POST['id_tipo_pregunta'];
    $limite_opciones 	= isset($_POST['limite_opciones']) && !empty($_POST['limite_opciones']) ? $_POST['limite_opciones'] : NULL;

    $query = "INSERT INTO preguntas (id_encuesta, titulo, id_tipo_pregunta, limite_opciones)
              VALUES ('$id_encuesta', '$titulo', '$id_tipo_pregunta', " . ($limite_opciones !== NULL ? "'$limite_opciones'" : "NULL") . ")";

    $resultado = $con->query($query);

    if ($resultado) {
        echo json_encode(array('status' => 'success', 'message' => 'Pregunta agregada correctamente.'));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Error al agregar la pregunta: ' . $con->error));
    }

} else {
    echo json_encode(array('status' => 'error', 'message' => 'Datos incompletos.'));
}
