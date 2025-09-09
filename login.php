<!DOCTYPE html>
<?php
session_start();
$error = '';

// Solo redirige si la sesión está activa y NO se está enviando el formulario
if (isset($_SESSION['u_usuario']) && isset($_SESSION['id_tipo_usuario']) && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    if ($_SESSION['id_tipo_usuario'] == '1') {
        header("Location: administrador/index.php");
        exit();
    } elseif ($_SESSION['id_tipo_usuario'] == '2') {
        header("Location: usuario/index.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include("conexion.php");
    $id_usuario = mysqli_real_escape_string($con, $_POST['id_usuario']);
    if (!filter_var($id_usuario, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['login_error'] = "Email inválido.";
        header("Location: login.php");
        exit();
    }
    $clave = mysqli_real_escape_string($con, $_POST['clave']);

    $query = "SELECT * FROM usuarios WHERE email = '$id_usuario'";
    $resultado = $con->query($query);

    if ($row = $resultado->fetch_assoc()) {
        // Check if password is hashed with password_hash or still using MD5
        $password_valid = false;
        if (password_verify($clave, $row['clave'])) {
            // Password is hashed with password_hash
            $password_valid = true;
        } elseif (md5($clave) === $row['clave']) {
            // Password is still hashed with MD5, update to password_hash
            $password_valid = true;
            $new_hash = password_hash($clave, PASSWORD_DEFAULT);
            $update_query = "UPDATE usuarios SET clave = '$new_hash' WHERE id_usuario = '{$row['id_usuario']}'";
            $con->query($update_query);
        }

        if ($password_valid) {
        $_SESSION['id_usuario'] = $row['id_usuario'];
        $_SESSION['u_usuario'] = $row['nombres'];
        $_SESSION['id_tipo_usuario'] = $row['id_tipo_usuario'];
        if ($row['id_tipo_usuario'] == '1') {
            header("Location: administrador/index.php");
            exit();
        } elseif ($row['id_tipo_usuario'] == '2') {
            header("Location: usuario/index.php");
            exit();
        }
    } else {
        $_SESSION['login_error'] = "Usuario o contraseña incorrectos.";
        header("Location: login.php");
        exit();
    }
    }
}
?>

<html>
<head>
    <meta charset="utf-8">
    <title>Sistema de encuestas -</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/jquery.toast.css">
</head>

<body>
    <div class="login-root">
        <div class="box-root flex-flex flex-direction--column" style="min-height: 100vh;flex-grow: 1;">
            <div class="loginbackground box-background--white padding-top--64">
                <div class="loginbackground-gridContainer">
                    <div class="box-root flex-flex" style="grid-area: top / start / 8 / end;">
                        <div class="box-root" style="background-image: linear-gradient(white 0%, rgb(247, 250, 252) 100%); flex-grow: 1;"></div>
                    </div>
                    <div class="box-root flex-flex" style="grid-area: 4 / 2 / auto / 5;">
                        <div class="box-root box-divider--light-all-2 animationLeftRight tans3s" style="flex-grow: 1;"></div>
                    </div>
                    <div class="box-root flex-flex" style="grid-area: 6 / start / auto / 2;">
                        <div class="box-root box-background--blue800" style="flex-grow: 1;"></div>
                    </div>
                    <div class="box-root flex-flex" style="grid-area: 7 / end / auto / 4;">
                        <div class="box-root box-background--blue" style="flex-grow: 1;"></div>
                    </div>
                    <div class="box-root flex-flex" style="grid-area: 8 / 4 / auto / 6;">
                        <div class="box-root box-background--gray100" style="flex-grow: 1;"></div>
                    </div>
                    <div class="box-root flex-flex" style="grid-area: 2 / 15 / auto / end;">
                        <div class="box-root box-background--cyan200" style="flex-grow: 1;"></div>
                    </div>
                    <div class="box-root flex-flex" style="grid-area: 3 / 14 / auto / end;">
                        <div class="box-root box-background--blue" style="flex-grow: 1;"></div>
                    </div>
                    <div class="box-root flex-flex" style="grid-area: 4 / 17 / auto / 20;">
                        <div class="box-root box-background--gray100" style="flex-grow: 1;"></div>
                    </div>
                    <div class="box-root flex-flex" style="grid-area: 5 / 14 / auto / 17;">
                        <div class="box-root box-divider--light-all-2 animationRightLeft tans3s" style="flex-grow: 1;"></div>
                    </div>
                </div>
            </div>
            <div class="box-root padding-top--24 flex-flex flex-direction--column" style="flex-grow: 1; z-index: 9;">
                <div class="box-root padding-top--48 padding-bottom--24 flex-flex flex-justifyContent--center">
                    <h1>Iniciar Sesión</h1>
                </div>
                <div class="formbg-outer">
                    <div class="formbg">
                        <div class="formbg-inner padding-horizontal--48">
                            <span class="padding-bottom--15">Ingrese sus datos de usuario</span>
                            <form class="form-signin" action="login.php" method="POST">
                                <div class="field padding-bottom--24">
                                    <label for="email">Email</label>
                                    <input type="text" id="inputEmail" class="form-control" placeholder="Ingrese su email" required autofocus name="id_usuario">
                                </div>
                                <div class="field padding-bottom--24">
                                    <div class="grid--50-50">
                                        <label for="password">Contraseña</label>
                                        <div class="reset-pass">
                                            <a href="#">Olvidaste la contraseña</a>
                                        </div>
                                    </div>
                                    <input type="password" id="inputPassword" class="form-control" placeholder="Ingrese su contraseña" required name="clave">
                                </div>
                                <div class="field padding-bottom--24">
                                    <input type="submit" name="submit" value="Ingresar">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="footer-link padding-top--24">
                        <div class="listing padding-top--24 padding-bottom--24 flex-flex center-center">
                            <span><a href="#">©CreateSystem</a></span>
                            <span><a href="#">contacto</a></span>
                            <span><a href="#">provacidad & terminos</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.toast.js"></script>

    <?php
    if (isset($_SESSION['login_error'])) {
        $error_message = $_SESSION['login_error'];
        echo "
        <script>
        $(document).ready(function(){
            $.toast({
                heading: 'Error',
                text: '$error_message',
                showHideTransition: 'fade',
                icon: 'error',
                loaderBg: '#ff6849',
                position: 'top-right'
            });
        });
        </script>";
        unset($_SESSION['login_error']); //limpia la variable de sesión para que no se muestre de nuevo
    }
    ?>
</body>

</html>