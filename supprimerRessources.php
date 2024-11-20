<?php
  //connexion a la base de données
  include_once "connexion.php";
  //récupération de l'id dans le lien
  $id_res= $_GET['id'];
  //requête de suppression
  $req = pg_query($con , "DELETE FROM ressource WHERE id_res = $id_res");
  //redirection vers la page index.php
  header("Location:gestionRessources.php")
?>