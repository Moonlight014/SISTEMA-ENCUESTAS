<!DOCTYPE html>
<?php 

  date_default_timezone_set("America/Lima");
  $date = new DateTime();

  $fecha_inicio = $date->format('Y-m-d H:i:s');
  
?>


<html lang="es">
<head>



</head>

  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="css/bootstrap.min.css">

    <link rel="stylesheet" href="../css/main.css">

    <link rel="stylesheet" href="../plugins/font-awesome/css/font-awesome.min.css">

    <link rel="shortcut icon" href="../imagenes/Logo-fis.png">

  	<title>ADMIN-Encuestas</title>

    <script type="text/javascript" language="javascript">   
      history.pushState(null, null, location.href);
      window.onpopstate = function () {
        history.go(1);
      };
    </script>

</head>
<body>

<?php
    require '../includes/navbar.php';
    if (isset($_GET['error'])) {
      echo '<div class="alert alert-danger text-center">Usuario o contraseña incorrectos.</div>';
    }
?>

	<div class="container" style="margin-top: 30px;">
	    <div class="row">
	        <div class="col-md-12 row">
	        	<div class="col-md-10 col-xs-12">
	        		<h3>SISTEMA DE ENCUESTAS</h3>
	        	</div>
            <br>
            <br>
	        	<div class="col-12">
	        		 <button class="btn btn-success col-12" id="boton_agregar">
	                    <b>Agregar Encuesta</b>
	                </button>
	        	</div>
	        </div>
	    </div>
	    <hr/>
	    <div class="row">
	        <div class="col-md-12">
	            <h4>Encuestas:</h4>
	            <div class="table-responsive" style="max-height: 700px; overflow-y: auto;">
	            	<div id="tabla_encuestas"></div>
	            <br/>
	        </div>
	    </div>
	</div>

<?php include 'modals/agregar_encuesta.php'; ?>

<?php include 'modals/modificar_encuesta.php'; ?>

<script src="/php/SISTEMA_ENCUESTAS/js/jquery.min.js"></script>
<script src="/php/SISTEMA_ENCUESTAS/js/popper.min.js"></script>
<script src="/php/SISTEMA_ENCUESTAS/js/bootstrap.min.js"></script>
<script src="/php/SISTEMA_ENCUESTAS/administrador/js/encuestas.js"></script>

</body>
</html>
