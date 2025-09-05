<?php
include 'conexion.php';

$sql = "UPDATE tipo_pregunta SET descripcion = 'Se podrá escoger múltiples opciones con límite elemento input type checkbox' WHERE id_tipo_pregunta = 1";

if ($con->query($sql) === TRUE) {
    echo "Descripción actualizada.";
} else {
    echo "Error: " . $con->error;
}

$con->close();
?>
