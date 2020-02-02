<?php
session_start();
if(!isset($_SESSION['username']) || !isset($_SESSION["permissions"]) || $_SESSION["permissions"]!="admin"){
  header("location: ../../index.php");
  die();
}
include("../methods.php");

$query = "SELECT id, ragione_sociale, comune, provincia, indirizzo FROM aziende";
if(isset($_POST["filters"])){
  $filtri = $_POST["filters"];
  $exit = true;
  foreach($filtri as $f){
    if($f != ""){
      $exit = false;
    }
  }
  if(!$exit){
    $query .= " WHERE";
    $i = 1;
    foreach($filtri as $key => $value){
      $query .= " " . $key . " LIKE \"%" . $value . "%\"";
      if($i == count($filtri)){
        break;
      }
      $query .= " AND ";
      $i++;
    }
<<<<<<< HEAD
  }
}

$query .= " ORDER BY ragione_sociale ASC";

=======
    // echo "___".$query."___";
  }
}
>>>>>>> 9fc2f9b53fad2c036b05ab9e1a84cfc034800081
echo json_encode(getAziendeBasic($query));


?>
