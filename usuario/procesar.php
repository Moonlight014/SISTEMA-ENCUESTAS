<?php

	require ('../conexion.php');

	$id_encuesta = $_POST['id_encuesta'];

	$query10 = "SELECT * FROM encuestas WHERE id_encuesta = '$id_encuesta'";
	$resultado10 = $con->query($query10);
	$row10 = $resultado10->fetch_assoc();

  	$ids = array();

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

  <link rel="stylesheet" href="../plugins/font-awesome/css/font-awesome.min.css">


  <title>Procesar</title>
</head>
<body>

<?php
    require '../navbar.php';
?>

	<center>
		<div style="margin-top: 50px"></div>
		<?php


		if (!isset($_SESSION['id_usuario'])) {
			echo "Error: Usuario no autenticado.";
			exit;
		}

		$id_usuario = $_SESSION['id_usuario'];

		$query5 = "SELECT * FROM usuarios_encuestas WHERE id_usuario = '$id_usuario' AND id_encuesta = '$id_encuesta'";
		$resultado5 = $con->query($query5);
		$tamaño = $resultado5->num_rows;

		if ($tamaño > 0) {
			echo "Ya respondiste la encuesta";
			echo "<br/>";
		} else {

			$query6 = "INSERT INTO usuarios_encuestas (id_usuario, id_encuesta) VALUES ('$id_usuario', '$id_encuesta')";
			$resultado6 = $con->query($query6);

			if ($row10['estado'] == '1') {
				// Get all questions for this survey
				$query_preguntas = "SELECT id_pregunta, id_tipo_pregunta FROM preguntas WHERE id_encuesta = '$id_encuesta'";
				$resultado_preguntas = $con->query($query_preguntas);

				while ($pregunta = $resultado_preguntas->fetch_assoc()) {
					$id_pregunta = $pregunta['id_pregunta'];
					$type = $pregunta['id_tipo_pregunta'];

					if (isset($_POST[$id_pregunta])) {
						$value = $_POST[$id_pregunta];

						if ($type == 1 || $type == 3) {
							// Multiple choice, value is array
							if (is_array($value)) {
								foreach ($value as $id_opcion) {
									$query3 = "INSERT INTO resultados (id_opcion) VALUES ('$id_opcion')";
									$resultado3 = $con->query($query3);
									if ($resultado3) {
										echo "Resultado ingresado<br/>";
									} else {
										echo "Error al ingresar resultado<br/>";
									}
								}
							}
						} elseif ($type == 2) {
							// Single select
							$id_opcion = $value;
							$query3 = "INSERT INTO resultados (id_opcion) VALUES ('$id_opcion')";
							$resultado3 = $con->query($query3);
							if ($resultado3) {
								echo "Resultado ingresado<br/>";
							} else {
								echo "Error al ingresar resultado<br/>";
							}
						} elseif ($type == 4) {
							// Text answer, insert into respuestas_texto table
							$respuesta_texto = $con->real_escape_string($value);
							$query_text = "INSERT INTO respuestas_texto (id_pregunta, id_usuario, respuesta_texto) VALUES ('$id_pregunta', '$id_usuario', '$respuesta_texto')";
							$resultado_text = $con->query($query_text);
							if ($resultado_text) {
								echo "Respuesta de texto ingresada<br/>";
							} else {
								echo "Error al ingresar respuesta de texto<br/>";
							}
						} elseif ($type == 5) {
							// Single option (radio button)
							$id_opcion = $value;
							$query3 = "INSERT INTO resultados (id_opcion) VALUES ('$id_opcion')";
							$resultado3 = $con->query($query3);
							if ($resultado3) {
								echo "Resultado ingresado<br/>";
							} else {
								echo "Error al ingresar resultado<br/>";
							}
						}
					}
				}
			} else {
				echo "<div style='margin-top: 50px;'>ERROR!<br/>La encuesta se encuentra cerrada</div>";
			}
		}

		 ?>

		<br/>
		<a class="btn btn-primary" href="index.php">VOLVER</a>
	</center>

 	<!-- Optional JavaScript -->
 	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
 	<script src="../js/jquery-3.3.1.slim.min.js"></script>
 	<script src="../js/popper.min.js"></script>
 	<script src="../js/bootstrap.min.js"></script>
</body>
</html>
