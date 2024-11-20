<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Ressource</title>
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
    <h1>Modifier une ressources Technique</h1>
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
        // Connexion à la base de données
        include_once "connexion.php";

        // Récupération de l'ID dans le lien
        $id_res = $_GET['id'];

        // Variables POST avec une vérification si elles existent
        $nom_res = $_POST['nom'] ?? null;
        $prenom_res = $_POST['prenom'] ?? null;
        $nomarabe_res = $_POST['nom_arabe'] ?? null;
        $prenomarabe_res = $_POST['prenom_arabe'] ?? null;
        $num_telephone_res = $_POST['telephone'] ?? null;
        $titre_res = $_POST['titre'] ?? null;
        $fonction_res = $_POST['fonction'] ?? null;

        // Requête pour afficher les infos d'une ressource
        $req = pg_query($con, "SELECT * FROM ressource WHERE id_res = $id_res");
        $row = pg_fetch_assoc($req);

        // Vérifier que le bouton a bien été cliqué
        if (isset($_POST['buttoneRes'])) {
            // Vérifier que tous les champs ont été remplis
            if (
                isset($nom_res) && isset($prenom_res) && isset($nomarabe_res) && 
                isset($prenomarabe_res) && isset($num_telephone_res) && 
                isset($titre_res) && isset($fonction_res)
            ) {
                // Échapper les valeurs pour éviter les injections SQL
                $nom_res = pg_escape_string($con, $nom_res);
                $prenom_res = pg_escape_string($con, $prenom_res);
                $nomarabe_res = pg_escape_string($con, $nomarabe_res);
                $prenomarabe_res = pg_escape_string($con, $prenomarabe_res);
                $num_telephone_res = pg_escape_string($con, $num_telephone_res);
                $titre_res = pg_escape_string($con, $titre_res);
                $fonction_res = pg_escape_string($con, $fonction_res);

                // Requête de modification
                $req = pg_query($con, 
                "UPDATE ressource SET 
                    nom_res = '$nom_res', 
                    prenom_res = '$prenom_res', 
                    nomarabe_res = '$nomarabe_res', 
                    prenomarabe_res = '$prenomarabe_res', 
                    num_telephone_res = '$num_telephone_res', 
                    titre_res = '$titre_res', 
                    fonction_res = '$fonction_res' 
                WHERE id_res = $id_res"
            );
            
                if ($req) {
                    // Redirection en cas de succès
                    header("location: gestionRessources.php");
                } else {
                    // Message d'erreur en cas d'échec
                    $message = "Ressource non modifiée";
                }
            } else {
                // Message d'erreur si tous les champs ne sont pas remplis
                $message = "Veuillez remplir tous les champs !";
            }
        }
    ?>

    <div class="main-content">
        <!-- Formulaire de gestion des ressources -->
        <div class="form">
            <a href="gestionRessources.php" class="back_btn"><img src="images/back.png"> Retour</a>
            
            <p class="erreur_message">
                <?php 
                    if (isset($message)) {
                        echo $message;
                    }
                ?>
            </p>
            <form action="" method="POST">
                <div class="form-group">
                    <label>Nom</label>
                    <input type="text" name="nom" value="<?=$row['nom_res']?>" required>
                </div>
                
                <div class="form-group">
                    <label>Prénom</label>
                    <input type="text" name="prenom" value="<?=$row['prenom_res']?>" required>
                </div>
                
                <div class="form-group">
                    <label>Nom (arabe)</label>
                    <input type="text" name="nom_arabe" value="<?=$row['nomarabe_res']?>" required>
                </div>
                
                <div class="form-group">
                    <label>Prénom (arabe)</label>
                    <input type="text" name="prenom_arabe" value="<?=$row['prenomarabe_res']?>" required>
                </div>
                
                <div class="form-group">
                    <label>Numéro de téléphone</label>
                    <input type="text" name="telephone" placeholder="+21621123468" required value="<?=$row['num_telephone_res']?>">
                </div>
                
                <div class="form-group">
                    <label>Titre</label>
                    <select name="titre" required>
                        <option value=" السيد" <?= $row['titre_res'] == ' السيد' ? 'selected' : '' ?>> السيد</option>
                        <option value=" السيدة" <?= $row['titre_res'] == ' السيدة' ? 'selected' : '' ?>> السيدة</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Fonction</label>
                    <select name="fonction" required>
                        <option value="Correspendant" <?= $row['fonction_res'] == 'Correspendant' ? 'selected' : '' ?>>Correspendant</option>
                        <option value="Technicien" <?= $row['fonction_res'] == 'Technicien' ? 'selected' : '' ?>>Technicien</option>
                    </select>
                </div>
               
                <div class="form-group">
                    <button type="submit" value="Enregistrer" class="submit-btn" name="buttoneRes">Soumettre</button>
                    <button type="button" value="Annuler" class="Annuler-btn" id="Annul-btn">Annuler</button>
                </div>
            </form>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2024 CIMS. Tous droits réservés.</p>
            <p>Contact : support@cims.com | Tél : +123 456 789</p>
        </div>
    </footer>

    <script>
        document.getElementById("Annul-btn").addEventListener("click", function() {
           window.location.href = "gestionRessources.php";
        });
    </script>

</body>
</html>
