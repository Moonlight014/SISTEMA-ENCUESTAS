<?php
include 'conexion.php';

$result = $con->query("SHOW COLUMNS FROM resultados LIKE 'id_usuario'");
if ($result->num_rows == 0) {
    $sql1 = "ALTER TABLE resultados ADD COLUMN id_usuario VARCHAR(15) NULL DEFAULT NULL";
    if ($con->query($sql1) === TRUE) {
        echo "Columna id_usuario agregada a resultados exitosamente.<br/>";
    } else {
        echo "Error al agregar columna id_usuario: " . $con->error . "<br/>";
    }
} else {
    echo "Columna id_usuario ya existe en resultados.<br/>";
}

$result2 = $con->query("SHOW COLUMNS FROM resultados LIKE 'response_id'");
if ($result2->num_rows == 0) {
    $sql2 = "ALTER TABLE resultados ADD COLUMN response_id VARCHAR(36) NULL DEFAULT NULL";
    if ($con->query($sql2) === TRUE) {
        echo "Columna response_id agregada a resultados exitosamente.<br/>";
    } else {
        echo "Error al agregar columna response_id: " . $con->error . "<br/>";
    }
} else {
    echo "Columna response_id ya existe en resultados.<br/>";
}

$con->close();
?>
