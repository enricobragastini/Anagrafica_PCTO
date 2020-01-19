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

  <!-- Custom CSS -->
  <link type="text/css" rel="stylesheet" href="css/mystyle.css"  media="screen,projection"/>

  <!-- Animate CSS -->
  <link type="text/css" rel="stylesheet" href="css/animate.css"  media="screen,projection"/>

  <!-- Favicon -->
  <link rel="shortcut icon" type="image/png" href="img/business.png"/>
</head>

<body>

  <body class="grey lighten-3">

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

    <div class="box white z-depth-3 center" id="content">
      <h4 class="animated bounceIn">Sign In</h4>
      <p class="animated bounceIn delay-500ms"><b>Attenzione!</b> Per proseguire occorre fare il login.<br><b>Hai bisogno di un account?</b> Contatta il docente che gestisce il PCTO!</p>
      <div class="divider"></div>

      <!-- Login Form -->
      <form class="" action="index.php" method="post">
        <div class="row animated bounceInUp delay-500ms" style="padding-top: 2.5rem;">
          <div class="col m8 offset-m2 s12">
            <div class="row">
              <div class="input-field col s12">
                <i class="material-icons prefix">account_circle</i>
                <input id="username" type="text" class="validate" name="username">
                <label for="username">Username</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <i class="material-icons prefix">lock</i>
                <input id="password" type="password" class="validate" name="password">
                <label for="password">Password</label>
              </div>
            </div>
            <div class="row">
              <div class="col s12">
                <button class="btn waves-effect waves-light" type="submit" name="action" style="background-color: #459f47;">LOGIN
                  <i class="material-icons right">send</i>
                </button>
              </div>
            </div>
          </div>
        </div>

      </form>
    </div>

  </body>

</body>
</html>
