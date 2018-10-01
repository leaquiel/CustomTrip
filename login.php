
<?php
  require_once 'functions.php';

  $pageTitle = 'LogIn';
  require_once 'includes/head.php';

  // if ( isLogged() ) {
  //     header('location: index.php');
  //     exit;
  // }

  // Persistencia de datos
	$userOrEmail = isset($_POST['userOrEmail']) ? trim($_POST['userOrEmail']) : '';

	$errors = [];

	if ($_POST) {
		$errors = loginValidate($_POST);

		if ( count($errors) == 0) {
			$user = getUserByEmailOrUserName($_POST['userOrEmail']);

			if( isset($_POST['rememberUser']) ) {
      setcookie('userLogged', $_POST['userOrEmail']/*, time() + 3600*/);
			}

			logIn($user);
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
        <input type="email text" class="form-control" name="userOrEmail" placeholder="Ingresa email o nombre de usuario">
      </label>
      </div>

      <div class="form-group">
        <label class="col-lg-8">Contraseña
        <input type="password" class="form-control" name="userPassword" placeholder="Password">
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
