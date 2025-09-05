<?php
include 'conexion.php';

$sql = "CREATE TABLE IF NOT EXISTS respuestas_anonimas (
    id_response INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_encuesta INT NOT NULL,
    response_id VARCHAR(36) NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_response (response_id),
    FOREIGN KEY (id_encuesta) REFERENCES encuestas(id_encuesta) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

if ($con->query($sql) === TRUE) {
    echo "Tabla respuestas_anonimas creada exitosamente.";
} else {
    echo "Error al crear la tabla: " . $con->error;
}

$con->close();
?>
