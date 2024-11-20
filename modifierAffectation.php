<?php
include_once "connexion.php";

// Affichage des erreurs PHP pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Vérifier si l'identifiant de l'affectation est passé en paramètre
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de l'affectation non spécifié.");
}

$id = $_GET['id'];

// Récupérer les informations de l'affectation
$query = "SELECT * FROM affectation WHERE id = $1";
$result = pg_query_params($con, $query, [$id]);

if (!$result) {
    die("Erreur lors de la récupération des données : " . pg_last_error($con));
}

$affectation = pg_fetch_assoc($result);

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_res = $_POST['ressource_id'];
    $id_etab = $_POST['etablissement_id'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];

    // Calcul du nombre de jours affectés
    $jours_affectes = 0;
    $jours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];

    foreach ($jours as $jour) {
        if (isset($_POST[$jour])) {
            $jours_affectes++;
        }
    }

    // Mettre à jour l'affectation dans la base de données
    $query = "UPDATE affectation 
              SET id_res = $1, id_etab = $2, lundi = $3, mardi = $4, mercredi = $5, jeudi = $6, vendredi = $7, samedi = $8, charge = $9, date_debut = $10, date_fin = $11
              WHERE id = $12";
    $result = pg_query_params($con, $query, [
        $id_res,
        $id_etab,
        isset($_POST['lundi']) ? 1 : 0,
        isset($_POST['mardi']) ? 1 : 0,
        isset($_POST['mercredi']) ? 1 : 0,
        isset($_POST['jeudi']) ? 1 : 0,
        isset($_POST['vendredi']) ? 1 : 0,
        isset($_POST['samedi']) ? 1 : 0,
        $jours_affectes,
        $date_debut,
        $date_fin,
        $id
    ]);

    if ($result) {
        echo "<p>Affectation mise à jour avec succès !</p>";
        // Rediriger vers la page de gestion des affectations
        header("Location: gestionAffectation.php");
        exit();
    } else {
        echo "<p>Erreur lors de la mise à jour de l'affectation.</p>";
        echo "<p>" . pg_last_error($con) . "</p>"; // Affiche les erreurs SQL
    }
}

// Récupérer les ressources et établissements pour les options du formulaire
$ressources = pg_query($con, "SELECT id_res, nom_res, prenom_res FROM ressource");
$etablissements = pg_query($con, "SELECT id_etab, nom_etab FROM etablissement");

if (!$ressources || !$etablissements) {
    die("Erreur lors de la récupération des données : " . pg_last_error($con));
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une affectation</title>
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
    
        .container {
            margin-left: 740px;
            margin-right: 740px;


            padding-top: 110px;
        }

        .container form {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .container form h2 {
            margin-top: 0;
        }

        .container form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .container form input[type="date"],
        .container form select,
        .container form button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #ddd;
            box-sizing: border-box;
        }

        .container form input[type="checkbox"] {
            margin-right: 10px;
        }

        .container form button {
            background-color: #2bc48a;
            color: white;
            border: none;
            cursor: pointer;
        }

        .container form button:hover {
            background-color: #1e9b6f;
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
<h1>Modifier une affectaion</h1>
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
    <form method="POST" action="">
        
        
        <label for="ressource_id">Ressource :</label>
        <select name="ressource_id" id="ressource_id" required>
            <?php while ($ressource = pg_fetch_assoc($ressources)) : ?>
                <option value="<?= $ressource['id_res'] ?>" <?= $ressource['id_res'] == $affectation['id_res'] ? 'selected' : '' ?>>
                    <?= $ressource['prenom_res'] . ' ' . $ressource['nom_res'] ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="etablissement_id">Établissement :</label>
        <select name="etablissement_id" id="etablissement_id" required>
            <?php while ($etablissement = pg_fetch_assoc($etablissements)) : ?>
                <option value="<?= $etablissement['id_etab'] ?>" <?= $etablissement['id_etab'] == $affectation['id_etab'] ? 'selected' : '' ?>>
                    <?= $etablissement['nom_etab'] ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="date_debut">Date de début :</label>
        <input type="date" id="date_debut" name="date_debut" value="<?= $affectation['date_debut'] ?>" required>

        <label for="date_fin">Date de fin :</label>
        <input type="date" id="date_fin" name="date_fin" value="<?= $affectation['date_fin'] ?>" required>

        <div>
            <label>Jours d'affectation :</label><br>
            <label><input type="checkbox" name="lundi" <?= $affectation['lundi'] == 't' ? 'checked' : '' ?>> Lundi</label><br>
            <label><input type="checkbox" name="mardi" <?= $affectation['mardi'] == 't' ? 'checked' : '' ?>> Mardi</label><br>
            <label><input type="checkbox" name="mercredi" <?= $affectation['mercredi'] == 't' ? 'checked' : '' ?>> Mercredi</label><br>
            <label><input type="checkbox" name="jeudi" <?= $affectation['jeudi'] == 't' ? 'checked' : '' ?>> Jeudi</label><br>
            <label><input type="checkbox" name="vendredi" <?= $affectation['vendredi'] == 't' ? 'checked' : '' ?>> Vendredi</label><br>
            <label><input type="checkbox" name="samedi" <?= $affectation['samedi'] == 't' ? 'checked' : '' ?>> Samedi</label><br>
        </div>

        <button type="submit">Mettre à jour</button>
    </form>
</div>

<footer class="footer">
    <div class="footer-content">
        <p>&copy; 2024 CIMS. Tous droits réservés.</p>
        <p>Contact : support@cims.com | Tél : +123 456 789</p>
    </div>
</footer>
</body>
</html>
