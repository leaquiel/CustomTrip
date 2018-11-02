<?php
require_once 'autoload.php';

$pageTitle = 'Register';

require_once 'includes/head.php';
require_once 'connection.php';

$FormData = new RegisterFormValidator($_POST, $_FILES);

if( $auth->isLoged() ) {
		header('location: profile.php');
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
// $userFullName = isset($_POST['name']) ? trim($_POST['name']) : '';
// $user = isset($_POST['user']) ? trim($_POST['user']) : '';
// $userCountry = isset($_POST['country']) ? trim($_POST['country']) : '';
// $userEmail = isset($_POST['email']) ? trim($_POST['email']) : '';
// $userTarget = isset($_POST['target']) ? trim($_POST['target']) : '';

// echo "<pre>";
// print_r($db->getAllUsers());
// exit;


if ($_POST) {



		if ($db->emailExist($FormData->getEmail())) {
			$FormData->addError('email', 'Correo ya está registrado');
		}
		if ($db->userExist($FormData->getUserName())){
			$FormData->addError('user', 'El nombre de usuario ya esta en uso');
		}

		if ( $FormData->isValid() ) {

			$imageName = SaveImage::uploadImage($_FILES['avatar']);

			$_POST['image'] = $imageName;
			$user = new User($_POST);


			$user->setId($db->generateId());
			$db->saveUser($user);
			$dbSql->saveUser($user);


			$auth->logIn($user->getEmail());

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
        <!-- CAMBIAR CLASE DE CSS PARA MANTENER DISEÑO -->

        <form  method="post" enctype="multipart/form-data">
          <div class="form-row">

            <div class="col-md-4 mb-3">
              <label>Nombre Completo
                <input type="text" name="name" value="<?= $FormData->getName() ; ?>"
                class="form-control <?= $FormData->fieldHasError('name') ? 'is-invalid' : ''; ?>"
                placeholder="Ej. Juan Carlos">
                <?php if ( $FormData->fieldHasError('name') ): ?>
									<div class="invalid-feedback">
										<?= $FormData->getFieldError('name') ?>
									</div>
								<?php endif; ?>
              </label>
            </div>

            <div class="col-md-4 mb-3">
              <label>Usuario
                <input type="text" name="user" value="<?= $FormData->getUserName() ; ?>"
                class="form-control <?= $FormData->fieldHasError('user') ? 'is-invalid' : ''; ?>"
                placeholder="Carlitox">
                <?php if ( $FormData->fieldHasError('user') ): ?>
									<div class="invalid-feedback">
										<?= $FormData->getFieldError('user') ?>
									</div>
								<?php endif; ?>
              </label>
            </div>

            <div class="col-md-4">
              <label>Nacionalidad
                <select name="country"
<<<<<<< HEAD
                class="form-control <?= $FormData->fieldHasError('country') ? 'is-invalid' : ''; ?>">
                  <option value="">Elige un país</option>
                  <?php foreach ($countries as $code => $country): ?>
                    <option
                    <?= $code == $FormData->getCountry() ? 'selected' : '' ?>
=======
                class="form-control <?= isset($errors['country']) ? 'is-invalid' : ''; ?>">
                  <option value="">Elige un país</option>
                  <?php foreach ($countries as $code => $country): ?>
                    <option
                    <?= $code == $userCountry ? 'selected' : '' ?>
>>>>>>> 3c72c5294a9424b72c2911af30233eeff46a3a66
                    value="<?= $code ?>"><?= $country ?>
                    </option>
                  <?php endforeach; ?>
                </select>
<<<<<<< HEAD
              <?php if ( $FormData->fieldHasError('country') ): ?>
                <div class="invalid-feedback">
                  <?= $FormData->getFieldError('country') ?>
=======
              <?php if (isset($errors['country'])): ?>
                <div class="invalid-feedback">
                  <?= $errors['country'] ?>
>>>>>>> 3c72c5294a9424b72c2911af30233eeff46a3a66
                </div>
              <?php endif; ?>
            </label>
            </div>

            <div class="col-md-4 mb-3">
              <label>Email
<<<<<<< HEAD
                <input type="email" class="form-control <?= $FormData->fieldHasError('email') ? 'is-invalid' : ''; ?>"
                 name="email" value="<?= $FormData->getEmail() ;  ?>" placeholder="Carlitox@yahoo.com.ar">
                <?php if ( $FormData->fieldHasError('email') ): ?>
									<div class="invalid-feedback">
										<?=  $FormData->getFieldError('email') ?>
=======
                <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : ''; ?>"
                 name="email" value="<?= $userEmail; ?>" placeholder="Carlitox@yahoo.com.ar">
                <?php if (isset($errors['email'])): ?>
									<div class="invalid-feedback">
										<?= $errors['email'] ?>
>>>>>>> 3c72c5294a9424b72c2911af30233eeff46a3a66
									</div>
								<?php endif; ?>
              </label>
            </div>

            <div class="col-md-4 mb-3">
              <label>Contraseña
<<<<<<< HEAD
                <input type="password" class="form-control <?= $FormData->fieldHasError('password') ? 'is-invalid' : ''; ?>" name="password" placeholder="Password">
                <?php if ( $FormData->fieldHasError('password') ): ?>
  									<div class="invalid-feedback">
  										<?= $FormData->getFieldError('password')  ?>
=======
                <input type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : ''; ?>" name="password" placeholder="Password">
                <?php if (isset($errors['password'])): ?>
  									<div class="invalid-feedback">
  										<?= $errors['password'] ?>
>>>>>>> 3c72c5294a9424b72c2911af30233eeff46a3a66
  									</div>
  								<?php endif; ?>
              </label>
            </div>

            <div class="col-md-4 mb-3">
              <label>Repetir Contraseña
<<<<<<< HEAD
                <input type="password" class="form-control <?= $FormData->fieldHasError('password') ? 'is-invalid' : ''; ?>" name="confirmPassword" placeholder="Confirm Password">
                <?php if ( $FormData->fieldHasError('password') ): ?>
  									<div class="invalid-feedback">
  										<?= $FormData->getFieldError('password')  ?>
  									</div>
  								<?php endif; ?>
=======
                <input type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : ''; ?>" name="confirmPassword" placeholder="Confirm Password">
                <?php if (isset($errors['password'])): ?>
                    <div class="invalid-feedback">
                      <?= $errors['password'] ?>
                    </div>
                  <?php endif; ?>
>>>>>>> 3c72c5294a9424b72c2911af30233eeff46a3a66
              </label>
            </div>

            <div class="form-group col-md-4">
              <label>Target
<<<<<<< HEAD
                <select name="target" class="form-control <?= $FormData->fieldHasError('target') ? 'is-invalid' : ''; ?>">
                    <option value="">Elije un target</option>
                    <?php foreach ($targets as $code => $target): ?>
      							<option
      								<?= $code == $FormData->getTarget() ? 'selected' : '' ?>
=======
                <select name="target" class="form-control <?= isset($errors['target']) ? 'is-invalid' : ''; ?>">
                    <option value="">Elije un target</option>
                    <?php foreach ($targets as $code => $target): ?>
      							<option
      								<?= $code == $userTarget ? 'selected' : '' ?>
>>>>>>> 3c72c5294a9424b72c2911af30233eeff46a3a66
      								value="<?= $code ?>"><?= $target ?>
                    </option>
          					<?php endforeach; ?>
                </select>
<<<<<<< HEAD
              <?php if ( $FormData->fieldHasError('target') ): ?>
                <div class="invalid-feedback">
                  <?= $FormData->getFieldError('target') ?>
=======
              <?php if (isset($errors['target'])): ?>
                <div class="invalid-feedback">
                  <?= $errors['target'] ?>
>>>>>>> 3c72c5294a9424b72c2911af30233eeff46a3a66
                </div>
              <?php endif; ?>
              </label>
            </div>


            <!-- PREG Y RESP DE SEGURIDAD DEBERIA ESTAR EN UN MISMO DIV -->
            <div class="form-group col-md-4">
              <label>Pregunta de seguridad
<<<<<<< HEAD
                <select name="securityQuestion" class="form-control <?= $FormData->fieldHasError('securityQuestion') ? 'is-invalid' : ''; ?>">
=======
                <select name="securityQuestion" class="form-control <?= isset($errors['securityQuestion']) ? 'is-invalid' : ''; ?>">
>>>>>>> 3c72c5294a9424b72c2911af30233eeff46a3a66
                    <option value="">Elije pregunta de seguridad </option>
                    <option value="mb">Lugar de nacimiento de tu madre</option>
                    <option value="pn">Nombre de tu primer mascota</option>
                    <option value="fs">Cancion favorita</option>
                </select>
<<<<<<< HEAD
              <?php if ($FormData->fieldHasError('securityQuestion')): ?>
									<div class="invalid-feedback">
										<?= $FormData->getFieldError('securityQuestion') ?>
=======
              <?php if (isset($errors['securityQuestion'])): ?>
									<div class="invalid-feedback">
										<?= $errors['securityQuestion'] ?>
>>>>>>> 3c72c5294a9424b72c2911af30233eeff46a3a66
									</div>
								<?php endif; ?>
              </label>
            </div>

          <div class="col-md-4 mb-3">
            <label>Ingrese respuesta
<<<<<<< HEAD
              <input type="text" class="form-control <?= $FormData->fieldHasError('securityAnswer') ? 'is-invalid' : ''; ?>" name="securityAnswer" placeholder="Ej. 1234">
              <?php if ($FormData->fieldHasError('securityAnswer')): ?>
									<div class="invalid-feedback">
										<?= $FormData->getFieldError('securityAnswer') ?>
=======
              <input type="text" class="form-control <?= isset($errors['securityAnswer']) ? 'is-invalid' : ''; ?>" name="securityAnswer" placeholder="Ej. 1234">
              <?php if (isset($errors['securityAnswer'])): ?>
									<div class="invalid-feedback">
										<?= $errors['securityAnswer'] ?>
>>>>>>> 3c72c5294a9424b72c2911af30233eeff46a3a66
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
<<<<<<< HEAD
										class="custom-file-input <?= $FormData->fieldHasError('avatar') ? 'is-invalid' : ''; ?>"
									 	name="avatar"
									>
									<label class="custom-file-label">Elige un archivo...</label>
									<?php if ($FormData->fieldHasError('avatar')): ?>
										<div class="invalid-feedback">
											<?= $FormData->getFieldError('avatar') ?>
=======
										class="custom-file-input <?= isset($errors['image']) ? 'is-invalid' : ''; ?>"
									 	name="avatar"
									>
									<label class="custom-file-label">Elige un archivo...</label>
									<?php if (isset($errors['image'])): ?>
										<div class="invalid-feedback">
											<?= $errors['image'] ?>
>>>>>>> 3c72c5294a9424b72c2911af30233eeff46a3a66
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
