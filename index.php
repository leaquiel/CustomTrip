<?php
  $pageTitle = 'Home';
  require_once 'includes/head.php';
?>
<body>
  <!-- Header -->
   <?php require_once "includes/header.php"; ?>
  <!-- //Header -->
  <br><br><br>
  <!-- ABRE EL CONTENEDOR PRINCIPAL -->
  <div class="container posicionamiento">

  <h1 class="index-tittle">CustomTrip</h1> <!-- TITULO -->
  <br>
  <p class="sub-tittle">Busca actividades en las ciudades que quieras mientras te premiamos por hacerlo!</p> <!--TITULO DE BUSCADOR-->

  <div class="input-group mb-3"> <!--FORMULARIO DE BUSQUEDA-->
    <input type="text" class="form-control" placeholder="Ej. Buenos Aires" aria-label="Recipient's username" aria-describedby="button-addon2">
    <div class="input-group-append">
      <!-- ESTE BOTON REDIRIGE A LA PAG DE DESARROLLO DE BUSQUEDA -->
     <a href="search.php"><button class="btn btn-outline-secondary" href="profile.php"type="button" id="button-addon2">Button</button></a>
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
