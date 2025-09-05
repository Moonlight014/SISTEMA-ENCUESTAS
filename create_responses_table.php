<?php
include 'conexion.php';

$sql = "CREATE TABLE IF NOT EXISTS `responses` (
  `id_response` int(11) NOT NULL AUTO_INCREMENT,
  `id_encuesta` int(11) NOT NULL,
  `response_id` varchar(36) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_response`),
  UNIQUE KEY `unique_response` (`id_encuesta`, `response_id`),
  KEY `id_encuesta` (`id_encuesta`),
  CONSTRAINT `responses_ibfk_1` FOREIGN KEY (`id_encuesta`) REFERENCES `encuestas` (`id_encuesta`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

if ($con->query($sql) === TRUE) {
    echo "Tabla responses creada exitosamente.";
} else {
    echo "Error al crear tabla responses: " . $con->error;
}

$con->close();
?>
