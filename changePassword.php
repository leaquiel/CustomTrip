<?php
  require_once 'functions.php';

  $pageTitle = 'Dame nombre padre';
  require_once 'includes/head.php';

  if ( isLogged() ) {
      header('location: index.php');
      exit;
  }

  $errors = [];

  if ($_GET['token']) {
    $theUserOrEmail=base64_decode($_GET['token']);
    $userWhoWantChangePassword=searchAccount($theUserOrEmail);
    $theUserId=$userWhoWantChangePassword['id'];
    // changePassword($theUserId, $_POST);

    if ($_POST) {
      $errors = newPasswordValidate($_POST);

      if ( count($errors) == 0) {
        // Funciona bien la funcion de abajo!!
        $userWhichPasswordWasChanged=changePassword($theUserId, $_POST);
        if(saveNewPassword($userWhichPasswordWasChanged)){
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
