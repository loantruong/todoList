<?php
  $titlePage = "Ajouter un nouveau projet";
  require_once "includes/header.php";
?>

<div class="container">
  <!-- message d'erreur -->
  <?php
    messageError("erreur", "ATTENTION ! Le nom du projet est obligatoire !");
    messageError("erreurDate" , "ATTENTION, la date n'est pas bonne !");
    messageError("erreurSQL", "Problème SQL ..:/");
  ?>

  <p class="button">
    <a href="index.php">retour</a>
  </p>

  <!-- Création du formulaire -->
  <form method="post" action="">
    <div>
      <label for="name">Nom du projet* :</label>
      <input type="text" name="name" id="name" value="<?php writeGet("name") ?>" required/>
    </div>
    <div>
      <label for="client">Client :</label>
      <input type="text" name="client" id="client"/>
    </div>
    <div>
      <label for="typeproject">Type :</label>
        <select name="type" id="type">
        <?php
          createHtmlOptions($types);
        ?>
      </select>
    </div>

    <div>
      <label for="dateline">Dateline* :</label>
      <input type="date" name="dateline" id="dateline" placeholder="JJ/MM/AAAA" required/>
    </div>
    <div>
      <label for="status">Status :</label>
        <select name="status" id="status">
          <?php
            createHtmlOptions($statuses);
          ?>
        </select>
      </label>
    </div>
    <div>
      <label for="comment">Commentaire :</label>
      <textarea name="comment" id="comment"></textarea>
    </div>
    <div>
      <input type="submit" value="Ajouter le projet" name="send" class="button-submit"/>
    </div>
  </form>

<!-- Traitement du formulaire -->
<?php
    if(isset($_POST["send"])){
      $name = $_POST["name"];
      $client =  $_POST["client"];
      $type = $_POST["type"];
      $dateline = $_POST["dateline"];
      $project_status = $_POST["status"];
      $comment = $_POST["comment"];

      $date_create = date("Y-m-d");

      //transforme la date saisie en format PHP (AAAA/MM/JJ)
      if(strpos($dateline, "/") != 0){
        list($day, $month, $year) = explode("/", $dateline);
        //check si les trois peuvent former une date_create_project
        if(checkdate($day, $month, $year)){
          $dateline = "$year-$month-$day";
        }else{
          header("location:add_project.php?erreurDate&project=name");
          exit();
        }
      }

      //gérer saut de ligne dans le textarea
      $comment = ereg_replace(chr(13),'<br />', $comment);

      $insert = $bdd->prepare('INSERT INTO projects(date_create_project, client_project, name_project, type_project, dateline_project, status_project, comment_project) VALUES(:newdate, :client, :name, :type, :dateline, :status, :comment)');
      $exec = $insert->execute(array(
        'newdate' => $date_create,
        'client' => $client,
        'name' => $name,
        'type' => $type,
        'dateline' => $dateline,
        'status' => $project_status,
        'comment' => $comment
      ));

      //afficher si erreur SQL
      if(!$exec){
        echo "<p> Problème de requête : <br />";
        print_r($bdd->errorInfo()) . "</p>";
        header("location:add_project.php?erreurSQL&name=$name&client=$client&type=$type&dateline=$dateline&status=$status&comment=$comment");
        exit();
      }else{
        header("location:index.php?ajout");
        exit();
      }
    }
  ?>

<?php
  require_once "includes/footer.php";
?>
