<?php
require_once 'functions.php';

$pageTitle = 'Register';

if ( isLogged() ) {
		header('location: profile.php');
		exit;
}

$countries = [
  'ar' => 'Argentina',
  'bo' => 'Bolivia',
  'br' => 'Brasil',
  'co' => 'Colombia',
  'cl' => 'Chile',
  'ec' => 'Ecuador',
  'pa' => 'Paraguay',
  'pe' => 'Perú',
  'uy' => 'Uruguay',
  've' => 'Venezuela',
];

$targets = [
  're' => 'Relax',
  'av' => 'Aventura',
  'fa' => 'Familiar',
  'fe' => 'Fiestero',
  'tr' => 'Trabajo',
];

// Persistencia de datos
$userFullName = isset($_POST['name']) ? trim($_POST['name']) : '';
$user = isset($_POST['user']) ? trim($_POST['user']) : '';
$userCountry = isset($_POST['country']) ? trim($_POST['country']) : '';
$userEmail = isset($_POST['email']) ? trim($_POST['email']) : '';
$userTarget = isset($_POST['target']) ? trim($_POST['target']) : '';


$errors = [];

if ($_POST) {
  $errors = registerValidate($_POST, $_FILES);

  if ( count($errors) == 0 ) {

    $imageName = saveImage($_FILES['avatar']);

    $_POST['avatar'] = $imageName;

    $user = saveUser($_POST);

    logIn($user);
  }
}

?>
<?php
  require_once 'includes/head.php';
?>
<body>
  <!-- Header -->
   <?php require_once "includes/header.php"; ?>
  <!-- //Header -->
  <br><br><br>
  <!-- ABRE EL CONTENEDOR PRINCIPAL -->
  <div class="container">


      <div class="register_fb_google">
        <!-- CAMBIAR CLASE DE CSS PARA MANTENER DISEÑO -->

        <form  method="post" enctype="multipart/form-data">
          <div class="form-row">

            <div class="col-md-4 mb-3">
              <label>Nombre Completo
                <input type="text" name="name" value="<?= $userFullName; ?>"
                class="form-control <?= isset($errors['name']) ? 'is-invalid' : ''; ?>"
                placeholder="Ej. Juan Carlos">
                <?php if (isset($errors['name'])): ?>
									<div class="invalid-feedback">
										<?= $errors['name'] ?>
									</div>
								<?php endif; ?>
              </label>
            </div>

            <div class="col-md-4 mb-3">
              <label>Usuario
                <input type="text" name="user" value="<?= $user; ?>"
                class="form-control <?= isset($errors['user']) ? 'is-invalid' : ''; ?>"
                placeholder="Carlitox">
                <?php if (isset($errors['user'])): ?>
									<div class="invalid-feedback">
										<?= $errors['user'] ?>
									</div>
								<?php endif; ?>
              </label>
            </div>

            <div class="col-md-4">
              <label>Nacionalidad
                <select name="country"
                class="form-control <?= isset($errors['country']) ? 'is-invalid' : ''; ?>">
                  <option value="">Elige un país</option>
                  <?php foreach ($countries as $code => $country): ?>
                    <option
                    <?= $code == $userCountry ? 'selected' : '' ?>
                    value="<?= $code ?>"><?= $country ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              <?php if (isset($errors['country'])): ?>
                <div class="invalid-feedback">
                  <?= $errors['country'] ?>
                </div>
              <?php endif; ?>
            </label>
            </div>

            <div class="col-md-4 mb-3">
              <label>Email
                <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : ''; ?>"
                 name="email" value="<?= $userEmail; ?>" placeholder="Carlitox@yahoo.com.ar">
                <?php if (isset($errors['email'])): ?>
									<div class="invalid-feedback">
										<?= $errors['email'] ?>
									</div>
								<?php endif; ?>
              </label>
            </div>

            <div class="col-md-4 mb-3">
              <label>Contraseña
                <input type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : ''; ?>" name="password" placeholder="Password">
                <?php if (isset($errors['password'])): ?>
  									<div class="invalid-feedback">
  										<?= $errors['password'] ?>
  									</div>
  								<?php endif; ?>
              </label>
            </div>

            <div class="col-md-4 mb-3">
              <label>Repetir Contraseña
                <input type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : ''; ?>" name="confirmPassword" placeholder="Confirm Password">
                <?php if (isset($errors['password'])): ?>
                    <div class="invalid-feedback">
                      <?= $errors['password'] ?>
                    </div>
                  <?php endif; ?>
              </label>
            </div>

            <div class="form-group col-md-4">
              <label>Target
                <select name="target" class="form-control <?= isset($errors['target']) ? 'is-invalid' : ''; ?>">
                    <option value="">Elije un target</option>
                    <?php foreach ($targets as $code => $target): ?>
      							<option
      								<?= $code == $userTarget ? 'selected' : '' ?>
      								value="<?= $code ?>"><?= $target ?>
                    </option>
          					<?php endforeach; ?>
                </select>
              <?php if (isset($errors['target'])): ?>
                <div class="invalid-feedback">
                  <?= $errors['target'] ?>
                </div>
              <?php endif; ?>
              </label>
            </div>


            <!-- PREG Y RESP DE SEGURIDAD DEBERIA ESTAR EN UN MISMO DIV -->
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

          <div class="col-md-6">
							<div class="form-group">
								<label><b>Imagen de perfil:</b></label>
								<div class="custom-file">
									<input
										type="file"
										class="custom-file-input <?= isset($errors['image']) ? 'is-invalid' : ''; ?>"
									 	name="avatar"
									>
									<label class="custom-file-label">Elige un archivo...</label>
									<?php if (isset($errors['image'])): ?>
										<div class="invalid-feedback">
											<?= $errors['image'] ?>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>

            <div class="col-12">
              <button class="btn btn-primary" type="submit" name="button">Registrate! </button>
            </div>
        </form>
      </div>




      <div class="register_fb_google">
        <h2 class="title_register">Inicia sesion con una red social</h2>

        <a href="https://www.facebook.com/" class="reg_fb"> <span>Inicia sesion con Facebook</span> </a>
        <a href="https://plus.google.com" class="reg_google"> <span>Inicia sesion con Google</span> </a>

      </div>



  </div>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <!-- CIERRE DE CONTENEDOR PRINCIPAL -->

  <!-- Footer -->
  <?php require_once "includes/footer.php"; ?>
  <!-- //Footer -->
</body>
</html>
