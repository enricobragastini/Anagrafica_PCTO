<?php
   include('php/session.php');
?>
<!DOCTYPE html>
<html>
  <head>
  <title>Speedy PCTO - ADMIN</title>
    <!-- Google icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">

    <!-- Materialize-css -->
    <link type="text/css" rel="stylesheet" href="css/lib/materialize.css"  media="screen,projection"/>
    <script type="text/javascript" src="js/lib/materialize.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!-- Custom CSS (parametro con numero random per forzare il reload) -->
    <link type="text/css" rel="stylesheet" href="css/mystyle.css?<?php echo rand(0, 10000); ?>"  media="screen,projection"/>

    <!-- Animate CSS -->
    <link type="text/css" rel="stylesheet" href="css/lib/animate.css"  media="screen,projection"/>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="img/business.png"/>
  </head>
  <body class="">
    <!-- NavBar -->
    <div class="navbar-fixed">
      <nav>
        <div class="box">
          <div class="nav-wrapper green">
            <a href="#" class="brand-logo left"><i class="material-icons">work</i>Speedy PCTO</a>
            <a href="#" class="brand-logo right show-on-medium-and-up hide-on-small-only">ITI G. Marconi</a>
          </div>
        </div>
      </nav>
    </div>

    <!-- Main content -->
    <div class="box white z-depth-3 center" id="content">
      <h4 class="animated bounceIn">Benvenuto admin</h4>
      <?php
        echo '<p class="animated bounceIn delay-500ms">Utente: '. $login_session.'</p>';
      ?>
      <div class="divider"></div>
      <h6><a href="php/logout.php">Logout</a></h6>
    </div>

    <div class="row center animated fadeInDown delay-1s">
      <div class="col s12">
        <p class="white-text">&copy; 5BI 2019/2020<br>Enrico Bragastini & Loris Pesarin</p>
      </div>
    </div>
  </body>
</html>
