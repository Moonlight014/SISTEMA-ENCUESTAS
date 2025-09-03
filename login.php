<!DOCTYPE html>
<?php
  session_start();   // Necesitamos una sesion
  if(isset($_SESSION['u_usuario']) && isset($_SESSION['id_tipo_usuario'])){
    if($_SESSION['id_tipo_usuario'] == '1'){
      header("Location: administrador/index.php");
      exit();
    } elseif($_SESSION['id_tipo_usuario'] == '2'){
      header("Location: usuario/index.php");
      exit();
    }
  }
?>﻿




<html>
<head>
  <meta charset="utf-8">
  <title>Stackfindover: Sign in</title>
  <link rel="stylesheet" href="css/login.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>

<?php
if (isset($_GET['error'])) {
  if ($_GET['error'] == 1) {
    echo '<div class="alert alert-danger text-center" style="position:relative;z-index:9999;display:block;margin:20px auto;width:80%;">Usuario o contraseña incorrectos.</div>';
  } elseif ($_GET['error'] == 2) {
    echo '<div class="alert alert-danger text-center" style="position:relative;z-index:9999;display:block;margin:20px auto;width:80%;">Error en la consulta a la base de datos.</div>';
  } elseif ($_GET['error'] == 3) {
    echo '<div class="alert alert-danger text-center" style="position:relative;z-index:9999;display:block;margin:20px auto;width:80%;">Tipo de usuario no válido.</div>';
  }
}
?>

  <div class="login-root">
    <div class="box-root flex-flex flex-direction--column" style="min-height: 100vh;flex-grow: 1;">
      <div class="loginbackground box-background--white padding-top--64">
        <div class="loginbackground-gridContainer">
          <div class="box-root flex-flex" style="grid-area: top / start / 8 / end;">
            <div class="box-root" style="background-image: linear-gradient(white 0%, rgb(247, 250, 252) 33%); flex-grow: 1;">
            </div>
          </div>
          <div class="box-root flex-flex" style="grid-area: 4 / 2 / auto / 5;">
            <div class="box-root box-divider--light-all-2 animationLeftRight tans3s" style="flex-grow: 1;"></div>
          </div>
          <div class="box-root flex-flex" style="grid-area: 6 / start / auto / 2;">
            <div class="box-root box-background--blue800" style="flex-grow: 1;"></div>
          </div>
          <div class="box-root flex-flex" style="grid-area: 7 / start / auto / 4;">
            <div class="box-root box-background--blue animationLeftRight" style="flex-grow: 1;"></div>
          </div>
          <div class="box-root flex-flex" style="grid-area: 8 / 4 / auto / 6;">
            <div class="box-root box-background--gray100 animationLeftRight tans3s" style="flex-grow: 1;"></div>
          </div>
          <div class="box-root flex-flex" style="grid-area: 2 / 15 / auto / end;">
            <div class="box-root box-background--cyan200 animationRightLeft tans4s" style="flex-grow: 1;"></div>
          </div>
          <div class="box-root flex-flex" style="grid-area: 3 / 14 / auto / end;">
            <div class="box-root box-background--blue animationRightLeft" style="flex-grow: 1;"></div>
          </div>
          <div class="box-root flex-flex" style="grid-area: 4 / 17 / auto / 20;">
            <div class="box-root box-background--gray100 animationRightLeft tans4s" style="flex-grow: 1;"></div>
          </div>
          <div class="box-root flex-flex" style="grid-area: 5 / 14 / auto / 17;">
            <div class="box-root box-divider--light-all-2 animationRightLeft tans3s" style="flex-grow: 1;"></div>
          </div>
        </div>
      </div>
      <div class="box-root padding-top--24 flex-flex flex-direction--column" style="flex-grow: 1; z-index: 9;">
        <div class="box-root padding-top--48 padding-bottom--24 flex-flex flex-justifyContent--center">
          <h1>SISTEMA FORM</h1>
        </div>

        <div class="formbg-outer">
          <div class="formbg">
            <div class="formbg-inner padding-horizontal--48">
              <span class="padding-bottom--15">Ingrese sus datos de usuario</span>
              <form class="form-signin" action="validacion.php" method="POST" >
                <div class="field padding-bottom--24">
                  <label for="email">Usuario</label>
                  <input type="text" id="inputEmail" class="form-control" placeholder="Usuario" required autofocus name="id_usuario">
                </div>
                <div class="field padding-bottom--24">
                  <div class="grid--50-50">
                    <label for="password">Contraseña</label>
                    <div class="reset-pass">
                      <a href="#">Olvidaste la contraseña</a>
                    </div>
                  </div>
                  <input type="password" id="inputPassword" class="form-control" placeholder="Contraseña" required name="clave">
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
</body>



</html>