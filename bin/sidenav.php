
<!-- SideNav -->
<ul id="slide-out" class="sidenav">
  <li>
    <div class="user-view">
      <div class="background">
        <!-- <img style="width: 100%;filter: blur(1px);" src=""> -->
      </div>
      <img class="responsive-img circle" style="border-radius: 10%" src="img/business.png">
      <span class="white-text name">Benvenuto, <b><?php echo $_SESSION["nome"] . " " . $_SESSION["cognome"]; ?></b></span>
      <?php
        if(is_null($_SESSION["last_access"])){
          ?><span class="white-text last-access">È la prima volta che ci vediamo!</i></span><?php
        } else {
          ?><span class="white-text last-access">Ultimo accesso: <?php echo date_format(date_create($_SESSION["last_access"]), "d/m/Y H:i:s"); ?></i></span><?php
        }
      ?>
    </div>
  </li>
  <li><a href="admin.php"><i class="material-icons">search</i>Cerca aziende</a></li>
  <!-- <li><a href="#!">Second Link</a></li>
  <li><a class="subheader">Subheader</a></li> -->
  <li id="logoutBtn"><a href="php/logout.php" class="waves-effect waves-light btn-small">esci</a></li>
</ul>


<script>
M.Sidenav.init(document.querySelectorAll('.sidenav'));
</script>
