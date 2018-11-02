<?php
  require_once 'functions.php';

  $pageTitle = 'Cambiar contraseña';
  require_once 'includes/head.php';

  // if ( isLogged() ) {
  //     header('location: index.php');
  //     exit;
  // }
// NO QUIERO Q PREGUNTE PORQUE SINO NO ME DEJA CAMBIAR LA CLAVE UNA VEZ LOGEADO EL USUARIO
  $errors = [];
  if (isLogged()){
    $theUserOrEmail = $_SESSION['user']['user'];
    //  $_SESSION['user'] es mi usuario logeado sin la contraseña, por eso tengo q buscarlo
  }

  else {
    if ($_GET['token']) {
      $theUserOrEmail=base64_decode($_GET['token']);
      // $userWhoWantChangePassword=searchAccount($theUserOrEmail);
    }
  }

    if ($_POST) {

      $userWhoWantChangePassword=getUserByEmailOrUserName($theUserOrEmail);
      $errors = newPasswordValidate($_POST, $userWhoWantChangePassword);

      if ( count($errors) == 0) {
        if(changeAndSaveNewPassword($userWhoWantChangePassword, $_POST)){
          header('location: index.php');
          exit;
        }

        // foreach ($newUsersArray as $user ) {
        //   foreach ($user as $key => $value) {
        //     // code...
        //   echo "<pre>";
        //   print_r($key . ' ' . $value);
        //   echo "</pre>";
        // }
        // }
        // FUNCION DE GUARDAR NUEVAMENTE USUARIO Y LISTO
      }
  }



?>
<body>
  <!-- Header -->
   <?php require_once "includes/header.php"; ?>
  <!-- //Header -->
  <br><br><br>
  <!-- ABRE EL CONTENEDOR PRINCIPAL -->
  <div class="container">


    <form active="changePassword.php" method="post">

      <?php if (isLogged()) :?>
      <div class="form-group">

        <label class="col-lg-8">Ingrese su contraseña actual
          <input type="password" name="actualPassword"
          class="form-control <?= isset($errors['actualPassword']) ? 'is-invalid' : ''; ?>"
          placeholder="Su Password">

          <?php if (isset($errors['actualPassword'])): ?>
            <div class="invalid-feedback">
              <?= $errors['actualPassword'] ?>
            </div>
          <?php endif; ?>

        </label>

      </div>
      <?php endif; ?>

      <div class="form-group">
        <label class="col-lg-8">Ingrese su nueva contraseña
          <input type="password" name="newPassword"
          class="form-control <?= isset($errors['newPassword']) ? 'is-invalid' : ''; ?>"
          placeholder="New Password">

          <?php if (isset($errors['newPassword'])): ?>
            <div class="invalid-feedback">
              <?= $errors['newPassword'] ?>
            </div>
          <?php endif; ?>

        </label>
      </div>

      <div class="form-group">
        <label class="col-lg-8">Confirme su nueva contraseña
          <input type="password" name="confirmNewPassword"
          class="form-control <?= isset($errors['newPassword']) ? 'is-invalid' : ''; ?>"
          placeholder="Confirm new Password">

          <?php if (isset($errors['newPassword'])): ?>
            <div class="invalid-feedback">
              <?= $errors['newPassword'] ?>
            </div>
          <?php endif; ?>

        </label>
      </div>

      <div class="col-12">
        <button type="submit" class="btn btn-primary">Baby come back :(</button>
      </div>


    </form>



  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  </div>
  <!-- CIERRE DE CONTENEDOR PRINCIPAL -->

  <!-- Footer -->
  <?php require_once "includes/footer.php"; ?>
  <!-- //Footer -->
</body>
</html>
