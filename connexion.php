<?php
try{
  $bdd = new PDO('mysql:host=localhost;dbname=todo_liste', 'root', '' );
}

catch (Exception $e){
  die('Erreur : ' .$e->getMessage());
}

//heure france
date_default_timezone_set("Europe/Paris");

//exécuter les futures requêtes en utf8
$bdd->exec('SET NAMES UTF8');
?>
