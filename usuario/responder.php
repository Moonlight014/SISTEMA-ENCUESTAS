<!DOCTYPE html>

<?php

  	require "../conexion.php";

	$public = isset($_GET['public']) ? true : false;

  	$id_encuesta = intval($_GET['id_encuesta']);

  	//checkear el estado de la encuesta
  	$query_status = "SELECT titulo, descripcion, estado FROM encuestas WHERE id_encuesta = '$id_encuesta'";
  	$resultado_status = $con->query($query_status);
  	$row_status = $resultado_status->fetch_assoc();

  	if ($row_status['estado'] == '0') {
  		//si la encuesta está cerrada da aviso y cierra la ventana en funcion más abajo.
  		$survey_closed = true;
  	} else {
  		$survey_closed = false;
  		$query2 = "SELECT * FROM preguntas WHERE id_encuesta = '$id_encuesta'";
  		$respuesta2 = $con->query($query2);

  		$query3 = "SELECT encuestas.titulo, encuestas.descripcion, preguntas.id_pregunta, preguntas.id_encuesta, preguntas.id_tipo_pregunta, preguntas.limite_opciones
			FROM preguntas
			INNER JOIN encuestas
			ON preguntas.id_encuesta = encuestas.id_encuesta
			WHERE preguntas.id_encuesta = '$id_encuesta'";
		$respuesta3 = $con->query($query3);
		$row3 = $respuesta3->fetch_assoc();
  	}

	session_start();
	if ($public) {
		if (!isset($_SESSION['response_id'])) {
			$_SESSION['response_id'] = bin2hex(random_bytes(16));
		}
	}





 ?>

<html lang="es">
<head>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  
  <link rel="stylesheet" href="../css/bootstrap.min.css">

  <link rel="shortcut icon" href="../imagenes/Logo-fis.png">

  <link rel="stylesheet" href="../plugins/font-awesome/css/font-awesome.min.css">
  



  <link rel="stylesheet" href="../css/main.css">
 

  <title>Responder</title>
</head>
<body >


	
<?php
    $is_public = $public;
    require '../navbar.php';
?>
<div class="container">
 	<div class="container text-center" >
 		<hr />
 		<h1 class="text-info"><?php echo $row_status['titulo'] ?></h1>
 		<p><?php echo $row_status['descripcion'] ?></p>

		<?php if ($survey_closed): ?>
			<div class="alert alert-danger" role="alert">
				<h4 class="alert-heading">Encuesta Cerrada</h4>
				<p>Lo sentimos, esta encuesta ya no está disponible para responder.</p>
				<p style="font-size:20px;">Cerrando página automaticamente en <span id="countdown">3</span>...</p>
			</div>
			<script>

			window.onload = function() {
				let countdownElement = document.getElementById('countdown');
				let count = 3;
				let interval = setInterval(function() {
					count--;
					if (count <= 0) {
						clearInterval(interval);
						window.close();
					} else {
						countdownElement.textContent = count;
					}
				}, 1000);
			};
		</script>

			<!--<a href="index.php" class="btn btn-danger btn-lg btn-block">Regresar</a>-->
		<?php else: ?>
		<form action="procesar.php" method="Post" autocomplete="off">
			<input type="hidden" name="public" value="<?php echo $public ? '1' : '0'; ?>" />
			<?php if ($public): ?>
			<input type="hidden" name="response_id" value="<?php echo $_SESSION['response_id']; ?>" />
			<?php endif; ?>

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
					$type = $row2['id_tipo_pregunta'];
					$limit = $row2['limite_opciones'];
					if ($type == 1) {
						//eleccion multiple en checkboxes
						while (($row = $respuesta->fetch_assoc())) {
			?>
						<div class="checkbox" align="left"; style="margin-left: 5%";>
						<label class="rad-label">
							<input class="form-check-input rad-input" type="checkbox" name="<?php echo $row['id_pregunta'] ?>[]" value="<?php echo $row['id_opcion'] ?>" data-limit="<?php echo $limit ?>" onchange="checkLimit(this)">
							<div class="rad-design"></div>
    						<div class="rad-text"><?php echo $row['valor'] ?></div>
						</label>
						</div>
			<?php
						}
					} elseif ($type == 2) {
						//select de opción única
			?>
						<select name="<?php echo $row2['id_pregunta'] ?>" class="form-control" required>
						<option value="">Seleccione una opción</option>
			<?php
						while (($row = $respuesta->fetch_assoc())) {
			?>
						<option value="<?php echo $row['id_opcion'] ?>"><?php echo $row['valor'] ?></option>
			<?php
						}
			?>
						</select>
			<?php
					} elseif ($type == 3) {
						while (($row = $respuesta->fetch_assoc())) {
			?>
						<div class="checkbox" align="left"; style="margin-left: 5%";>
						<label class="rad-label">
							<input class="form-check-input square-input" type="checkbox" name="<?php echo $row['id_pregunta'] ?>[]" value="<?php echo $row['id_opcion'] ?>" data-limit="<?php echo $limit ?>" onchange="checkLimit(this)">
							<div class="square-design"></div>
    						<div class="rad-text"><?php echo $row['valor'] ?></div>
						</label>
						</div>
			<?php
						}
					} elseif ($type == 4) {
			?>
						<input type="text" name="<?php echo $row2['id_pregunta'] ?>" class="form-control" placeholder="Ingrese su respuesta" required maxlength="500">
			<?php
					} elseif ($type == 5) {
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
		<?php endif; ?>
 	</div>
</div>



    

  <script src="../js/jquery-3.3.1.slim.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="js/limit_selection.js"></script>



</body>
</html>
