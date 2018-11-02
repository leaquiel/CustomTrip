<?php

require_once 'autoload.php';



if ( $auth->isLoged() ) {
// $theUser = $_SESSION['user'];

$theUser = $db->getUserByEmail($_SESSION['user']);
// echo '<pre>';
// print_r($theUser);
// exit;
}
?>

 <header>
   <nav class="navbar navbar-expand-lg fixed-top navbar-dark" style="background-color: rgba(30, 37, 59, 0.60);">
     <a class="navbar-brand logo_CT" href="index.php">CostumTrip</a>
     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
       <span class="navbar-toggler-icon"></span>
     </button>
     <div class="collapse navbar-collapse flex-justify-between" id="navbarNav">
     <!-- <div class="collapse navbar-collapse" id="navbarNav" style="display: flex; justify-content: space-between;"> -->
       <ul class="navbar-nav">
         <li class="nav-item <?= ($pageTitle === 'Home') ? 'active' : ''; ?>">
           <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
         </li>
         <li class="nav-item <?= ($pageTitle === 'Nosotros') ? 'active' : ''; ?>">
           <a class="nav-link" href="#">¿Quienes somos?</a>
         </li>
       </ul>

       <div class="dropdown-divider"></div>

       <ul class="navbar-nav align-items-center">
          <?php if (  $auth->isLoged() ) : ?>
            <!--  NO ME DA PELOTA AL ACTIVE EN PROFILE-->
          <li class="nav-item">
   					<a class="nav-link" href="profile.php">
              <img src="data/avatars/<?= $theUser->getImage() ?>" height="40" style="border-radius: 50%; ">
   					</a>
   			  </li>
          <li class="nav-item <?= ($pageTitle === 'Profile') ? 'active' : ''; ?>">
   					<a class="nav-link" href="profile.php">
              <?= $theUser->getUserName() ?>
   					</a>
   			  </li>
   				<li class="nav-item"><a class="nav-link" href="logout.php" style=" position: relative; top: 0px;">Cerrar sesion</a></li>


         <?php else : ?>
         <li class="nav-item <?= ($pageTitle === 'LogIn') ? 'active' : ''; ?>"><a class="nav-link"  href="login.php">LogIn</a></li>
         <li class="nav-item <?= ($pageTitle === 'Register') ? 'active' : ''; ?>"><a class="nav-link" href="register_con_bootstrap.php">Registrate</a></li>
         <?php endif; ?>
       </ul>
     </div>
   </nav>
 </header>
