<?php

// Incluimos el archivo de conexión a base de datos
include ("../../conexion.php");

if (isset($_POST['id_pregunta'])) {
    $id_pregunta = $_POST['id_pregunta'];
}

// Diseñamos el encabezado de la tabla
$data = '

<div class="mask d-flex align-items-center h-100">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card shadow-2-strong" style="background-color: #f5f7fa;">
              <div class="card-body">
                <div class="table-responsive">

    <table class="table table-bordered table-hover table-condensed">
        <thead class="thead-light">
            <tr>
                <th>ID opción</th>
                <th>ID pregunta</th>
                <th>Valor</th>
                <th>Accciones</th>
            </tr>
        </thead>';

$query = "SELECT * FROM opciones WHERE id_pregunta = '$id_pregunta'";

$resultado = $con->query($query);

while ($row = $resultado->fetch_assoc()) {
    $data .= '
        <tbody>
            <tr>
                <td>' . $row["id_opcion"] . '</td>
                <td>' . $row["id_pregunta"] . '</td>
                <td>' . $row["valor"] . '</td>
                <td>
                    <button onclick="obtenerDetallesOpcion(' . $row['id_opcion'] . ')" class="btn btn-warning"><i class="fa fa-edit fa-lg"></i></button>
                    <button onclick="eliminarOpcion(' . $row['id_opcion'] . ')" class="btn btn-danger"><i class="fa fa-trash fa-lg"></i></button>
                </td>
            </tr>
        </tbody>
        
        </div>
        
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
        
        
        ';
}

$data .= '</table>';

echo $data; 