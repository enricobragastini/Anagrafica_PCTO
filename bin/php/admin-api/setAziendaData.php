<?php
session_start();
include("php/methods.php");
if(!isset($_SESSION['username']) || !isset($_SESSION["permissions"]) || $_SESSION["permissions"]!="admin"){
  header("location: ../../index.php");
}
include("../methods.php");

if(!isset($_POST["idAzienda"]) || !isset($_POST["attribute"]) || !isset($_POST["value"])){
  die_on_error("Missing necessary parameters");
}


$fields = array();    // Array che contiene i nomi degli attributi della tabella aziende

$query = "SHOW COLUMNS FROM aziende";  // Restituisce una vista con i campi "Field", "Type", "Null", "Key", "Default", "Extra"
$conn = dbConnect();
try {
  $stmt = $conn->prepare($query);
  $stmt->execute(array($username, $password));
  $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
  foreach($row as $field){
    if($field["Field"] == "id"){
      continue;
    }
    array_push($fields, $field);
  }
} catch(PDOException $ex) {
  die();
}
$invalid = true;
foreach($fields as $f){
  if($_POST["attribute"] == $f["Field"]){    // Manca controllo sul tipo di dato
    $invalid = false;
    $status = setAziendaValue($_POST["idAzienda"], $_POST["attribute"],$_POST["value"]);
    die(json_encode(array("status" => $status)));
  }
}

if($invalid){
  die_on_error("Invalid data inputs");
}

?>
