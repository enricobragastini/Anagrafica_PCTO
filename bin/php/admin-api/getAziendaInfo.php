<?php
session_start();
if(!isset($_SESSION['username']) || !isset($_SESSION["permissions"]) || $_SESSION["permissions"]!="admin"){
  header("location: ../../index.php");
}
include("../methods.php");

if(!isset($_POST["idAzienda"])){
  die_with_error("undefined id");
}

$id = $_POST["idAzienda"];

$info = getAziendaOtherInfo($id);
echo json_encode($info);

?>
