<?php

define("DB_ADDRESS", "localhost");
define("DB_USERNAME", "aziendepcto");
define("DB_PASSWORD", "");
define("DB_NAME", "my_aziendepcto");

function dbConnect(){
  try {
    $conn = new PDO("mysql:host=".DB_ADDRESS.";dbname=".DB_NAME."", DB_USERNAME, DB_PASSWORD, array(PDO::ATTR_PERSISTENT => true));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);;
    return $conn;
  } catch(PDOException $exception){
    return false;
  }
}

function loginCheck($username, $password){
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

?>
