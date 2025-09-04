<?php
// Incluye el archivo de autoloading de Composer.
// Esto es necesario para usar la librería PhpSpreadsheet.
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Incluye el archivo de conexión a la base de datos
include '../conexion.php';

// Obtiene el ID de la encuesta de la URL
$survey_id = $_GET['id'];

// Crea un nuevo objeto de hoja de cálculo
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Respuestas');

// Escribe los encabezados en la primera fila (celda A1 y B1)
$sheet->setCellValue('A1', 'Pregunta');
$sheet->setCellValue('B1', 'Respuesta');

// Define la fila inicial para los datos
$row_num = 2;

// Consulta SQL para obtener las respuestas
$q = $con->query("
    SELECT
        p.titulo AS Pregunta,
        o.valor AS Respuesta
    FROM resultados r
    JOIN opciones o ON r.id_opcion = o.id_opcion
    JOIN preguntas p ON o.id_pregunta = p.id_pregunta
    WHERE p.id_encuesta = $survey_id
");

// Verifica si la consulta fue exitosa
if ($q) {
    // Itera sobre los resultados de la base de datos
    while ($row = $q->fetch_assoc()) {
        // Escribe los datos en las celdas de la hoja de cálculo
        $sheet->setCellValue('A' . $row_num, $row['Pregunta']);
        $sheet->setCellValue('B' . $row_num, $row['Respuesta']);
        // Incrementa el número de fila para la siguiente entrada
        $row_num++;
    }
}

// Configura las cabeceras HTTP para forzar la descarga del archivo XLSX
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="respuestas_encuesta_' . $survey_id . '.xlsx"');
header('Cache-Control: max-age=0');

// Crea un objeto para escribir el archivo XLSX y lo guarda en la salida
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

// Detiene la ejecución del script
exit;
?>