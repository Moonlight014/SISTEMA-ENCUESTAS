<?php 

	include '../conexion.php';
	$id_encuesta = $_GET['id_encuesta'];

	/* Consulta para extraer título y descripción de la encuesta*/
	$query3 = "SELECT * FROM encuestas WHERE id_encuesta = '$id_encuesta'";
	$resultados3 = $con->query($query3);
	$row3 = $resultados3->fetch_assoc();

 ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

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


  <title>Resultados</title>
</head>
<body>

<?php
    require '../navbar.php';
?>
	
	
	
	
				
  	<div class="container" style="margin-top: 50px;">
  		
  	<?php

  	$consulta = "SELECT * FROM preguntas WHERE id_encuesta = '$id_encuesta'";
	$resultados2 = $con->query($consulta);

	 ?>

	<hr/>
	
	<div class="container text-center">
		<h1 class="text-info"><?php echo $row3['titulo'] ?></h1>
		<p><?php echo $row3['descripcion'] ?></p>
	</div>
	<hr/>

	<?php
		$j = 1;
		while ($row2 = $resultados2->fetch_assoc()) {
		
		$id_pregunta = $row2['id_pregunta'];

		$query = "SELECT preguntas.id_pregunta, preguntas.titulo,COUNT('preguntas.titulo') as count, opciones.valor FROM opciones INNER JOIN preguntas ON opciones.id_pregunta=preguntas.id_pregunta INNER JOIN resultados ON opciones.id_opcion=resultados.id_opcion WHERE preguntas.id_pregunta = '$id_pregunta' GROUP BY opciones.valor ORDER BY preguntas.id_pregunta";
		$resultados = $con->query($query);

				/*TITULO*/
	?>
	<!--Aqui inicia la carta-->
	<div class="card"> 
		<?php
		echo "<div style='margin-left:5%; margin-top:3%';><h5>Pregunta $j: " . $row2['titulo'] . "</h5></div>";

		$cantidades = array();
		$titulos = array();
		$tamaño = array(); 
		$i = 1;
		
		while ($row = $resultados->fetch_assoc()) {
			$cantidades[$i] = 0;
			$cantidades[$i] = $row['count'];
			$titulos[$i] = $row['valor'];
			$i++;
		}

		$opciones = $i-1;
		#$opciones = $j;
		for ($i = 1; $i <= $opciones; $i++) {

		?>

		<input type="hidden" class="<?php echo "valor$j" ?>" value="<?php echo $cantidades[$i] ?>">
		<input type="hidden" class="<?php echo "titulo$j" ?>" value="<?php echo $titulos[$i] ?>">

	

		<?php  
		}/*95*/
		
		 ?>

		<input type="hidden" class="tamaño" value="<?php echo $opciones ?>">
		<input type="hidden" class="subida" value="<?php echo $j ?>">

		<div class="container" style="width: 50%; margin: 0 auto; width: 400px;">		
			<canvas class="oilChart" width="600" height="400"></canvas>
		</div>
		<?php 
		$j++; 
		?>
		<hr/>
		<!--Aqui termina la carta-->	
	</div>
	
	<?php
	}
  	 ?>
	 
	<script src="js/resultados2.js"></script>
	<div class="container text-center" style="margin-bottom: 20px">
		<a href="reporte.php" class="btn btn-primary" target="_blank">GENERAR REPORTE</a>
		<!--<a href="reporte2.php?id_encuesta=<?php echo $id_encuesta ?>" class="btn btn-primary" target="_blank">GENERAR REPORTE2</a>-->
	</div>
	</div>
	


<script>
	$(document).ready(function(){  
     //   listar_usuario()
	 	//listo()
        //revisarDatos()
        //$("#modal_registro").on('shown.bs.modal',function(){
         //   $("#v_usuario_nombre").focus();  
        //})
    });

</script>


  	<!-- Optional JavaScript -->
  	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
  	<script src="../js/jquery-3.3.1.min.js"></script>
  	<script src="../js/popper.min.js"></script>
  	<script src="../js/bootstrap.min.js"></script>
</body>
</html>