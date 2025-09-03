<?php

// Incluimos el archivo de conexión a base de datos
include ("../../conexion.php");

if (isset($_POST['id_encuesta'])) {
    $id_encuesta = $_POST['id_encuesta'];
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
                <th>ID Pregunta</th>
                <th>Título</th>
                <th>Tipo</th>
                <th>Accciones</th>
            </tr>
        </thead>';

$query = "SELECT preguntas.id_pregunta, preguntas.id_encuesta, preguntas.titulo, tipo_pregunta.nombre
            FROM preguntas
            INNER JOIN tipo_pregunta
            ON preguntas.id_tipo_pregunta = tipo_pregunta.id_tipo_pregunta
            WHERE preguntas.id_encuesta = '$id_encuesta'";

$resultado = $con->query($query);

while ($row = $resultado->fetch_assoc()) {
    $data .= '
        <tbody>
            <tr>
                <td>' . $row["id_pregunta"] . '</td>
                <td>' . $row['titulo'] . '</a></td>
                <td>' . $row["nombre"] . '</td>
                <td>
                    <a href="mostrar_opciones.php?id_pregunta=' . $row['id_pregunta'] . '"><button class="btn btn-info">Respuestas <i class="fa fa-address-card-o fa-lg"></i></button></a>
                    <button onclick="obtenerDetallesPregunta(' . $row['id_pregunta'] . ')" class="btn btn-warning"> <i class="fa fa-edit fa-lg"></i></button>
                    <button onclick="eliminarPregunta(' . $row['id_pregunta'] . ')" class="btn btn-danger"> <i class="fa fa-trash fa-lg"></i></button>
                    
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