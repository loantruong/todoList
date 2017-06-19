<?php
  $titlePage = "Supprimer le projet";
  require_once "includes/header.php";
?>

<div class="container">
  <!-- message d'erreur -->
  <?php
    messageError("erreurDelete", "hum.. il semble y avoir un petit problème avec la suppression du projet");
  ?>

  <p class="button">
    <a href="index.php">retour</a>
  </p>

  <!-- Récupérer les infos de l'id du projet à modifier -->
  <?php
    $id = $_GET["id"];
    $update = "SELECT * FROM projects WHERE id_project=$id";
    $exec = $bdd->query($update);

    $project = $exec->fetch();
    $date_create = $project["date_create_project"];
    $client = $project["client_project"];
    $name = $project["name_project"];
    $type = $project["type_project"];
    $dateline = $project["dateline_project"];
    $status = $project["status_project"];
    $comment = $project["comment_project"];

    echo "<h2>Résumé du projet</h2>";
    echo "<ul>";
    echo "<li><span class='bold'>Nom du projet : </span>$name</li>";
    echo "<li><span class='bold'>Client : </span>$client</li>";
    echo "<li><span class='bold'>Type : </span>$type</li>";
    echo "<li><span class='bold'>Dateline : </span>$dateline</li>";
    echo "<li><span class='bold'>Status : </span>$status</li>";
    echo "<li><span class='bold'>Commentaire : </span>$comment</li>";
    echo "</ul>";

  ?>

  <!-- Création du formulaire avec les données existantes-->
  <form method="post" action="">
      <input type="submit" value="Confirmer la suppression" name="send" class="button-submit"/>
    </div>
  </form>

  <!-- Traitement du formulaire de suppression -->
  <?php
    if(isset($_POST["send"])){
      $delete = "DELETE FROM projects WHERE id_project=$id";
      $exec = $bdd->query($delete);

      if(!$exec){
        header("location:delete_project.php?erreurDelete&id=$id");
        exit();
      }else{
        header("location:index.php?supprimer");
        exit();
      }
  }
  ?>

</div>
<?php
  require_once "includes/footer.php";
?>
