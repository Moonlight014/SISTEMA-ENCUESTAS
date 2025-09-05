<?php
include 'conexion.php';

$sql = "ALTER TABLE preguntas ADD COLUMN limite_opciones INT NULL DEFAULT NULL";

if ($con->query($sql) === TRUE) {
    echo "Columna limite_opciones agregada exitosamente.";
} else {
    echo "Error al agregar columna: " . $con->error;
}

$con->close();
?>
