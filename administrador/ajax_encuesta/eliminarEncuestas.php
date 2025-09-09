<?php
include("../../conexion.php");

if (isset($_POST['ids'])) {
    $ids = $_POST['ids'];
    if (!is_array($ids)) {
        $ids = json_decode($ids, true);
    }
    if (is_array($ids)) {
        $ids = array_map('intval', $ids);

        if (count($ids) > 0) {
            $ids_list = implode(',', $ids);
            $query = "DELETE FROM encuestas WHERE id_encuesta IN ($ids_list)";
            if ($con->query($query) === TRUE) {
                echo json_encode(['status' => 'success', 'message' => 'Encuestas eliminadas correctamente.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al eliminar encuestas: ' . $con->error]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se proporcionaron IDs válidos.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Formato de IDs inválido.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No se recibieron IDs.']);
}
?>
