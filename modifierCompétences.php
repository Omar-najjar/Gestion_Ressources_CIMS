<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une compétence</title>
    <link rel="stylesheet" href="style.css">

    <style>    
      
      body {
            background-color: #F8FBF1;
            font-family: 'Roboto', sans-serif;
        }

        /* En-tête */
        header.headeer {
            background-color: #9CD2D5;
            color: #FFFFFF;
            position: fixed;
            top: 0px;
            width: 100%;
            height: 80px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            z-index: 1000;
        }

        .img1 {
            width: 270px;
            height: auto;
            transform: translateX(60px); /* Déplace img1 vers la droite */

        }

        .img2 {
            width: 270px;
            height: auto;
            transform: translateX(-1px); /* Déplace img1 vers la droite */
        }

        aside {
            background-color: #0E918C;
            height: 100vh;
            width: 220px;
            position: fixed;
            top: 80px;
            padding: 20px;
            z-index: 999;
            left : 0;
            
        }

        aside nav a {
            display: block;
            color: #fff;
            text-decoration: none;
            padding: 15px 20px;
            font-weight: bold;
            margin-bottom: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            font-size: 18px;
        }

        aside nav a:hover {
            background-color: #5DA5B3;
            color: white;
        }
        h1 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700; /* Gras */
            font-size: 40px;
            background: linear-gradient(90deg, #00A0B0, #6A82FB);
            -webkit-background-clip: text;
            color: transparent;
            text-align: center;
            padding: 20px;
        }

           /* Footer */
           footer.footer {
            background-color: #007FA9;
            color: white;
            text-align: center;
            padding: 15px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        footer.footer p {
            margin: 0;
            font-size: 1rem;
        }

        </style>
</head>
<body>


    <header class="headeer">
    <img class="img1" src="images/logo.png" alt="CIMS">
<h1>Modifier une compétance</h1>
<img class="img2" src="images/topleft1.png" alt="Ministère">
    </header>
    
    
        <aside>
    
            <nav>
            <a href="gestionRessources.php">Gestion des ressources</a><br>
            <a href="gestionEtablissement.php">Gestion des établissements</a><br>
            <a href="gestionCompetences.php">Gestion des Compétences</a><br>
            <a href="gestionAffectation.php">Gestion des affectations</a><br>
            <a href="gestionRessourceCompétences.php">Gestion des Evaluations</a><br>
            <a href="generer_demande.php">Generer demande</a><br>
            </nav>
    
        </aside>
<?php

         //connexion à la base de donnée
          include_once "connexion.php";
         //on récupère le id dans le lien
          $id_competences = $_GET['id'];


          $nom_competence = $_POST['nom'] ?? null;
        

          //requête pour afficher les infos d'un employé
          $req = pg_query($con , "SELECT * FROM competences WHERE id_competences = $id_competences");
          $row = pg_fetch_assoc($req);


       //vérifier que le bouton ajouter a bien été cliqué
       if(isset($_POST['buttoneCompp'])){

           //extraction des informations envoyé dans des variables par la methode POST
           extract($_POST);
           //verifier que tous les champs ont été remplis
           if(isset($nom_competence)){

             // échapper les valeurs pour éviter les injections SQL
        $nom_competence = pg_escape_string($con, $nom_competence);
    

               //requête de modification
               $req = pg_query($con, "UPDATE competences SET nom_competence = '$nom_competence' WHERE id_competences = $id_competences");
                if($req){//si la requête a été effectuée avec succès , on fait une redirection
                    header("location: gestionCompetences.php");
                }else {//si non
                    $message = "competence non modifié";
                }

           }else {
               //si non
               $message = "Veuillez remplir tous les champs !";
           }
       }
    
    ?>



    <div class="main-content">
        <!-- Formulaire de gestion des employés -->
        <div class="formComp">
            <a href="gestionCompetences.php" class="back_btnComp"><img src="images/back.png"> Retour</a>
            
            <p class="erreur_message">
                <?php 
                   if(isset($message)){
                       echo $message ;
                   }
                ?>
             </p>
            <form action="" method="POST">
                <div class="formComp-group">
                    
                    <input type="text" name="nom" value="<?=$row['nom_competence']?>" required>
                </div>
                
               
              
               
                
                <div class="formEtab-group">
                  
                    <button type="submit" value="Enregistrer" class="submit-btnComp"  name="buttoneCompp">Soumettre</button>
                    <button href="gestionCompetences.php" type="submit" value="Annuler" class="Annuler-btnComp" id="Annuler-btnComp">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>

<footer class="footer">
    <div class="footer-content">
        <p>&copy; 2024 CIMS. Tous droits réservés.</p>
        <p>Contact : support@cims.com | Tél : +123 456 789</p>
    </div>
</footer>
</html>