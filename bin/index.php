<?php
session_start();
include("php/methods.php");

if(isset($_SESSION['username'])){
  if($SESSION["permissions"] == "admin"){
    header("location:/bin/admin.php");
    die();
  } else {
    header("location:/bin/welcome.php");
    die();
  }
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
  if(isset($_POST["login"]) && $_POST["login"] == 1){
    if(isset($_POST["username"]) && isset($_POST["password"])){
      $myusername = $_POST['username'];
      $mypassword = $_POST['password'];

      if(loginCheck($myusername, $mypassword)){
        $_SESSION["username"] = $myusername;
        $_SESSION["permissions"] = getPermissions($myusername);
        if($_SESSION['permissions'] == "admin"){
          exit("admin.php");
        } else {
          exit("welcome.php");
        }
      } else {
        exit("0");
      }
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Speedy PCTO</title>

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
    <h4 class="animated bounceIn">BENVENUTO</h4>
    <p class="animated bounceIn delay-500ms"><b>Attenzione!</b> Per proseguire occorre fare il login.<br><b>Hai bisogno di un account?</b> Contatta il docente che gestisce il PCTO!</p>
    <div class="divider"></div>

    <!-- Login Form -->
    <form class="" action="index.php" method="post" id="loginForm">
      <div class="row animated bounceInUp delay-500ms" style="margin-top: 20px;">
        <div class="col m6 offset-m3 s12">
          <div class="row">
            <h6>Inserisci le tue credenziali</h6>
            <div class="input-field col s12">
              <i class="material-icons prefix">account_circle</i>
              <input id="username" type="text" name="username">
              <label for="username">Username</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <i class="material-icons prefix">lock</i>
              <input id="password" type="password" name="password">
              <label for="password">Password</label>
            </div>
          </div>
          <div class="row">
            <div class="col s12">
              <p class="red-text" id="loginInfoMsg" style="margin: 3px;">&nbsp;</p>
              <button class="btn waves-effect waves-light" type="submit" id="submitBtn" name="action" style="">ACCEDI
                <i class="material-icons right">send</i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>

  <div class="row center animated fadeInDown delay-1s">
    <div class="col s12">
      <p class="white-text">&copy; 5BI 2019/2020<br>Enrico Bragastini & Loris Pesarin</p>
    </div>
  </div>

  <script type="text/javascript">
  $(document).ready(function(){
    $("#loginForm").submit(function(event){
      $("#username").removeClass("invalid");
      $("#password").removeClass("invalid");
      event.preventDefault();
      var usernamePHP = $("#username").val();
      var passwordPHP = $("#password").val();
      if(usernamePHP == "" || passwordPHP == ""){
        $("#loginInfoMsg").html("Completa tutti i campi!");
        $("#username").addClass("invalid");
        $("#password").addClass("invalid");
      } else {
        $.ajax({
          type: "POST",
          url: "index.php",
          data: {
            login: 1,
            username: usernamePHP,
            password: passwordPHP,
          },
          dataType: "text",
          success: function(risposta){
            if(risposta == "0"){
              $("#loginInfoMsg").html("Credenziali errate! Riprova!");
              $("#username").addClass("invalid");
              $("#password").addClass("invalid");
            }
            else {
              window.location.href = risposta;
            }
          },
          error: function(){
            $("loginInfoMsg").html("<p class=\"red-text\">Ops... C'è stato un errore nel contattare il server</p>");
          }
        });
      }
    });
  });
  </script>

</body>
</html>
