<?php

if (isset($_POST['id_usuario']) && isset($_POST['titulo']) && isset($_POST['descripcion']) && isset($_POST['fecha_final'])) {
    // Incluir archivo de conexión a base de datos
    include("../../conexion.php");

    // Establecemos la zona horario
    date_default_timezone_set("America/Lima");
  	$date = new DateTime();
  	$fecha_inicio = $_POST['fecha_final'];

    // Obtener valores
    $id_usuario  = $_POST['id_usuario'];
    $titulo      = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha_final = $_POST['fecha_final'];

    $query = "INSERT INTO encuestas (id_usuario, titulo, descripcion, estado, fecha_inicio, fecha_final)
              VALUES ('$id_usuario', '$titulo', '$descripcion', '0', '$fecha_inicio', '$fecha_final')";

    $resultado = $con->query($query);

    if ($resultado) {
        $id_encuesta = $con->insert_id;
        echo json_encode(array('status' => 'success', 'id_encuesta' => $id_encuesta, 'message' => 'Encuesta agregada correctamente.'));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Error al agregar la encuesta: ' . $con->error));
    }

}
