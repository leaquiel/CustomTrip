
<?php
  require_once 'autoload.php';

  if( $auth->isLoged() ) {
		header('location: profile.php');
	}

  $pageTitle = 'LogIn';
  require_once 'includes/head.php';

  $LoginData = new LoginFormValidator($_POST);

  if ($_POST) {


    if ( $LoginData->isValid() ) {

    $user = $db->getUserByEmailOrUserName($_POST['userOrEmail']);
    if ( !$user ) {
      $LoginData->addError('userOrEmail', 'Este correo no está registrado');
    }else if ( !password_verify($_POST['password'], $user->getPassword()) ) {
      $LoginData->addError('userOrEmail', 'Las credenciales no son validas');
      $LoginData->addError('password', 'Las credenciales no son validas');
    }else{
      // echo '<pre>';
      // print_r($user);
      // exit;
      if( isset($_POST['rememberUser']) ) {
        setcookie('userLogged', $_POST['userOrEmail']);
  		}

				$auth->logIn($user->getEmail());
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

    <form  method="post">
      <div class="form-group">
        <label class="col-lg-8">Email o usuario
          <input type="text" name="userOrEmail"
           value="<?= $LoginData->getUserOrEmail() ?>"
          class="form-control <?= $LoginData->fieldHasError('userOrEmail') ? 'is-invalid' : ''; ?>"
          placeholder="Ingresa email o nombre de usuario">

          <?php if ( $LoginData->fieldHasError('userOrEmail') ): ?>
            <div class="invalid-feedback">
              <?= $LoginData->getFieldError('userOrEmail') ?>
            </div>
          <?php endif; ?>

        </label>
      </div>

      <div class="form-group">
        <label class="col-lg-8">Contraseña
          <input type="password" class="form-control <?= $LoginData->fieldHasError('password') ? 'is-invalid' : ''; ?>" name="password" placeholder="Password">

          <?php if ($LoginData->fieldHasError('password') ): ?>
            <div class="invalid-feedback">
              <?= $LoginData->getFieldError('password') ?>
            </div>
          <?php endif; ?>

        </label>
      </div>

      <div class="form-check">
        <label class="form-check-label">
        <input type="checkbox" class="form-check-input" name="rememberUser">
          No cerrar sesion.</label>
      </div>

      <p><a href="recoverCount.php">¿Olvidó su nombre de usuario o contraseña?</a></p>

      <button type="submit" class="btn btn-primary">Mandale wey!</button>
    </form>



<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  </div>
  <!-- CIERRE DE CONTENEDOR PRINCIPAL -->

  <!-- Footer -->
  <?php require_once "includes/footer.php"; ?>
  <!-- //Footer -->
</body>
</html>
