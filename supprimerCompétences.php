<?php
  //connexion a la base de données
  include_once "connexion.php";
  //récupération de l'id dans le lien
  $id_competences= $_GET['id'];
  //requête de suppression
  $req = pg_query($con , "DELETE FROM competences WHERE id_competences = $id_competences");
  //redirection vers la page index.php
  header("Location:gestionCompetences.php")
?>