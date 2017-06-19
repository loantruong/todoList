<?php
  $titlePage = "Modifier le projet";
  require_once "includes/header.php";
?>

<div class="container">
  <!-- message d'erreur -->
  <?php
    messageError("erreur", "ATTENTION ! Le nom du projet est obligatoire !");
    messageError("erreurDate" , "ATTENTION, la date n'est pas bonne !");
    messageError("erreurSQL", "Problème SQL ..:/");
    messageError("erreurModification" , "Oups, nous rencontrons un problème avec la modification");
  ?>

  <p  class="button">
    <a href="index.php">retour</a>
  </p>

  <!-- Récupérer les infos de l'id du projet à modifier -->
  <?php
    $id = $_GET["id"];
    $update = "SELECT * FROM projects WHERE id_project='$id'";
    $exec = $bdd->query($update);

    $project = $exec->fetch();
    $date_create = $project["date_create_project"];
    $client = $project["client_project"];
    $name = $project["name_project"];
    $type = $project["type_project"];
    $dateline = $project["dateline_project"];
    $project_status = $project["status_project"];
    $comment = $project["comment_project"];
    //$comment = preg_replace('<br />', "\n", $comment);*
    $comment = str_replace(array("<br />"), "\n", $comment);
  ?>

  <!-- Création du formulaire avec les données existantes-->
  <form method="post" action="">
    <div>
      <label for="name">Nom du projet* :</label>
      <input type="text" name="name" id="name" value="<?php echo $name ?>" required/>
    </div>
    <div>
      <label for="client">Client :</label>
      <input type="text" name="client" id="client" value="<?php echo $client ?>"/>
    </div>
    <div>
      <label for="type">Type :</label>
      <select name="type" id="type">
        <?php
        createHtmlOptions($types, $type);
        ?>
      </select>
    </div>

    <div>
      <label for="dateline">Dateline* :</label>
      <input type="date" name="dateline" id="dateline" placeholder="JJ/MM/AAAA" value="<?php echo $dateline ?>" required/>
    </div>
    <div>
      <label for="status">Status :</label>
      <select name="status" id="status">
        <?php
          createHtmlOptions($statuses, $project_status);
        ?>
      </select>
    </div>
    <div>
      <label for="comment">Commentaire :</label>
      <textarea name="comment" id="comment"><?php echo $comment ?></textarea>
    </div>
    <div>
      <input type="submit" value="Confirmer la modification" name="send" class="button-submit"/>
    </div>
  </form>

<!-- Traitement du formulaire de modification -->
<?php
    if(isset($_POST["send"])){
      //si on clique sans remplir les *
      $name = $_POST["name"];
      $client = $_POST["client"];
      $type = $_POST["type"];
      $dateline = $_POST["dateline"];
      $status = $_POST["status"];
      $comment = $_POST["comment"];
      //convertir les sauts de lignes en balise html
      $comment = str_replace(array("\n"), "<br />", $comment);

      //transforme la date saisie en format PHP (AAAA/MM/JJ)
      if(strpos($dateline, "/") != 0){
        list($day, $month, $year) = explode("/", $dateline);
        //check si les trois peuvent former une date_create_project
        if(checkdate($day, $month, $year)){
          $dateline = "$year-$month-$day";
        }else{
          header("location:add_project.php?erreurDate");
          exit();
        }
      }


      //$update = $bdd->prepare('UPDATE projects(client_project, name_project, type_project, dateline_project, status_project, comment_project) SET (:$client, :$name, :$type, :$dateline, :$status, :$comment) WHERE id_project = :$id');
      $update = $bdd->prepare('UPDATE projects SET client_project = :client, name_project = :name, type_project = :project, type_project = :type, dateline_project = :dateline, status_project = :status, comment_project = :comment WHERE id_project = :id');
      $exec = $update->execute(array(
            'client' => $client,
            'name' => $name,
            'project' => $project,
            'type' => $type,
            'dateline' => $dateline,
            'status' => $status,
            'comment' => $comment,
            'id' => $id
          ));

      if(!$exec){
        header("location:edit_project.php?erreurModification&id=$id&client=$client&name=$name&type=$type&dateline=$dateline&status=$status&comment=$comment");
        exit();
      }else{
        header("location:index.php?modifier");
        exit();
      }
    }
  ?>

</div>

<?php
  require_once "includes/footer.php";
?>
