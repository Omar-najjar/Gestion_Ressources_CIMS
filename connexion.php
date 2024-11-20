<?php

  //connexion à la base de données
  $con = pg_connect("host=localhost user=postgres dbname=db_cims password=111999 port=5432");


  if(!$con){
     echo "Vous n'êtes pas connecté à la base de donnée";
     exit;
  
}
?>