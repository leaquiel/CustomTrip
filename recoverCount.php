<?php
  require_once 'functions.php';

  $pageTitle = 'RecoverCount';
  require_once 'includes/head.php';

  if ( isLogged() ) {
      header('location: profile.php');
      exit;
  }

  $targets = [
    're' => 'Relax',
    'av' => 'Aventura',
    'fa' => 'Familiar',
    'fe' => 'Fiestero',
    'tr' => 'Trabajo',
  ];

  // Persistencia de datos
  $userOrEmail = isset($_POST['userOrEmail']) ? trim($_POST['userOrEmail']) : '';

  $errors = [];

  if ($_POST) {
    $errors = searchAccountValidate($_POST);

    if ( count($errors) == 0) {
      // $userWhoWantChangePassword=searchAccount($_POST['userOrEmail']);
      header ("location: changePassword.php?token=" . base64_encode($_POST['userOrEmail']) );
      // foreach ($userWhoWantChangePassword as $oneUser) {
      //   echo $oneUser;
      //   }

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

    <div class="register_fb_google">

      <h2>Recupera tu contraseña</h2>

      <form active="changePassword.php" method="post">

        <div class="form-group">
          <label class="col-lg-8">Ingrese su email o usuario
            <input type="text" name="userOrEmail" value="<?= $userOrEmail; ?>"
            class="form-control <?= isset($errors['userOrEmail']) ? 'is-invalid' : ''; ?>"
            placeholder="Ingresa email o nombre de usuario">

            <?php if (isset($errors['userOrEmail'])): ?>
              <div class="invalid-feedback">
                <?= $errors['userOrEmail'] ?>
              </div>
            <?php endif; ?>

          </label>
        </div>

        <div class="form-group col-md-4">
          <label>Pregunta de seguridad
            <select name="securityQuestion" class="form-control <?= isset($errors['securityQuestion']) ? 'is-invalid' : ''; ?>">
                <option value="">Elije pregunta de seguridad </option>
                <option value="mb">Lugar de nacimiento de tu madre</option>
                <option value="pn">Nombre de tu primer mascota</option>
                <option value="fs">Cancion favorita</option>
            </select>
          <?php if (isset($errors['securityQuestion'])): ?>
              <div class="invalid-feedback">
                <?= $errors['securityQuestion'] ?>
              </div>
            <?php endif; ?>
          </label>
        </div>

      <div class="col-md-4 mb-3">
        <label>Ingrese respuesta
          <input type="text" class="form-control <?= isset($errors['securityAnswer']) ? 'is-invalid' : ''; ?>" name="securityAnswer" placeholder="Ej. 1234">
          <?php if (isset($errors['securityAnswer'])): ?>
              <div class="invalid-feedback">
                <?= $errors['securityAnswer'] ?>
              </div>
            <?php endif; ?>
        </label>
      </div>

      <div class="col-12">
        <button type="submit" class="btn btn-primary">Baby come back :(</button>
      </div>


    </form>
  </div>






<!-- FORMULARIO Q CONSULTE POR EL MAIL O POR LA PREGUNTA DE SEGURIDAD
HACER UNA FUNCION A LA Q SE LE DELEGE TOD2
 -->



  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  </div>
  <!-- CIERRE DE CONTENEDOR PRINCIPAL -->

  <!-- Footer -->
  <?php require_once "includes/footer.php"; ?>
  <!-- //Footer -->
</body>
</html>
