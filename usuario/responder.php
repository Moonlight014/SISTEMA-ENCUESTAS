<?php

  	require "../conexion.php";

  	$id_encuesta = $_GET['id_encuesta'];
 	$query2 = "SELECT * FROM preguntas WHERE id_encuesta = '$id_encuesta'";
  	$respuesta2 = $con->query($query2);

  	$query3 = "SELECT encuestas.titulo, encuestas.descripcion, preguntas.id_pregunta, preguntas.id_encuesta, preguntas.id_tipo_pregunta 
		FROM preguntas
		INNER JOIN encuestas
		ON preguntas.id_encuesta = encuestas.id_encuesta
		WHERE preguntas.id_encuesta = '$id_encuesta'";
	$respuesta3 = $con->query($query3);
	$row3 = $respuesta3->fetch_assoc();


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

  <link rel="stylesheet" href="../plugins/font-awesome/css/font-awesome.min.css">
  



  <link rel="stylesheet" href="../css/main.css">
 

  <title>Responder</title>
</head>
<body >


	
<?php
    require '../navbar.php';
?>
<div class="container">  
 	<div class="container text-center" >
 		<hr /> 
 		<h1 class="text-info"><?php echo $row3['titulo'] ?></h1>
 		<p><?php echo $row3['descripcion'] ?></p>

 		<form action="procesar.php" method="Post" autocomplete="off">


			<input type="hidden" id="id_encuesta" name="id_encuesta" value="<?php echo $id_encuesta ?>" />

			<hr />
			<?php

				$i = 1; 
				while (($row2 = $respuesta2->fetch_assoc())) {

				$id = $row2['id_pregunta'];

				$query = "SELECT preguntas.id_pregunta, preguntas.titulo, preguntas.id_tipo_pregunta, opciones.id_opcion, opciones.valor
					FROM opciones
					INNER JOIN preguntas
					ON preguntas.id_pregunta = opciones.id_pregunta
					WHERE preguntas.id_pregunta = $id
					ORDER BY opciones.id_pregunta, opciones.id_opcion";

				$respuesta = $con->query($query);

			?>
				<div class="card" >
					<div class="card-header text-info"><?php echo "Pregunta "."$i. " . $row2['titulo'] ?></div>
						
					<div class="card-body card-description">
				
			<?php 
					while (($row = $respuesta->fetch_assoc())) {
			?>
						<div class="radio" align="left"; style="margin-left: 5%";>
						<label class="rad-label">
							<input class="form-check-input rad-input" type="radio" name="<?php echo $row['id_pregunta'] ?>" value="<?php echo $row['id_opcion'] ?>" required> 
							<div class="rad-design"></div>
    						<div class="rad-text"><?php echo $row['valor'] ?></div>
						</label>
						</div>
			<?php 	
					}
					$i++;
			?>
					</div>
				</div>
			<?php
				}
			?>
			
				
			<br/>
			<input type="hidden" name="id_encuesta" value="<?php echo $id_encuesta ?>">
			<input class="btn btn-info btn-lg btn-block" type="submit" value="Responder">
		</form>
		<br>
		<br>


		<a href="index.php" class="btn btn-danger btn-lg btn-blockimage.png">Regresar</a>
 	</div>
</div>



    
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="../js/jquery-3.3.1.slim.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>



</body>
</html>