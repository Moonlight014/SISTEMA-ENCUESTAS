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

$sheet->setCellValue('A1', 'Encuesta Respondida');
$sheet->setCellValue('B1', 'Pregunta');
$sheet->setCellValue('C1', 'Respuestas');

$row_num = 2;

$response_sets_query = $con->query("
    SELECT DISTINCT r.response_id, p.id_encuesta
    FROM resultados r
    JOIN opciones o ON r.id_opcion = o.id_opcion
    JOIN preguntas p ON o.id_pregunta = p.id_pregunta
    WHERE p.id_encuesta = $survey_id
    UNION
    SELECT DISTINCT rt.response_id, p.id_encuesta
    FROM respuestas_texto rt
    JOIN preguntas p ON rt.id_pregunta = p.id_pregunta
    WHERE p.id_encuesta = $survey_id
");

while ($response_set = $response_sets_query->fetch_assoc()) {
    $response_id = $response_set['response_id'];
    $id_encuesta = $response_set['id_encuesta'];

    $questions_query = $con->query("SELECT id_pregunta, titulo FROM preguntas WHERE id_encuesta = $id_encuesta");

    $answers_map = [];

    $options_query = $con->query("
        SELECT p.id_pregunta, o.valor
        FROM resultados r
        JOIN opciones o ON r.id_opcion = o.id_opcion
        JOIN preguntas p ON o.id_pregunta = p.id_pregunta
        WHERE r.response_id = '$response_id' AND p.id_encuesta = $id_encuesta
    ");

    while ($option = $options_query->fetch_assoc()) {
        $qid = $option['id_pregunta'];
        if (!isset($answers_map[$qid])) {
            $answers_map[$qid] = [];
        }
        $answers_map[$qid][] = $option['valor'];
    }

    $text_query = $con->query("
        SELECT id_pregunta, respuesta_texto
        FROM respuestas_texto
        WHERE response_id = '$response_id' AND id_pregunta IN (SELECT id_pregunta FROM preguntas WHERE id_encuesta = $id_encuesta)
    ");

    while ($text = $text_query->fetch_assoc()) {
        $qid = $text['id_pregunta'];
        if (!isset($answers_map[$qid])) {
            $answers_map[$qid] = [];
        }
        $answers_map[$qid][] = $text['respuesta_texto'];
    }

    while ($question = $questions_query->fetch_assoc()) {
        $question_id = $question['id_pregunta'];
        $question_title = $question['titulo'];

        $combined_answers = '';
        if (isset($answers_map[$question_id])) {
            $combined_answers = implode(', ', $answers_map[$question_id]);
        }

        $sheet->setCellValue('A' . $row_num, $response_id);
        $sheet->setCellValue('B' . $row_num, $question_title);
        $sheet->setCellValue('C' . $row_num, $combined_answers);
        $row_num++;
    }
}

// autoajustar el ancho de las columnas
// última columna de la hoja de cálculo
$lastColumn = $sheet->getHighestColumn();
for ($column = 'A'; $column <= $lastColumn; $column++) {
    $sheet->getColumnDimension($column)->setAutoSize(true);
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="respuestas_encuesta_' . $survey_id . '.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

exit;