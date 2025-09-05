<?php
include 'conexion.php';

$sql = "INSERT INTO tipo_pregunta (id_tipo_pregunta, nombre, descripcion) VALUES (5, 'Opción única', 'Se podrá escoger solo una opción\r\nElemento input type radio')";

if ($con->query($sql) === TRUE) {
    echo "Nuevo tipo de pregunta agregado exitosamente.";
} else {
    echo "Error al agregar tipo: " . $con->error;
}

$con->close();
?>
