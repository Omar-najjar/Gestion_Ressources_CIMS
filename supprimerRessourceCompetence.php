<?php
  //connexion a la base de données
  include_once "connexion.php";
  //récupération de l'id dans le lien
  $id_ressource_competences = $_GET['id'];
  //requête de suppression
  $req = pg_query($con , "DELETE FROM ressource_competences  WHERE id_ressource_competences  = $id_ressource_competences ");
  //redirection vers la page index.php
  header("Location:gestionRessourceCompétences.php")
?>