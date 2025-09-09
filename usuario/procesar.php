<!DOCTYPE html>

<?php

	require ('../conexion.php');

	$id_encuesta = intval($_POST['id_encuesta']);

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
  <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css2?family=Press+Start+2P&display=swap">

  <style>
    body, h1, h2, h3, h4, h5, h6, p, div, span, label, input, select, textarea, button, a {
      font-family: 'Press Start 2P', monospace !important;
      font-size: 12px;
      line-height: 1.4;
      letter-spacing: 0.5px;
    }
    h1, h2, h3 {
      font-size: 16px;
      line-height: 1.3;
    }
    .btn {
      font-size: 10px;
      padding: 8px 16px;
    }
  </style>

  <title>Procesar</title>
</head>
<body>

	<center>
		<div style="margin-top: 50px"></div>
		<?php


		$public = isset($_POST['public']) && $_POST['public'] == '1';
		$response_id = isset($_POST['response_id']) ? mysqli_real_escape_string($con, $_POST['response_id']) : null;

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
				//un insert into tabla 'responses' para usuarios públicos
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
									$id_opcion = intval($id_opcion);
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
							$id_opcion = intval($value);
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
							$id_opcion = intval($value);
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
				<div style='margin-top: 50px; background: linear-gradient(135deg, #ff6b6b, #ee5a52); color: white; padding: 25px; border-radius: 15px; box-shadow: 0 8px 25px rgba(238, 90, 82, 0.3); text-align: center;'>
					<div style="font-size: 3rem; margin-bottom: 15px;">
						<i class="fa fa-exclamation-triangle" style="color: #ffd700;"></i>
					</div>
					<h3 style="font-weight: bold; margin-bottom: 10px; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
						ERROR!
					</h3>
					<p style="font-size: 1.2rem; opacity: 0.9;">
						La encuesta se encuentra cerrada.
					</p>
				</div>
				<?php
			}
		}

		 ?>

		<br/>
<?php if ($public && $row10['estado'] == '1'): ?>
		<div id="success-message" style="background: linear-gradient(135deg, #4CAF50, #45a049); color: white; padding: 25px; border-radius: 15px; box-shadow: 0 8px 25px rgba(76, 175, 80, 0.3); text-align: center; margin: 20px 0;">
			<div style="font-size: 3rem; margin-bottom: 15px;">
				<i class="fa fa-check-circle" style="color: #ffd700;"></i>
			</div>
			<h3 style="font-weight: bold; margin-bottom: 10px; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
				¡Encuesta respondida con éxito!
			</h3>
			<div style="background: rgba(255,255,255,0.2); padding: 15px; border-radius: 10px; display: inline-block;">
				<p style="font-size: 1.5rem; font-weight: bold; margin: 0;">
					<i class="fa fa-clock-o" style="margin-right: 8px;"></i>
					Cerrando pestaña en <span id="countdown" style="color: #ffd700; font-size: 1.8rem;">3</span>...
				</p>
			</div>
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
