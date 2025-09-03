<?php

// Incluimos el archivo de conexión a base de datos
include ("../../conexion.php");

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
                <th>ID encuesta</th>
                <th>Título</th>
                <th width="100">Descripción</th>
                <th>Estado</th>
                <th>Fecha Inicio</th>
                <th>Fecha Final</th>
                <th>Accciones</th>
            </tr>
        </thead>';

$query = "SELECT * FROM encuestas ORDER BY id_encuesta DESC";
$resultado = $con->query($query);

while ($row = $resultado->fetch_assoc()) {
    $data .= '
        <tbody>
            <tr>
                <td>' . $row["id_encuesta"] . '</td>
                <td width="100">' . mb_strimwidth($row['titulo'], 0, 20, "...") . '</a></td>
                <td width="100">' . mb_strimwidth($row["descripcion"], 0, 20, "...") . '</td>
                <td>' . $row["estado"] . '</td>
                <td>' . $row["fecha_inicio"] . '</td>
                <td>' . $row["fecha_final"] . '</td>
                <td>
                <a href="mostrar_preguntas.php?id_encuesta=' . $row['id_encuesta'] . '"><button class="btn btn-info type="button">Detalles</button></a>
                    <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fa fa-bars fa-lg"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        <button onclick="obtenerDetallesEncuesta(' . $row['id_encuesta'] . ')" class="dropdown-item btn btn-warning">Modificar</button>
                        <button onclick="eliminarEncuesta(' . $row['id_encuesta'] . ')" class="dropdown-item btn btn-danger">Eliminar</button>
                        <button onclick="publicarEncuesta(' . $row['id_encuesta'] . ')" class="dropdown-item btn btn-primary">Publicar</button>
                        <button onclick="finalizarEncuesta(' . $row['id_encuesta'] . ')" class="dropdown-item btn btn-secondary">Finalizar</button>

                        <a class="dropdown-item btn btn-secondary" href="vista_previa.php?id_encuesta=' . $row['id_encuesta'] . '">Vista Previa</a>

                        <a class="dropdown-item btn btn-secondary" href="resultados.php?id_encuesta=' . $row['id_encuesta'] . '">Resultados</a>
                    </div>
                    
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