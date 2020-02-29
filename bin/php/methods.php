<?php

define("DB_ADDRESS", "localhost");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
define("DB_NAME", "my_aziendepcto");

function die_on_error($error){
  die(json_encode(array("error" => $error)));
}

function dbConnect(){
  // Funzione che instaura una connessione con il database
  try {
    $conn = new PDO("mysql:host=".DB_ADDRESS.";dbname=".DB_NAME."", DB_USERNAME, DB_PASSWORD, array(PDO::ATTR_PERSISTENT => true));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    return $conn;
  } catch(PDOException $exception){
    return false;
  }
}

function loginCheck($username, $password){
  // Funzione che verifica le credenziali sul database
  $query = "SELECT COUNT(id) results from users WHERE (username=? AND password=?)";
  $conn = dbConnect();
  try {
    $stmt = $conn->prepare($query);
    $stmt->execute(array($username, $password));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row["results"]==1;
  } catch(PDOException $ex) {
    return false;
  }
}

function updateLastAccess($username){
  // Funzione che verifica le credenziali sul database
  $query = "UPDATE users SET last_access = NOW() WHERE username=?";
  $conn = dbConnect();
  try {
    $stmt = $conn->prepare($query);
    $stmt->execute(array($username));
    return true;
  } catch(PDOException $ex) {
    return false;
  }
}

function getPermissions($username){
  // Funzione che restituise solo le credenziali di un utente
  $query = "SELECT permissions from users WHERE username=?";
  $conn = dbConnect();
  try {
    $stmt = $conn->prepare($query);
    $stmt->execute(array($username));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row["permissions"];
  } catch(PDOException $ex) {
    return false;
  }
}

function getUserData($username){
  // Funzione che restituisce i dettagli di un utente
  $query = "SELECT nome, cognome, permissions, last_access from users WHERE username=?";
  $conn = dbConnect();
  try {
    $stmt = $conn->prepare($query);
    $stmt->execute(array($username));
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result[0];
  } catch(PDOException $ex) {
    return false;
  }
}

function getAziendeBasic($query){
  // Funzione che recupera dal db le informazioni richieste per la tabella admin
  $conn = dbConnect();
  try {
    $stmt = $conn->prepare($query);
    $stmt->execute(array());
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  } catch(PDOException $ex) {
    return false;
  }
}

function startsWith($haystack, $needle){
  $length = strlen($needle);
  return (substr($haystack, 0, $length) === $needle);
}

function getAziendaData($id){
  $query = "SELECT * FROM aziende WHERE aziende.id=?";
  $conn = dbConnect();
  try {
    $stmt = $conn->prepare($query);
    $stmt->execute(array($id));
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result[0] as $key => $value) {
      if(is_null($value)){
        $result[0][$key] = "N/A";
      }
    }
    if(isset($result[0]["sito"])){
      if(startsWith($result[0]["sito"], "http://")){
        $result[0]["sito"] = str_replace("http://", "", $result[0]["sito"]);
      }
      if(startsWith($result[0]["sito"], "https://")){
        $result[0]["sito"] = str_replace("https://", "", $result[0]["sito"]);
      }
    }
    return $result[0];
  } catch(PDOException $ex) {
    return false;
  }
}

function getIndirizziStudio($id_azienda){
  $query = "SELECT titolo FROM indirizzi_studio i JOIN indirizzi_richiesti r on i.id=r.id_indirizzo JOIN aziende az on az.id=r.id_azienda WHERE az.id=?";
  $conn = dbConnect();
  try {
    $stmt = $conn->prepare($query);
    $stmt->execute(array($id_azienda));
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  } catch(PDOException $ex) {
    return false;
  }
}

function countAziende(){
  $query = "SELECT count(ragione_sociale) tot_aziende from aziende";
  $conn = dbConnect();
  try {
    $stmt = $conn->prepare($query);
    $stmt->execute(array());
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result[0]["tot_aziende"];
  } catch(PDOException $ex) {
    return false;
  }
}

function getMansioni($id_azienda){
  $query = "SELECT mansioni.id id, mansioni.titolo titolo, mansioni.descrizione descrizione FROM mansioni JOIN qualifiche on qualifiche.id_mansione=mansioni.id JOIN aziende on aziende.id=qualifiche.id_azienda WHERE aziende.id=?";
  $conn = dbConnect();
  try {
    $stmt = $conn->prepare($query);
    $stmt->execute(array($id_azienda));
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  } catch(PDOException $ex) {
    return false;
  }
}

function setAziendaValue($idAzienda, $attribute, $value){
  $query = "UPDATE aziende SET $attribute=? WHERE id=?";
  if($value == ""){
    $value = null;
  }
  $conn = dbConnect();
  try {
    $stmt = $conn->prepare($query);
    $stmt->execute(array("$value", $idAzienda));
    return ($stmt != false);
  } catch(PDOException $ex) {
    return $false;
  }
}

function getAziendaOtherInfo($idAzienda){
  $query = "SELECT i.id, i.titolo, i.descrizione FROM informazioni i JOIN aziende a ON i.id_azienda=a.id WHERE i.id_azienda=? ORDER BY i.id ASC";
  $conn = dbConnect();
  try {
    $stmt = $conn->prepare($query);
    $stmt->execute(array($idAzienda));
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  } catch(PDOException $ex) {
    return false;
  }
}

function getElencoIndirizzi(){
  $query = "SELECT * FROM indirizzi_studio";
  $conn = dbConnect();
  try {
    $stmt = $conn->prepare($query);
    $stmt->execute(array());
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  } catch(PDOException $ex) {
    return false;
  }
}

?>
