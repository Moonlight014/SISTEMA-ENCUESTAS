<?php

include("../../conexion.php");

if (isset($_POST)) {
    // Obtener valores
    $id_pregunta    = $_POST['id_pregunta'];
    $titulo         = $_POST['titulo'];
    $limite_opciones = isset($_POST['limite_opciones']) ? $_POST['limite_opciones'] : NULL;

    // Modificar producto
    $query = "
        UPDATE preguntas SET
        titulo  = '$titulo',
        limite_opciones = " . ($limite_opciones ? "'$limite_opciones'" : "NULL") . "
        WHERE id_pregunta   = '$id_pregunta'
    ";

    if (!$result = mysqli_query($con, $query)) {
        exit(mysqli_error($con));
    }
}
