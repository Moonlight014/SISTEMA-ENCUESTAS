<?php
include 'conexion.php';

// Make id_usuario nullable
$sql1 = "ALTER TABLE respuestas_texto MODIFY COLUMN id_usuario VARCHAR(15) NULL DEFAULT NULL";
if ($con->query($sql1) === TRUE) {
    echo "Columna id_usuario modificada en respuestas_texto exitosamente.<br/>";
} else {
    echo "Error al modificar columna id_usuario: " . $con->error . "<br/>";
}

// Add response_id column
$sql2 = "ALTER TABLE respuestas_texto ADD COLUMN response_id VARCHAR(36) NULL DEFAULT NULL";
if ($con->query($sql2) === TRUE) {
    echo "Columna response_id agregada a respuestas_texto exitosamente.<br/>";
} else {
    echo "Error al agregar columna response_id: " . $con->error . "<br/>";
}

$con->close();
?>
