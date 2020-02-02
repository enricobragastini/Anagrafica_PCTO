<?php

define("DB_ADDRESS", "localhost");
define("DB_USERNAME", "aziendepcto");
define("DB_PASSWORD", "");
define("DB_NAME", "my_aziendepcto");

function dbConnect(){
  // Funzione che instaura una connessione con il database
  try {
    $conn = new PDO("mysql:host=".DB_ADDRESS.";dbname=".DB_NAME."", DB_USERNAME, DB_PASSWORD, array(PDO::ATTR_PERSISTENT => true));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);;
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

function getUserDeta($username){
  // Funzione che restituisce i dettagli di un utente
  $query = "SELECT nome, cognome, permissions from users WHERE username=?";
  $conn = dbConnect();
  try {
    $stmt = $conn->prepare($query);
    $stmt->execute(array($username));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
  } catch(PDOException $ex) {
    return false;
  }
}

function getAziendeBasic($query){
<<<<<<< HEAD
  // Funzione che recupera dal db le informazioni richieste per la tabella admin
=======
>>>>>>> 9fc2f9b53fad2c036b05ab9e1a84cfc034800081
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

<<<<<<< HEAD
function startsWith($haystack, $needle){
  $length = strlen($needle);
  return (substr($haystack, 0, $length) === $needle);
}

=======
>>>>>>> 9fc2f9b53fad2c036b05ab9e1a84cfc034800081
function getAziendaData($id){
  $query = "SELECT * FROM aziende WHERE aziende.id=?";
  $conn = dbConnect();
  try {
    $stmt = $conn->prepare($query);
    $stmt->execute(array($id));
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
<<<<<<< HEAD
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
=======
>>>>>>> 9fc2f9b53fad2c036b05ab9e1a84cfc034800081
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

<<<<<<< HEAD
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

=======
>>>>>>> 9fc2f9b53fad2c036b05ab9e1a84cfc034800081
?>
