<?php
session_start();
if(!isset($_SESSION['username']) || !isset($_SESSION["permissions"]) || $_SESSION["permissions"]!="admin"){
  header("location: ../../index.php");
  die();
}
include("../methods.php");

$query = "SELECT a.id, a.ragione_sociale, a.comune, a.provincia, a.indirizzo, ir.id_indirizzo indirizzi_st FROM aziende a LEFT JOIN indirizzi_richiesti ir ON a.id = ir.id_azienda";
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
  }
}

$query .= " ORDER BY ragione_sociale ASC";

$aziende = getAziendeBasic($query);

$new_aziende = array();
foreach($aziende as $a){
  $index = -1;
  for($i = 0; $i < count($new_aziende); $i++){
    if($new_aziende[$i]["ragione_sociale"] == $a["ragione_sociale"]){
      $index = $i;
    }
  }
  if($index == -1){
    $indirizzo = $a["indirizzi_st"];
    $a["indirizzi_st"] = array($indirizzo);
    if(is_null($indirizzo)){
      $a["indirizzi_st"] = array();
    }
    array_push($new_aziende, $a);
  } else {
    array_push($new_aziende[$index]["indirizzi_st"], $a["indirizzi_st"]);
  }
}

echo json_encode($new_aziende);

?>
