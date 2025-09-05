<?php
include 'conexion.php';

$sql = "
CREATE TABLE IF NOT EXISTS respuestas_texto (
    id_respuesta_texto INT AUTO_INCREMENT PRIMARY KEY,
    id_pregunta INT NOT NULL,
    id_usuario VARCHAR(15) NOT NULL,
    respuesta_texto TEXT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_pregunta) REFERENCES preguntas(id_pregunta) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
";

if ($con->query($sql) === TRUE) {
    echo "Tabla respuestas_texto creada exitosamente.";
} else {
    echo "Error al crear tabla: " . $con->error;
}

$con->close();
?>
