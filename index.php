<?php
  $titlePage = "My todo list";
  require_once "includes/header.php";
?>
        <p class="button-add-project">
          <a href="add_project.php">
            <span class="icon-add"></span>
            ajouter un projet
          </a>
        </p>

<!-- Message -->
  <?php
    messageSuccess("ajout", "Un nouveau projet vient d'être ajouté !");
    messageSuccess("modifier", "Le projet à bien été mise à jour !");
    messageSuccess("supprimer", "Le projet à bien été supprimé !");
    ?>

<!-- Tableau -->
    <table id="board">
      <tr id="board-title">
        <th>Date de création</th>
        <th>Client</th>
        <th id="projet">PROJET</th>
        <th>Type</th>
        <th>Dateline</th>
        <th>Status</th>
        <th>Commentaire</th>
        <th>modifier</th>
        <th>supprimer</th>
      </tr>

      <!-- Récupérer les données de la table Project -->
      <?php
        //préparer la requête SQL
        $select = "SELECT * FROM projects";
        $exec = $bdd->query($select);

        //affiche un message d'erreur si pb de requête
        if(!$exec){
          echo "<p>
          problème de requête : <br />";
          echo mysqli_erro($bdd) . "
          </p>";
          exit();
        }else{
          //définition varibale en fonction de la bdd
          while($project = $exec->fetch()){
            $id = $project["id_project"];
            $date_create = $project["date_create_project"];
            $client = $project["client_project"];
            $name = $project["name_project"];
            $type = $project["type_project"];
            $dateline = $project["dateline_project"];
            $project_status = $project["status_project"];
            $comment = $project["comment_project"];

            //transforme la date AAAA-MM-JJ en JJ/MM/AAAA-MM-JJ
            $date_create = strftime("%d/%m/%Y", strtotime($date_create));
            $dateline = strftime("%d/%m/%Y", strtotime($dateline));

            //$option = $projet_status;

            //création du tableau
            echo "<tr>";
            echo "<td>$date_create</td>";
            echo "<td>$client</td>";
            echo "<td>$name</td>";
            echo "<td>$types[$type]</td>";
            echo "<td>$dateline</td>";
            echo "<td class='$project_status'>$statuses[$project_status]</td>";

            echo "<td class='comment-size'>$comment</td>";
            echo "<td class='text-center'>
                    <a href='edit_project.php?id=$id'>
                      <img src='img/edit.svg' class='icon' alt='icon edit the project'/>
                    </a>
                  </td>";
            echo "<td class='text-center'>
                    <a href='delete_project.php?id=$id'>
                      <img src='img/delete.svg' class='icon' alt='icon delete the project'/>
                    </a>
                  </td>";

            echo "</tr>";
          }
        }


        //var_dump($co);
      ?>

    </table>

<?php
  require_once "includes/footer.php";
?>
