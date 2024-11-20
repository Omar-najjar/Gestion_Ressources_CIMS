<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifieretablissement</title>
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
<h1>Modifier un établissement</h1>
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
          $id_etab = $_GET['id'];


          $nom_etab = $_POST['nom'] ?? null;
          $nomarabe_etab = $_POST['nom_arabe'] ?? null;
          $titre_etab = $_POST['titre'] ?? null;
          $type_etab = $_POST['type'] ?? null;
          $gouvernorat_etab = $_POST['gouvernorat'] ?? null;

          //requête pour afficher les infos d'un employé
          $req = pg_query($con , "SELECT * FROM etablissement WHERE id_etab = $id_etab");
          $row = pg_fetch_assoc($req);


       //vérifier que le bouton ajouter a bien été cliqué
       if(isset($_POST['buttoneEtab'])){

           //extraction des informations envoyé dans des variables par la methode POST
           extract($_POST);
           //verifier que tous les champs ont été remplis
           if(isset($nom_etab) &&   isset($nomarabe_etab) &&  isset($titre_etab) &&isset($type_etab) && isset($gouvernorat_etab)){

             // échapper les valeurs pour éviter les injections SQL
        $nom_etab = pg_escape_string($con, $nom_etab);
        $nomarabe_etab = pg_escape_string($con, $nomarabe_etab);
        $titre_etab = pg_escape_string($con, $titre_etab);
        $type_etab = pg_escape_string($con, $type_etab);
        $gouvernorat_etab = pg_escape_string($con, $gouvernorat_etab);

               //requête de modification
               $req = pg_query($con, "UPDATE etablissement SET nom_etab = '$nom_etab' , nomarabe_etab = '$nomarabe_etab' , titre_etab = '$titre_etab', type_etab = '$type_etab' , gouvernorat_etab = '$gouvernorat_etab' WHERE id_etab = $id_etab");
                if($req){//si la requête a été effectuée avec succès , on fait une redirection
                    header("location: gestionEtablissement.php");
                }else {//si non
                    $message = "etablissement non modifié";
                }

           }else {
               //si non
               $message = "Veuillez remplir tous les champs !";
           }
       }
    
    ?>



    <div class="main-content">
        <!-- Formulaire de gestion des employés -->
        <div class="formEtab">
            <a href="gestionEtablissement.php" class="back_btnEtab"><img src="images/back.png"> Retour</a>
            
            <p class="erreur_message">
                <?php 
                   if(isset($message)){
                       echo $message ;
                   }
                ?>
             </p>
            <form action="" method="POST">
                <div class="formEtab-group">
                    <label>Nom</label>
                    <input type="text" name="nom" value="<?=$row['nom_etab']?>" required>
                </div>
                
               
                <div class="formEtab-group">
                    <label>Nom (arabe)</label>
                    <input type="text" name="nom_arabe" value="<?=$row['nomarabe_etab']?>" required>
                </div>

                <div class="formEtab-group">
                    <label>Titre</label>
                    <select name="titre" required>
                        <option value=" الي السيد مدير" <?= $row['titre_etab'] == 'الي السيد مدير ' ? 'selected' : '' ?>>الي السيد مدير </option>
                        <option value=" الي السيد مديرة" <?= $row['titre_etab'] == ' الي السيد مديرة' ? 'selected' : '' ?>> الي السيد مديرة</option>
                    </select>
                </div>
                
                <div class="formEtab-group">
                    <label>Type</label>
                    <input type="text" name="type" value="<?=$row['type_etab']?>" required>
                </div>
                
                <div class="formEtab-group">
                    <label>Gouvernorat</label>
                    <select id="gouvernorat" name="gouvernorat">
                        <option <?= $row['gouvernorat_etab'] == 'Ariana' ? 'selected' : '' ?>>Ariana</option>
                        <option <?= $row['gouvernorat_etab'] == 'Béja' ? 'selected' : '' ?>>Béja</option>
                        <option <?= $row['gouvernorat_etab'] == 'Ben Arous' ? 'selected' : '' ?>>Ben Arous</option>
                        <option <?= $row['gouvernorat_etab'] == 'Bizerte' ? 'selected' : '' ?>>Bizerte</option>
                        <option <?= $row['gouvernorat_etab'] == 'Gabès' ? 'selected' : '' ?>>Gabès</option>
                        <option <?= $row['gouvernorat_etab'] == 'Gafsa' ? 'selected' : '' ?>>Gafsa</option>
                        <option <?= $row['gouvernorat_etab'] == 'Jendouba' ? 'selected' : '' ?>>Jendouba</option>
                        <option <?= $row['gouvernorat_etab'] == 'Kairouan' ? 'selected' : '' ?>>Kairouan</option>
                        <option <?= $row['gouvernorat_etab'] == 'Kasserine' ? 'selected' : '' ?>>Kasserine</option>
                        <option <?= $row['gouvernorat_etab'] == 'Kébili' ? 'selected' : '' ?>>Kébili</option>
                        <option <?= $row['gouvernorat_etab'] == 'Kef' ? 'selected' : '' ?>>Kef</option>
                        <option <?= $row['gouvernorat_etab'] == 'Mahdia' ? 'selected' : '' ?>>Mahdia</option>
                        <option <?= $row['gouvernorat_etab'] == 'Manouba' ? 'selected' : '' ?>>Manouba</option>
                        <option <?= $row['gouvernorat_etab'] == 'Médenine' ? 'selected' : '' ?>>Médenine</option>
                        <option <?= $row['gouvernorat_etab'] == 'Monastir' ? 'selected' : '' ?>>Monastir</option>
                        <option <?= $row['gouvernorat_etab'] == 'Nabeul' ? 'selected' : '' ?>>Nabeul</option>
                        <option <?= $row['gouvernorat_etab'] == 'Sfax' ? 'selected' : '' ?>>Sfax</option>
                        <option <?= $row['gouvernorat_etab'] == 'Sidi Bouzid' ? 'selected' : '' ?>>Sidi Bouzid</option>
                        <option <?= $row['gouvernorat_etab'] == 'Siliana' ? 'selected' : '' ?>>Siliana</option>
                        <option <?= $row['gouvernorat_etab'] == 'Sousse' ? 'selected' : '' ?>>Sousse</option>
                        <option <?= $row['gouvernorat_etab'] == 'Tataouine' ? 'selected' : '' ?>>Tataouine</option>
                        <option <?= $row['gouvernorat_etab'] == 'Tozeur' ? 'selected' : '' ?>>Tozeur</option>
                        <option <?= $row['gouvernorat_etab'] == 'Tunis' ? 'selected' : '' ?>>Tunis</option>
                        <option <?= $row['gouvernorat_etab'] == 'Zaghouan' ? 'selected' : '' ?>>Zaghouan</option>
                    </select>
                </div>
                
                <div class="formEtab-group">
                  
                    <button type="submit" value="Enregistrer" class="submit-btnEtab"  name="buttoneEtab">Soumettre</button>
                    <button href="gestionEtablissement.php" type="submit" value="Annuler" class="Annuler-btnEtab" id="Annuler-btnetab">Annuler</button>
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