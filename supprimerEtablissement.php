<?php
  //connexion a la base de données
  include_once "connexion.php";
  //récupération de l'id dans le lien
  $id_etab= $_GET['id'];
  //requête de suppression
  $req = pg_query($con , "DELETE FROM etablissement WHERE id_etab = $id_etab");
  //redirection vers la page index.php
  header("Location:gestionEtablissement.php")
?>