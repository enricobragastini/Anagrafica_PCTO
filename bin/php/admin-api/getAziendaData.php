<?php
session_start();
if(!isset($_SESSION['username']) || !isset($_SESSION["permissions"]) || $_SESSION["permissions"]!="admin"){
  header("location: ../../index.php");
}
include("../methods.php");

if(!isset($_POST["id"])){
  die();
}

$id = $_POST["id"];
$azienda_info = getAziendaData($id);
$indirizzi = getIndirizziStudio($id);
$mansioni = getMansioni($id);

foreach ($indirizzi as $indirizzo) {
  foreach ($indirizzo as $key => $value) {
    $indirizzo[$key] = utf8_encode($value);
  }
}
foreach ($mansioni as $n => $mansione) {
  foreach ($mansione as $key => $value) {
    $mansioni[$n][$key] = utf8_encode($value);
  }
}

$azienda_info["indirizzi"] = $indirizzi;
$azienda_info["mansioni"] = $mansioni;

echo json_encode($azienda_info);

?>
