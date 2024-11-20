<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une évaluation</title>
    <link rel="stylesheet" href="style.css"/>
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
<h1>Modifier une évaluation</h1>
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

<div class="container">
    <?php
    // Connexion à la base de données
    include_once "connexion.php";

    // Récupération de l'ID depuis l'URL
    $id_ressource_competences = $_GET['id'];

    // Récupérer les informations actuelles de la ressource compétence
    $req = pg_query($con, "SELECT * FROM ressource_competences WHERE id_ressource_competences = $id_ressource_competences");
    $row = pg_fetch_assoc($req);

    // Vérifier que le formulaire a été soumis
    if (isset($_POST['modifierComp'])) {
        $id_res = $_POST['id_res'];
        $id_competences = $_POST['id_competences'];
        $evaluation = $_POST['evaluation'];

        // Échapper les valeurs pour éviter les injections SQL
        $id_res = pg_escape_string($con, $id_res);
        $id_competences = pg_escape_string($con, $id_competences);
        $evaluation = pg_escape_string($con, $evaluation);

        // Requête de mise à jour
        $reqUpdate = pg_query($con, "UPDATE ressource_competences 
                                     SET id_res = '$id_res', id_competences = '$id_competences', evaluation = '$evaluation', date_modification = NOW() 
                                     WHERE id_ressource_competences = $id_ressource_competences");

        if ($reqUpdate) {
            // Redirection vers la page de gestion des compétences après mise à jour
            header("location: gestionRessourceCompétences.php");
        } else {
            $message = "Erreur lors de la mise à jour de la compétence.";
        }
    }
    ?>

    <div class="main-content">
        <div class="formComp">
            
            <p class="erreur_message">
                <?php 
                if (isset($message)) {
                    echo $message;
                }
                ?>
            </p>
            <form action="" method="POST">
                <div class="formComp-group">
                    <label>Ressource:</label>
                    <select id="id_res" name="id_res">
                        <?php
                        $reqRes = pg_query($con, "SELECT id_res, nom_res, prenom_res FROM ressource");
                        while ($rowRes = pg_fetch_assoc($reqRes)) {
                            $selected = $row['id_res'] == $rowRes['id_res'] ? 'selected' : '';
                            echo "<option value='" . $rowRes['id_res'] . "' $selected>" . $rowRes['nom_res'] . " " . $rowRes['prenom_res'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="formComp-group">
                    <label>Compétence:</label>
                    <select id="id_competences" name="id_competences">
                        <?php
                        $reqComp = pg_query($con, "SELECT id_competences, nom_competence FROM competences");
                        while ($rowComp = pg_fetch_assoc($reqComp)) {
                            $selected = $row['id_competences'] == $rowComp['id_competences'] ? 'selected' : '';
                            echo "<option value='" . $rowComp['id_competences'] . "' $selected>" . $rowComp['nom_competence'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="formComp-group">
                    <label>Évaluation:</label>
                    <input type="text" id="evaluation" name="evaluation" value="<?= $row['evaluation'] ?>" required>
                </div>

                <div class="formComp-group">
                    <button type="submit" name="modifierComp">Modifier</button>
                    <a href="gestionRessourceCompétences.php" class="btnAnnulerComp">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="footer-content">
        <p>&copy; 2024 CIMS. Tous droits réservés.</p>
        <p>Contact : support@cims.com | Tél : +123 456 789</p>
    </div>
</footer>

</body>
</html>
