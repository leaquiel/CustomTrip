<?php
// require_once 'function.php';


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
$userFullName = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
$user = isset($_POST['user']) ? trim($_POST['user']) : '';
$userCountry = isset($_POST['country']) ? trim($_POST['country']) : '';
$userEmail = isset($_POST['email']) ? trim($_POST['email']) : '';
$userTarget = isset($_POST['target']) ? trim($_POST['target']) : '';

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
  <div class="container posicionamiento">


      <div class="mainForm">





      <form class="registerForm" method="post">

        <h2 class="title_register">Registrate</h2>
        <label for="nombre">Nombre completo: </label>
          <input type="text" name="nombre" id="nombre" value="<?= $userFullName; ?>">

        <label for="user">Usuario: </label>
          <input type="text" name="user" id="user" value="<?= $user; ?>">

        <label for="nacionality">Nacionalidad: </label>
        <select name="country" id="nacionality">
          <option>Elige un país</option>
          <?php foreach ($countries as $code => $country): ?>
							<option
								<?= $code == $userCountry ? 'selected' : '' ?>
								value="<?= $code ?>"><?= $country ?>
              </option>
					<?php endforeach; ?>
        </select>

        <label for="email">Email: </label>
           <input class="form-control is-invalid" type="email" name="email" id="email" value="<?= $userEmail; ?>">

        <label for="password">Contraseña: </label>
           <input type="password" name="password" id="password">

        <label for="confirmPassword"> Confirmar contraseña: </label>
            <input type="password" name="confirmPassword" id="confirmPassword">


        <label for="target"> Tu target: </label>
        <select name="target" id="target">
            <option> Elije un target</option>
            <?php foreach ($targets as $code => $target): ?>
  							<option
  								<?= $code == $userTarget ? 'selected' : '' ?>
  								value="<?= $code ?>"><?= $target ?>
                </option>
  					<?php endforeach; ?>

        </select>


        <button type="submit" name="button">Mandale wey</button>


      </form>

      <div class="register_fb_google">
        <h2 class="title_register">Inicia sesion con una red social</h2>

        <a href="https://www.facebook.com/" class="reg_fb"> <span>Inicia sesion con Facebook</span> </a>
        <a href="https://plus.google.com" class="reg_google"> <span>Inicia sesion con Google</span> </a>

      </div>

      </div>


<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  </div>
  <!-- CIERRE DE CONTENEDOR PRINCIPAL -->

  <!-- Footer -->
  <?php require_once "includes/footer.php"; ?>
  <!-- //Footer -->
</body>
</html>
