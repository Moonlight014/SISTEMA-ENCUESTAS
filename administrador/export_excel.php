<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

include '../conexion.php';

$survey_id = $_GET['id'];

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Respuestas');

$sheet->setCellValue('A1', 'Pregunta');
$sheet->setCellValue('B1', 'Respuesta');

$row_num = 2;

$q = $con->query("
    SELECT
        p.titulo AS Pregunta,
        o.valor AS Respuesta
    FROM resultados r
    JOIN opciones o ON r.id_opcion = o.id_opcion
    JOIN preguntas p ON o.id_pregunta = p.id_pregunta
    WHERE p.id_encuesta = $survey_id
");

if ($q) {
    while ($row = $q->fetch_assoc()) {
        $sheet->setCellValue('A' . $row_num, $row['Pregunta']);
        $sheet->setCellValue('B' . $row_num, $row['Respuesta']);
        $row_num++;
    }
}

// Lógica para autoajustar el ancho de las columnas
// Obtiene la última columna de la hoja de cálculo
$lastColumn = $sheet->getHighestColumn();
// Itera desde la columna 'A' hasta la última columna con datos
for ($column = 'A'; $column <= $lastColumn; $column++) {
    $sheet->getColumnDimension($column)->setAutoSize(true);
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="respuestas_encuesta_' . $survey_id . '.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

exit;