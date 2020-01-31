<?php
session_start();
include("php/methods.php");
if(!isset($_SESSION['username']) || !isset($_SESSION["permissions"]) || $_SESSION["permissions"]!="admin"){
  header("location: bin/index.php");
  die();
}
if(isset($_GET["id"])){
  $azienda = getAziendaData($_GET["id"]);
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

  <!-- Custom CSS (parametro con numero random per forzare il reload) -->
  <link type="text/css" rel="stylesheet" href="css/mystyle.css?<?php echo rand(0, 10000); ?>"  media="screen,projection"/>

  <!-- Custom Admin Javascript -->
  <!-- <script src="js/admin.js" charset="utf-8"></script> -->

  <!-- JsGrid -->
  <link type="text/css" rel="stylesheet" href="css/lib/jsgrid.css"  media="screen,projection"/>
  <link type="text/css" rel="stylesheet" href="css/lib/jsgrid-theme.css"  media="screen,projection"/>
  <script src="js/lib/jsgrid.js" charset="utf-8"></script>

  <!-- Animate CSS -->
  <link type="text/css" rel="stylesheet" href="css/lib/animate.css"  media="screen,projection"/>

  <!-- Favicon -->
  <link rel="shortcut icon" type="image/png" href="img/business.png"/>

  <style media="screen">
  div.divider{
    margin-top: 1rem;
    margin-bottom: 1rem;
  }
  .collection-item, .collection{
    border: 0px !important;
  }
  </style>

  <script type="text/javascript">
  document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.tooltipped');
    var instances = M.Tooltip.init(elems);
  });
  </script>

</head>
<body class="">
  <!-- NavBar -->
  <div class="navbar-fixed">
    <nav>
      <div class="box">
        <div class="nav-wrapper white">
          <a href="#" class="brand-logo left"><i class="material-icons">work</i>Speedy PCTO</a>
          <a href="#" class="brand-logo right show-on-medium-and-up hide-on-small-only">ITI G. Marconi</a>
        </div>
      </div>
    </nav>
  </div>

  <!-- Main content -->
  <div class="box white z-depth-3 center" id="content">

    <header style="margin-top: 20px; margin-bottom: 20px;">
      <h4 class="animated bounceIn"><b><?php echo $azienda["ragione_sociale"]; ?></b></h4>
      <h5 class="animated bounceIn delay-500ms"><b>Tipologia:</b> <?php echo $azienda["tipo"]; ?></h5>
    </header>

    <div class="divider" style="margin-bottom: 1rem;"></div>

    <div class="row animated fadeIn delay-500ms">
      <div class="col s12 m10 offset-m1 yellow lighten-3" style="border: 3px solid #f9aa33; border-radius: 4px; padding-top: 1rem; padding-bottom: 1rem;">
        <!-- Anagrafica: title -->
        <div class="row">
          <div class="col s12">
            <h4>Anagrafica</h4>
          </div>
        </div>
        <div class="divider yellow darken-3"></div>

        <!-- INDIRIZZO -->
        <div class="row">
          <div class="col s12">
            <h5>INDIRIZZO</h5>
          </div>
        </div>
        <div class="row">
          <div class="col s4 m2 offset-m1">
            <p><b>Indirizzo:</b></p>
          </div>
          <div class="col s8 m3">
            <p><?php echo $azienda["indirizzo"] ?></p>
          </div>
          <div class="col s4 m2">
            <p><b>Comune:</b></p>
          </div>
          <div class="col s8 m3">
            <p><?php echo $azienda["comune"] ?></p>
          </div>
        </div>
        <div class="row">
          <div class="col s4 m2 offset-m1">
            <p><b>Provincia:</b></p>
          </div>
          <div class="col s8 m3">
            <p><?php echo $azienda["provincia"] ?></p>
          </div>
          <div class="col s4 m2">
            <p><b>Nazione:</b></p>
          </div>
          <div class="col s8 m3">
            <p><?php echo $azienda["nazione"] ?></p>
          </div>
        </div>
        <div class="row">
          <div class="col s4 m2 offset-m1">
            <p><b>CAP:</b></p>
          </div>
          <div class="col s8 m3">
            <p><?php echo $azienda["cap"] ?></p>
          </div>
        </div>
        <div class="divider yellow darken-3"></div>

        <!-- Contatti -->
        <div class="row">
          <div class="col s12">
            <h5>CONTATTI</h5>
          </div>
        </div>
        <div class="row">
          <div class="col s4 m2 offset-m1">
            <p><b>Telefono:</b></p>
          </div>
          <div class="col s8 m3">
            <p><?php echo $azienda["telefono"] ?></p>
          </div>
          <div class="col s4 m2">
            <p><b>E-Mail:</b></p>
          </div>
          <div class="col s8 m3">
            <p><?php echo $azienda["mail"] ?></p>
          </div>
        </div>
        <div class="row">
          <div class="col s4 m2 offset-m1">
            <p><b>Sito web:</b></p>
          </div>
          <div class="col s8 m3">
            <p><a class="black-text tooltipped" data-position="bottom" data-tooltip="Clicca per aprire!" href="http://<?php echo $azienda["sito"] ?>" target="_blank"><?php echo $azienda["sito"] ?></a></p>
          </div>
        </div>
        <div class="divider yellow darken-3"></div>

        <!-- Indirizzi studio -->
        <div class="row">
          <div class="col s12">
            <h5>INDIRIZZI RICHIESTI</h5>
          </div>
        </div>
        <div class="row">
          <div class="col s10 offset-s1">
            <ul class="collection">
              <?php
              $indirizzi = getIndirizziStudio($azienda["id"]);
              foreach($indirizzi as $i){
                echo "<li class=\"collection-item yellow lighten-3\">· ". $i["titolo"] ."</li>";
              }
              ?>
            </ul>
          </div>
        </div>
        <div class="divider yellow darken-3"></div>

        <!-- Informazioni utili -->
        <div class="row">
          <div class="col s12">
            <h5>INFORMAZIONI UTILI</h5>
          </div>
        </div>
        <div class="row">
          <div class="col s4 m2 offset-m1">
            <p><b>N° Dipendenti:</b></p>
          </div>
          <div class="col s8 m3">
            <p><?php echo $azienda["n_dipendenti"] ?></p>
          </div>
          <div class="col s4 m2">
            <p><b>Data Convenzione:</b></p>
          </div>
          <div class="col s8 m3">
            <p><?php echo $azienda["data_convenzione"] ?></p>
          </div>
        </div>
        <div class="row">
          <div class="col s4 m2 offset-m1">
            <p><b>Codice ateco:</b></p>
          </div>
          <div class="col s8 m3">
            <p><?php echo $azienda["cod_ateco"] ?></p>
          </div>
          <div class="col s4 m2">
            <p><b>Descrizione ateco:</b></p>
          </div>
          <div class="col s8 m3">
            <p><i>Funzione da implementare</i></p>
          </div>
        </div>
      </div>
    </div>

    <div class="divider" style="margin-top: 1rem;"></div>

    <h6><a href="php/logout.php">Logout</a></h6>
  </div>

  <div class="row center animated fadeInDown delay-1s">
    <div class="col s12">
      <p style="color: #ffffff">&copy; 5BI 2019/2020<br>Enrico Bragastini & Loris Pesarin</p>
    </div>
  </div>
</body>
</html>
