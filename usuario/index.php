<?php 

  date_default_timezone_set("America/Lima");
  $date = new DateTime();

  $fecha_inicio = $date->format('Y-m-d H:i:s');
  
 ?>


<!DOCTYPE html>
<html lang="es">
<head>
    <!--JQUERY-->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  	<!-- Required meta tags -->
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  	<!-- Bootstrap CSS -->
  	<link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- Favicon - FIS -->
    <link rel="shortcut icon" href="../imagenes/Logo-fis.png">

    <link rel="stylesheet" href="../css/main.css">

	<link rel="stylesheet" href="../plugins/font-awesome/css/font-awesome.min.css">

  	<title>USUARIO-Encuestas</title>
    <script type="text/javascript" language="javascript">   
      history.pushState(null, null, location.href);
      window.onpopstate = function () {
        history.go(1);
      };
    </script>

</head>
<body>


<?php
    require '../navbar.php';
?>

	<!-- Content Section -->
	<div class="container" style="margin-top: 30px;">
	    <div class="row">
	        <div class="col-md-12 row">
	        	<div class="col-md-12 col-xs-12">
	        		<h3>SISTEMA DE ENCUESTAS</h3>
	        	</div>
	        </div>
	    </div>
	    <hr/>
	    <div class="row">
	        <div class="col-md-12">
	         <h4>Encuestas:</h4>
	         <div class="table-responsive card">
	            <div id="tabla_encuestas"></div>
	         </div>
	        </div>
	    </div>
	</div>
	<!-- /Content Section -->


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="../js/jquery-3.3.1.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="js/encuestas.js"></script>
 
</body>
</html>