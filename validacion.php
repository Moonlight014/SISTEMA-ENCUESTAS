<?php
session_start();

$id_usuario = $_POST['id_usuario'];
$clave = $_POST['clave'];
include("conexion.php");

$query = "SELECT * FROM usuarios WHERE email = '$id_usuario' AND clave = MD5('$clave')";
$resultado = $con->query($query);

if (!$resultado) {
    header("Location: login.php?error=2");
    exit();
}

if ($row = $resultado->fetch_assoc()) {
    $_SESSION['id_usuario'] = $row['id_usuario'];
    $_SESSION['u_usuario'] = $row['nombres'];
    $_SESSION['id_tipo_usuario'] = $row['id_tipo_usuario'];
    if ($row['id_tipo_usuario'] == '1') {
        header("Location: administrador/index.php");
        exit();
    } elseif ($row['id_tipo_usuario'] == '2') {
        header("Location: usuario/index.php");
        exit();
    } else {
        header("Location: login.php?error=3");
        exit();
    }
} else {
    header("Location: login.php?error=1");
    exit();
}
?>
