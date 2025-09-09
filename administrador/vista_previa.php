<?php

  	require "../conexion.php";

	$id_encuesta = intval($_GET['id_encuesta']);

  	// Check survey status
  	$query_status = "SELECT titulo, descripcion, estado FROM encuestas WHERE id_encuesta = '$id_encuesta'";
  	$resultado_status = $con->query($query_status);
  	$row_status = $resultado_status->fetch_assoc();

  	if ($row_status['estado'] == '0') {
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

  <title>Sistema de encuestas</title>
</head>
<body>


	
<?php
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
			</div>
			<br>
			<a href="index.php" class="btn btn-danger btn-lg btn-block">Regresar</a>
		<?php else: ?>
		<form>
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
					// Multiple choice with checkboxes
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
					// Select
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

		<br>
		<br>

		</form>
		<a href="index.php" class="btn btn-danger btn-lg btn-block">Regresar</a>
		<?php endif; ?>
 	</div>
	</div>


    
  	<!-- Optional JavaScript -->
  	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
  	<script src="../js/jquery-3.3.1.min.js"></script>
  	<script src="../js/popper.min.js"></script>
  	<script src="../js/bootstrap.min.js"></script>
  	<script src="../usuario/js/limit_selection.js"></script>
</body>
</html>
