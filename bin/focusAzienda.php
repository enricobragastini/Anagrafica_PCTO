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
  <title><?php echo $azienda["ragione_sociale"]; ?></title>

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
  <link type="text/css" rel="stylesheet" href="css/focusAzienda.css?<?php echo rand(0, 10000); ?>"  media="screen,projection"/>

  <!-- Custom Focus Javascript -->
  <script src="js/focusAzienda.js?<?php echo rand(0, 10000); ?>" charset="utf-8"></script>

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
  <?php
  if(isset($_GET["id"])){
    echo "var aziendaId = " . $_GET["id"] . ";";
  }
  ?>
  </script>

</head>
<body class="">
  <!-- NavBar -->
  <div class="navbar-fixed">
    <nav>
      <div class="box">
        <div class="nav-wrapper white">
          <a href="index.php" class="brand-logo left"><i class="material-icons">work</i>Speedy PCTO</a>
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
      <div class="col s12 m10 offset-m1 white" style="border: 3px solid #f9aa33; border-radius: 4px; padding-top: 1rem; padding-bottom: 1rem;">
        <!-- Anagrafica: title -->
        <div class="row">
          <div class="col s12">
            <h4>ANAGRAFICA AZIENDALE</i></h4>
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
            <p class="right"><b>Indirizzo:</b></p>
          </div>
          <div class="col s8 m3">
            <div class="toEdit" id="indirizzo"><?php echo $azienda["indirizzo"] ?></div>
          </div>
          <div class="col s4 m2">
            <p class="right"><b>Comune:</b></p>
          </div>
          <div class="col s8 m3">
            <div class="toEdit" id="comune"><?php echo $azienda["comune"] ?></div>
          </div>
        </div>
        <div class="row">
          <div class="col s4 m2 offset-m1">
            <p class="right"><b>Provincia:</b></p>
          </div>
          <div class="col s8 m3">
            <div class="toEdit" id="provincia"><?php echo $azienda["provincia"] ?></div>
          </div>
          <div class="col s4 m2">
            <p class="right"><b>Nazione:</b></p>
          </div>
          <div class="col s8 m3">
            <div class="toEdit" id="nazione"><?php echo $azienda["nazione"] ?></div>
          </div>
        </div>
        <div class="row">
          <div class="col s4 m2 offset-m1">
            <p class="right"><b>CAP:</b></p>
          </div>
          <div class="col s8 m3">
            <div class="toEdit" id="cap"><?php echo $azienda["cap"] ?></div>
          </div>
        </div>
        <div class="divider yellow darken-3"></div>

        <div class="row">
          <div class="col s12">
            <h5>MAPPA</h5>
          </div>
        </div>
        <div class="row map-container">
          <div class="col m10 offset-m1 s12">
              <div class="video-container">
                <?php
                $query = $azienda["indirizzo"] . " " . $azienda["comune"] . $azienda["cap"];
                $query = urlencode($query);
                ?>
                <iframe id="gmap_canvas" align="center" src="https://maps.google.com/maps?q=<?php echo $query; ?>&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>              </div>
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
            <p class="right"><b>Telefono:</b></p>
          </div>
          <div class="col s8 m3">
            <div class="toEdit" id="telefono"><?php echo $azienda["telefono"] ?></div>
          </div>
          <div class="col s4 m2">
            <p class="right"><b>E-Mail:</b></p>
          </div>
          <div class="col s8 m3">
            <div class="toEdit" id="mail"><?php echo $azienda["mail"] ?></div>
          </div>
        </div>
        <div class="row">
          <div class="col s4 m2 offset-m1">
            <p class="right"><b>Sito web:</b></p>
          </div>
          <div class="col s8 m3">
            <div class="toEdit" id="sito"><a class="black-text"><?php echo $azienda["sito"] ?></a></div>
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
            <?php
            $indirizzi = getIndirizziStudio($azienda["id"]);
            ?>
              <?php
              if(count($indirizzi) > 0){
                ?><ul class="collection"><?php
                foreach($indirizzi as $i){
                  echo "<li class=\"collection-item\">· ". $i["titolo"] ."</li>";
                }
                ?></ul><?php
              } else {
                ?><p><i>Non sappiamo ancora niente sugli indirizzi richiesti da questa azienda...</p></i><?php
              }
              ?>
          </div>
        </div>
        <div class="divider yellow darken-3"></div>

        <!-- Mansioni -->
        <div class="row">
          <div class="col s12">
            <h5>MANSIONI ASSEGNATE</h5>
          </div>
        </div>
        <div class="row center">
          <div class="col s10 offset-s1 m8 offset-m2 center">
            <table class="centered highlight" id="mansioniTable"></table>
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
            <p class="right"><b>N° Dipendenti:</b></p>
          </div>
          <div class="col s8 m3">
            <div class="toEdit" id="n_dipendenti"><?php echo $azienda["n_dipendenti"] ?></div>
          </div>
          <div class="col s4 m2">
            <p class="right"><b>Data Convenzione:</b></p>
          </div>
          <div class="col s8 m3">
            <div class="toEdit" id="data_convenzione"><?php echo $azienda["data_convenzione"] ?></div>
          </div>
        </div>
        <div class="row">
          <div class="col s4 m2 offset-m1">
            <p class="right"><b>Codice ateco:</b></p>
          </div>
          <div class="col s8 m3">
            <div class="toEdit" id="cod_ateco"><?php echo $azienda["cod_ateco"] ?></div>
          </div>
          <div class="col s4 m2">
            <p class="right"><b>Descrizione ateco:</b></p>
          </div>
          <div class="col s8 m3">
            <p id="descrizioneAteco"></p>
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
