<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

include '../conexion.php';

$survey_id = $_GET['id'];

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Respuestas');

$sheet->setCellValue('A1', 'Encuesta Respondida');
$sheet->setCellValue('B1', 'Pregunta');
$sheet->setCellValue('C1', 'Respuestas');

$sheet->getStyle('A1:C1')->getFont()->setBold(true);
$sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('B1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('C1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

$row_num = 2;
$previous_response = null;

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

        // Apply border styles
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $sheet->getStyle('A' . $row_num . ':C' . $row_num)->applyFromArray($styleArray);

        // Center align columns A and B, left align column C
        $sheet->getStyle('A' . $row_num)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B' . $row_num)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C' . $row_num)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        // Apply thick border to the first row of a new response_id group
        if ($previous_response !== $response_id) {
            $sheet->getStyle('A' . $row_num . ':C' . $row_num)->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THICK);
            $previous_response = $response_id;
        }

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
