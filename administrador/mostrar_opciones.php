<?php

include("../conexion.php") ;

$id_pregunta = $_GET['id_pregunta'];

$query = "SELECT * FROM preguntas WHERE id_pregunta = '$id_pregunta'";
$respuesta = $con->query($query);
$row = $respuesta->fetch_assoc();


 ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- Favicon - FIS -->
    <link rel="shortcut icon" href="../imagenes/Logo-fis.png">

    <link rel="stylesheet" href="../css/main.css">

    <link rel="stylesheet" href="../plugins/font-awesome/css/font-awesome.min.css">

    <title>ADMIN-Opciones</title>
</head>
<body>

<?php
    require '../navbar.php';
?>

  <!-- Content Section -->
  <div class="container" style="margin-top: 30px;">
      <div class="row">
          <div class="col-md-12 row">
            <div class="col-md-10 col-xs-12">
              <h3><?php echo $row['titulo'] ?></h3>
            </div>
            <br>
            <br>
            <div class="col-12">
               <button class="float-right btn btn-info col-12" id="boton_agregar">
                  <b>Agregar Opción</b>
                </button>
            </div>
          </div>
      </div>
      <hr/>
      <div class="row">
          <div class="col-md-12">
              <h4>Opciones:</h4>
              <input type="hidden" id="id_pregunta" value="<?php echo $row['id_pregunta'] ?>">
              <div class="table-responsive">
                <div id="tabla_opciones"></div>
              </div>
          </div>
      </div>
      <a href="javascript: history.go(-1)" class="btn btn-danger btn-lg btn-blockimage.png">Regresar</a>
  </div>
  <!-- /Content Section -->


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="../js/jquery-3.3.1.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="js/opciones.js"></script>
 

</body>
</html>

<!-- Modal Agregar Nueva Opción -->
<div class="modal fade" id="modal_agregar" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
              <h4 class="modal-title">Agregar Nueva Opción</h4>
              <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <div class="form-group row">
                <label for="valor" class="col-sm-3 col-form-label">Valor</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="valor" placeholder="Valor" autocomplete="off" autofocus>
                </div>
              </div>         
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="agregarOpcion()">Agregar Opción</button>
            </div>

        </div>
    </div>
</div>

<!-- Modal Modificar Pregunta -->
<div class="modal fade" id="modal_modificar" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
              <h4 class="modal-title">Modificar Opción</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
              <div class="form-group row">
                <label for="modificar_valor" class="col-sm-3 col-form-label">Valor</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="modificar_valor" placeholder="Valor">
                </div>
              </div>           
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="modificarDetallesOpcion()">Modificar Opción</button>
                <input type="hidden" id="hidden_id_opcion">
            </div>

        </div>
    </div>
</div>