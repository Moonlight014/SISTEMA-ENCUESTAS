<!DOCTYPE html>

<?php

	require ('../conexion.php');

	$id_encuesta = $_POST['id_encuesta'];

	$query10 = "SELECT * FROM encuestas WHERE id_encuesta = '$id_encuesta'";
	$resultado10 = $con->query($query10);
	$row10 = $resultado10->fetch_assoc();

  	$ids = array();

 ?>

<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="../css/bootstrap.min.css">
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


		$public = isset($_POST['public']) && $_POST['public'] == '1';
		$response_id = isset($_POST['response_id']) ? $_POST['response_id'] : null;

		if (!$public && !isset($_SESSION['id_usuario'])) {
			echo "Error: Usuario no autenticado.";
			exit;
		}

		//para encuestas publicas, generar un nuevo response_id unico para cada envio/encuesta respondida.
		if ($public) {
			$response_id = bin2hex(random_bytes(16)); // 32 char hex string
		}

		$id_usuario = $public ? null : $_SESSION['id_usuario'];

		$query5 = "SELECT * FROM usuarios_encuestas WHERE id_usuario = '$id_usuario' AND id_encuesta = '$id_encuesta'";
		$resultado5 = $con->query($query5);
		$tamaño = $resultado5->num_rows;

		if (!$public && $tamaño > 0) {
			echo "Ya respondiste la encuesta";
			echo "<br/>";
		} else {

			if (!$public) {
				$query6 = "INSERT INTO usuarios_encuestas (id_usuario, id_encuesta) VALUES ('$id_usuario', '$id_encuesta')";
				$resultado6 = $con->query($query6);
			} else {
				// Insert into tabla 'responses' para usuarios públicos
				$query_resp = "INSERT INTO responses (id_encuesta, response_id) VALUES ('$id_encuesta', '$response_id')";
				$resultado_resp = $con->query($query_resp);
			}

			if ($row10['estado'] == '1') {
				$query_preguntas = "SELECT id_pregunta, id_tipo_pregunta FROM preguntas WHERE id_encuesta = '$id_encuesta'";
				$resultado_preguntas = $con->query($query_preguntas);

				while ($pregunta = $resultado_preguntas->fetch_assoc()) {
					$id_pregunta = $pregunta['id_pregunta'];
					$type = $pregunta['id_tipo_pregunta'];

					if (isset($_POST[$id_pregunta])) {
						$value = $_POST[$id_pregunta];

						if ($type == 1 || $type == 3) {
							if (is_array($value)) {
								foreach ($value as $id_opcion) {
									$query3 = "INSERT INTO resultados (id_opcion, id_usuario, response_id) VALUES ('$id_opcion', " . ($id_usuario ? "'$id_usuario'" : "NULL") . ", " . ($response_id ? "'$response_id'" : "NULL") . ")";
									$resultado3 = $con->query($query3);
									if ($resultado3) {
										//echo "Resultado ingresado<br/>";
									} else {
										echo "Error al ingresar resultado<br/>";
									}
								}
							}
						} elseif ($type == 2) {
							$id_opcion = $value;
							$query3 = "INSERT INTO resultados (id_opcion, id_usuario, response_id) VALUES ('$id_opcion', " . ($id_usuario ? "'$id_usuario'" : "NULL") . ", " . ($response_id ? "'$response_id'" : "NULL") . ")";
							$resultado3 = $con->query($query3);
							if ($resultado3) {
								//echo "Resultado ingresado<br/>";
							} else {
								echo "Error al ingresar resultado<br/>";
							}
						} elseif ($type == 4) {
							$respuesta_texto = $con->real_escape_string($value);
							$query_text = "INSERT INTO respuestas_texto (id_pregunta, id_usuario, response_id, respuesta_texto) VALUES ('$id_pregunta', " . ($id_usuario ? "'$id_usuario'" : "NULL") . ", " . ($response_id ? "'$response_id'" : "NULL") . ", '$respuesta_texto')";
							$resultado_text = $con->query($query_text);
							if ($resultado_text) {
								//echo "Respuesta de texto ingresada<br/>";
							} else {
								echo "Error al ingresar respuesta de texto<br/>";
							}
						} elseif ($type == 5) {
							$id_opcion = $value;
							$query3 = "INSERT INTO resultados (id_opcion, id_usuario, response_id) VALUES ('$id_opcion', " . ($id_usuario ? "'$id_usuario'" : "NULL") . ", " . ($response_id ? "'$response_id'" : "NULL") . ")";
							$resultado3 = $con->query($query3);
							if ($resultado3) {
								//echo "Resultado ingresado<br/>";
							} else {
								echo "Error al ingresar resultado<br/>";
							}
						}
					}
				}
			} else {
				?>
				<div style='margin-top: 50px; color: red; font-weight: bold; font-size: 18px;'>
					ERROR!<br/>La encuesta se encuentra cerrada. 
				</div>
				<?php
			}
		}

		 ?>

		<br/>
<?php if ($public && $row10['estado'] == '1'): ?>
		<div id="success-message" style="color: green; font-size: 18px; font-weight: bold;">
			¡Encuesta respondida con éxito! Cerrando pestaña en <span id="countdown">3</span>...
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
<?php elseif (!$public): ?>
		<a class="btn btn-primary" href="index.php">VOLVER</a>
<?php endif; ?>
	</center>

 	<script src="../js/jquery-3.3.1.slim.min.js"></script>
 	<script src="../js/popper.min.js"></script>
 	<script src="../js/bootstrap.min.js"></script>
</body>
</html>
