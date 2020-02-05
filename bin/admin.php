<?php
session_start();
include("php/methods.php");
if(!isset($_SESSION['username']) || !isset($_SESSION["permissions"]) || $_SESSION["permissions"]!="admin"){
  header("location: bin/index.php");
  die();
}
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

  <!-- JQuery -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<<<<<<< HEAD
  <script src="js/lib/jquery.cookie.js" charset="utf-8"></script>
=======
<<<<<<< HEAD
  <script src="js/lib/jquery.cookie.js" charset="utf-8"></script>
=======
>>>>>>> 9fc2f9b53fad2c036b05ab9e1a84cfc034800081
>>>>>>> 32cb4bd6d4bf44266cf5fab89c05a667b0d3602f

  <!-- Custom CSS (parametro con numero random per forzare il reload) -->
  <link type="text/css" rel="stylesheet" href="css/mystyle.css?<?php echo rand(0, 10000); ?>"  media="screen,projection"/>

  <!-- Custom Admin Javascript -->
  <script src="js/admin.js?<?php echo rand(0, 10000); ?>" charset="utf-8"></script>

  <!-- JsGrid -->
  <link type="text/css" rel="stylesheet" href="css/lib/jsgrid.css"  media="screen,projection"/>
  <link type="text/css" rel="stylesheet" href="css/lib/jsgrid-theme.css"  media="screen,projection"/>
  <script src="js/lib/jsgrid.js" charset="utf-8"></script>

  <!-- Animate CSS -->
  <link type="text/css" rel="stylesheet" href="css/lib/animate.css"  media="screen,projection"/>

  <!-- Favicon -->
  <link rel="shortcut icon" type="image/png" href="img/business.png"/>

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 32cb4bd6d4bf44266cf5fab89c05a667b0d3602f
  <script type="text/javascript">
  document.addEventListener('DOMContentLoaded', function() {

  });
  </script>

<<<<<<< HEAD
=======
=======
>>>>>>> 9fc2f9b53fad2c036b05ab9e1a84cfc034800081
>>>>>>> 32cb4bd6d4bf44266cf5fab89c05a667b0d3602f
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
    <header style="margin-top: 20px; margin-bottom: 20px;">
      <h4 class="animated bounceIn">Gestione Anagrafica</h4>
      <h6 class="animated bounceIn delay-500ms">Benvenuto, <b><?php echo $_SESSION["nome"] . " " . $_SESSION["cognome"]; ?></b></h6>
    </header>

    <div class="divider"></div>

<<<<<<< HEAD
    <div class="row animated fadeIn delay-500ms" id="adminAlert" style="margin-top: 1rem; display: none;">
      <div class="col s12 m10 offset-m1">
        <div class="card-panel white-text" style="background-color: #232f34; padding: 18px;">
          <i class="material-icons" id="closeAlertIcon" style="float: right; display: block; cursor: pointer;">close</i>
          <h6 style="margin: 0px; margin-bottom: 4px; display: block">Ti presentiamo la pagina Admin!</h6>
          <p>Qui puoi vedere un riassunto di tutte le aziende con cui la nostra scuola collabora.<br>Puoi usare la seguente tabella per cercare le aziende, aggiungerne delle nuove o eliminarle.</p>
        </div>
=======
<<<<<<< HEAD
    <div class="row animated fadeIn delay-500ms" id="adminAlert" style="margin-top: 1rem; display: none;">
      <div class="col s12 m10 offset-m1">
        <div class="card-panel white-text" style="background-color: #232f34; padding: 18px;">
          <i class="material-icons tooltipped" data-position="top" data-tooltip="Chiudi e non mostrare più" id="closeAlertIcon" style="float: right; display: block; cursor: pointer;">close</i>
          <h6 style="margin: 0px; margin-bottom: 4px; display: block">Ti presentiamo la pagina Admin!</h6>
          <p>Qui puoi vedere un riassunto di tutte le aziende con cui la nostra scuola collabora.<br>Puoi usare la seguente tabella per cercare le aziende, aggiungerne delle nuove o eliminarle.</p>
        </div>
      </div>
    </div>

    <h6 class="animated fadeIn delay-500ms"><i>tot. aziende registrate: <b><span class="counter" data-count="<?php echo countAziende(); ?>">0</span></b></i></h6>

    <div class="row" style="margin-top: 1rem; margin-bottom: 1rem;">
=======
    <div class="row" style="margin-top: 20px; margin-bottom: 20px;">
>>>>>>> 9fc2f9b53fad2c036b05ab9e1a84cfc034800081
      <div class="col s12">
        <div id="jsGrid" class="animated fadeIn delay-500ms"></div>
>>>>>>> 32cb4bd6d4bf44266cf5fab89c05a667b0d3602f
      </div>
    </div>

    <div id="pageContent">
      <h6 class="animated fadeIn delay-500ms"><i>tot. aziende registrate: <b><span class="counter" data-count="<?php echo countAziende(); ?>">0</span></b></i></h6>
      <div class="row" style="margin-top: 1rem; margin-bottom: 1rem;">
        <div class="col s12">
          <div id="jsGrid" class="animated fadeIn delay-500ms"></div>
        </div>
      </div>
    </div>


    <div class="divider"></div>

    <h6><a href="php/logout.php">Logout</a></h6>
  </div>

  <div class="row center animated fadeInDown delay-1s">
    <div class="col s12">
      <p class="white-text">&copy; 5BI 2019/2020<br>Enrico Bragastini & Loris Pesarin</p>
    </div>
  </div>
<<<<<<< HEAD

=======
<<<<<<< HEAD

=======
>>>>>>> 9fc2f9b53fad2c036b05ab9e1a84cfc034800081
>>>>>>> 32cb4bd6d4bf44266cf5fab89c05a667b0d3602f
</body>
</html>
