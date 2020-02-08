<?php
session_start();
if(!isset($_SESSION['username']) || !isset($_SESSION["permissions"]) || $_SESSION["permissions"]!="admin"){
  header("location: ../../index.php");
}
include("../methods.php");

if(!isset($_GET["id"])){
  die();
}

$id = $_GET["id"];

// inizializzo cURL
$ch = curl_init();

// imposto la URL della risorsa remota da scaricare
curl_setopt($ch, CURLOPT_URL, "https://search.codiceateco.it/atecosearch?callback=jQuery321037759233561823424_1580579806538&q=" . $id);

// imposto che non vengano scaricati gli header
curl_setopt($ch, CURLOPT_HEADER, 0);

curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36');

curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// eseguo la chiamata
curl_exec($ch);

$output = curl_exec($ch);

// chiudo cURL
curl_close($ch);


var_dump($output);

?>
