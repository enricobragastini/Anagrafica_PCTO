<?php
   include("php/config.php");
   session_start();

   if(isset($_SESSION['login_user'])){
     if($SESSION["permissions"] == "admin"){
       header("location:/bin/admin.php");
     } else {
       header("location:/bin/welcome.php");
     }
      die();
   }

   if($_SERVER["REQUEST_METHOD"] == "POST") {

      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']);

      $sql = "SELECT permissions FROM users WHERE username = '$myusername' and password = '$mypassword'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $active = $row['active'];

      $count = mysqli_num_rows($result);

      if($count == 1) {
         $_SESSION['login_user'] = $myusername;
         $_SESSION['permissions'] = $row["permissions"];
         if($row[permissions]=="admin"){
           header("location: admin.php");
           die();
         }
         else {
           header("location: welcome.php");
           die();
         }
      } else {
         $error = "Username o password errati! Riprova!";
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
    <h4 class="animated bounceIn">Sign In</h4>
    <p class="animated bounceIn delay-500ms"><b>Attenzione!</b> Per proseguire occorre fare il login.<br><b>Hai bisogno di un account?</b> Contatta il docente che gestisce il PCTO!</p>
    <div class="divider"></div>

    <!-- Login Form -->
    <form class="" action="index.php" method="post">
      <div class="row animated bounceInUp delay-500ms" style="padding-top: 2.5rem;">
        <div class="col m8 offset-m2 s12">
          <div class="row">
            <h6>Inserisci le tue credenziali</h6>
            <div class="input-field col s12">
              <i class="material-icons prefix">account_circle</i>
              <input id="username" type="text" class="validate" name="username" value=>
              <label for="username">Username</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <i class="material-icons prefix">lock</i>
              <input id="password" type="password" class="validate" name="password" value=>
              <label for="password">Password</label>
            </div>
          </div>
          <div class="row">
            <div class="col s12">
              <!-- Testo da mostrare in caso di credenziali errate -> DA FARE IN PHP -->
              <?php
                if ($error){
                  echo '<p class="red-text">'. $error . '</p>';
                }
              ?>
              <!-- <p class="red-text">Credenziali errate, riprova!</p> -->
              <button class="btn waves-effect waves-light" type="submit" name="action" style="background-color: #459f47;">ACCEDI
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



</body>
</html>
