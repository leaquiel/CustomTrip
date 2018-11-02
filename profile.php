<?php
require_once 'autoload.php';

  $pageTitle = "Profile";
  require_once 'includes/head.php';

  if ( !$auth->isLoged() ) {
      header('location: index.php');
      exit;
  }

  $targets = [
    're' => 'Relax',
    'av' => 'Aventura',
    'fa' => 'Familiar',
    'fe' => 'Fiestero',
    'tr' => 'Trabajo',
  ];

?>
<body>
  <!-- Header -->
   <?php require_once "includes/header.php"; ?>
  <!-- //Header -->
  <br><br><br>
  <!-- ABRE EL CONTENEDOR PRINCIPAL -->
  <div class="container">
    <div class="register_fb_google">

    <h2> Hola de nuevo <?= $theUser->getName() ?> !!</h2>

    <img src="data/avatars/<?= $theUser->getImage() ?>" width="240px" height="240px" style="border-radius: 20px; border: white 2px;">

    <h5 style="margin: 10px;">Tu mail guardado es: <?= $theUser->getEmail() ?></h5>
    <h3 style="margin: 10px;">Tus preferencias son: </h3>
    <h5 style="margin: 0 10px 10px;">#<?php
      foreach ($targets as $key => $value) {
        if ($theUser->getTarget()==$key)
        echo $value;
      }
     ?></h5>

    <?php
      // foreach ($theUser as $key => $value){
      // echo "<pre>";
      // print_r($key . ' ' . $value);
      // echo "</pre>";}
    ?>
    <a style="color: white;"href="changePassword.php">Cambiar contraseña</a>


  </div>





  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


  </div>
  <!-- CIERRE DE CONTENEDOR PRINCIPAL -->

  <!-- Footer -->
  <?php require_once "includes/footer.php"; ?>
  <!-- //Footer -->
</body>
</html>
