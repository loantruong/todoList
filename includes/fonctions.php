<?php
  //message de succès
  function messageSuccess($index, $msg){
    if(isset($_GET[$index])){
      echo "<p class='message message-success'>$msg</p>";
    }
  }

  //message d'erreur
  function messageError($index, $msg){
    if(isset($_GET[$index])){
      echo "<p class='message message-error'>$msg</p>";
    }
  }

  //function qui récupère la valeur de GET
  function writeGet($index){
    if(isset($_GET[$index])){
      echo $_GET[$index];
    }
  }

  function createHtmlOptions($index, $option = null){

    foreach ($index as $key => $value) {
      if($option !== null && $key == $option){
          echo "<option selected value=$key>" . $value . "</option>";
      }else{
          echo "<option value=$key>" . $value . "</option>";
      }
    }
  }
?>
