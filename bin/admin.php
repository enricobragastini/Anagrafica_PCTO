<?php
session_start();
include("php/methods.php");
if(!isset($_SESSION['username']) || !isset($_SESSION["permissions"]) || $_SESSION["permissions"]!="admin"){
  header("location: /bin/index.php");
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
  <script src="js/lib/jquery.cookie.js" charset="utf-8"></script>

  <!-- Custom CSS (parametro con numero random per forzare il reload) -->
  <link type="text/css" rel="stylesheet" href="css/mystyle.css?<?php echo rand(0, 10000); ?>"  media="screen,projection"/>
  <link type="text/css" rel="stylesheet" href="css/admin.css?<?php echo rand(0, 10000); ?>"  media="screen,projection"/>

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

  <script type="text/javascript">
  document.addEventListener('DOMContentLoaded', function() {
    M.Datepicker.init(document.querySelectorAll('.datepicker'));
    M.Modal.init(document.querySelectorAll('.modal'));
    M.FormSelect.init(document.querySelectorAll('select'));
  });
  </script>

</head>
<body class="">

  <?php
  include("navbar.php");
  include("sidenav.php");
  ?>

  <!-- Main content -->
  <div class="box white z-depth-3 center" id="content">
    <header style="margin-top: 20px; margin-bottom: 20px;">
      <h4 class="animated bounceIn">Gestione Anagrafica</h4>
      <h6 class="animated fadeIn delay-500ms"><i>tot. aziende registrate: <b><span class="counter" data-count="<?php echo countAziende(); ?>">0</span></b></i></h6>
    </header>

    <div class="divider"></div>

    <div class="row animated fadeIn delay-500ms" id="adminAlert" style="margin-top: 1rem; display: none;">
      <div class="col s12 m10 offset-m1">
        <div class="card-panel white-text" style="background-color: #232f34; padding: 18px;">
          <i class="material-icons" id="closeAlertIcon" style="float: right; display: block; cursor: pointer;">close</i>
          <h6 style="margin: 0px; margin-bottom: 4px; display: block">Ti presentiamo la pagina Admin!</h6>
          <p>Qui puoi vedere un riassunto di tutte le aziende con cui la nostra scuola collabora.<br>Puoi usare la seguente tabella per cercare le aziende, aggiungerne delle nuove o eliminarle.</p>
        </div>
      </div>
    </div>

    <div id="pageContent">
      <div id="selectSettore" style="padding-top: 1rem;">
        <div class="row">
          <div class="input-field col s12 m8 offset-m2">
            <select multiple id="selectAddress">
              <option value="" disabled>Scegli indirizzo/i</option>
              <?php
              $indirizzi = getElencoIndirizzi();
              foreach($indirizzi as $i){
                echo "<option value=\"" . $i["id"] . "\">". $i["titolo"] ."</option>";
              }
              ?>
            </select>
            <label>Filtra aziende per indirizzo di studi</label>
          </div>
        </div>
      </div>
      <div class="row" style="margin-bottom: 1rem;">
        <div class="col s12">
          <div id="jsGrid" class="animated fadeIn delay-500ms"></div>
        </div>
      </div>
    </div>

  </div>

  <div class="row center animated fadeInDown delay-1s">
    <div class="col s12">
      <p class="white-text">&copy; 5BI 2019/2020<br>Enrico Bragastini & Loris Pesarin</p>
    </div>
  </div>

  <!-- ############# AGGIUNTA NUOVE AZIENDE ############# -->
  <!-- Pulsante fixed -->
  <div class=" fixed-action-btn">
    <a class="btn-floating btn-large waves-effect waves-light tooltipped modal-trigger" style="background-color: #f9aa33;" href="#addAziendaModal" data-position="top" data-tooltip="Aggiungi un azienda">
      <i class="material-icons">add</i>
    </a>
  </div>

  <!-- Modal con form -->
  <div id="addAziendaModal" class="modal modal-fixed-footer">
    <div class="modal-content">
      <h4>Aggiunta azienda</h4>
      <div class="row">
        <form class="col s12">
          <!-- Anagrafica -->
          <div class="row">
            <h6>Anagrafica</h6>
            <div class="input-field col s12 m6">
              <input id="ragione_sociale" type="text" class="validate">
              <label for="ragione_sociale">Ragione sociale</label>
            </div>
            <div class="input-field col s12 m6">
              <input id="tipo" type="text" class="validate">
              <label for="tipo">Tipologia</label>
            </div>
          </div>
          <!-- Indirizzo -->
          <div class="row">
            <h6>Indirizzo</h6>
            <div class="input-field col s12">
              <input id="indirizzo" type="text" class="validate">
              <label for="indirizzo">Indirizzo (via/viale/p.zza)</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12 m6">
              <input id="comune" type="text" class="validate">
              <label for="comune">Comune</label>
            </div>
            <div class="input-field col s12 m6">
              <input id="provincia" type="text" class="validate">
              <label for="provincia">Provincia</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12 m6">
              <input id="cap" type="text" class="validate">
              <label for="cap">CAP</label>
            </div>
            <div class="input-field col s12 m6">
              <input id="nazione" type="text" class="validate">
              <label for="nazione">Nazione</label>
            </div>
          </div>
          <!-- Contatti -->
          <div class="row">
            <h6>Contatti</h6>
            <div class="input-field col s12">
              <i class="material-icons prefix">phone</i>
              <input id="telefono" type="tel" class="validate">
              <label for="telefono">Telefono</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12 m6">
              <input id="email" type="text" class="validate">
              <label for="email">E-mail</label>
            </div>
            <div class="input-field col s12 m6">
              <input id="sito" type="text" class="validate">
              <label for="sito">Sito</label>
            </div>
          </div>
          <!-- Idirizzi di studio -->
          <div class="row">
            <h6>Indirizzi richiesti</h6>
            <div class="input-field col s12">
              <select id="indirizzi" multiple disabled>
                <option value="1">COSTRUZIONE DEL MEZZO</option>
                <option value="2">ELETTRONICA</option>
                <option value="3">INFORMATICA</option>
                <option value="4">LOGISTICA</option>
                <option value="5">TELECOMUNICAZIONI</option>
              </select>
              <label for="indirizzi">Seleziona gli indirizzi richiesti:</label>
            </div>
          </div>
          <!-- Mansioni assegnate -->
          <div class="row">
            <h6>Mansioni</h6>
            <div class="input-field col s12">
              <select id="mansioni" multiple disabled>
                <optgroup label="COSTRUZIONE DEL MEZZO">
                  <option value="...">...</option>
                  <option value="...">....</option>
                </optgroup>
                <optgroup label="ELETTRONICA">
                  <option value="...">....</option>
                  <option value="...">...</option>
                </optgroup>
                <optgroup label="INFORMATICA">
                  <option value="...">...</option>
                  <option value="...">...</option>
                </optgroup>
                <optgroup label="LOGISTICA">
                  <option value="...">...</option>
                  <option value="...">....</option>
                </optgroup>
                <optgroup label="TELECOMUNICAZIONI">
                  <option value="...">...</option>
                  <option value="...">...</option>
                </optgroup>
              </select>
              <label for="indirizzi">Seleziona le mansioni richieste:</label>
            </div>
          </div>
          <!-- Informazioni utili -->
          <div class="row">
            <h6>Informazioni utili</h6>
            <div class="input-field col s12 m6">
              <input id="num_dip" type="number" class="validate">
              <label for="num_dip">N. Dipendenti:</label>
            </div>
            <div class="input-field col s12 m6">
              <input id="data_convenzione" type="text" class="datepicker">
              <label for="data_convenzione">Data Convenzione:</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input id="cod_ateco" type="text" class="validate">
              <label for="cod_ateco">Codice ATECO</label>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-red btn-flat">Annulla</a>
      <a href="#!" class="modal-close waves-effect waves-green btn-flat">Salva</a>
    </div>
  </div>
</body>
</html>
