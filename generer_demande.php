<?php
// Inclure la connexion à la base de données
include_once 'connexion.php';

// Récupérer toutes les ressources et établissements
$ressources = pg_query($con, "SELECT id_res, nomarabe_res, prenomarabe_res, titre_res FROM ressource");
$etablissements = pg_query($con, "SELECT id_etab, nomarabe_etab, titre_etab FROM etablissement");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Générer une Demande</title>
    <link rel="stylesheet" href="style.css"/>

    <style>

/* style.css */

 
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





h2 {
    text-align: center;
    font-weight: bold;
    margin-bottom: 20px;
    margin-top: 10%;
    font-size: 30px;
    color: #333;
}



label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    font-size: 20px;
    font-family: 'Arial', sans-serif; /* Choix d'une police lisible */
    color:  #007FA9; /* Couleur du texte plus douce */
    letter-spacing: 0.5px; /* Espacement des lettres pour améliorer la lisibilité */
    transition: color 0.3s ease; /* Effet de transition pour un changement de couleur fluide */
}

label:hover {
    color: #005f7a; /* Changement de couleur au survol pour un effet interactif */
}

select {
    margin: 15px 0;
    padding: 12px;
    width: 100%;
    border: 2px solid #55D5E0;
    border-radius: 50px;
    font-size: 1rem;
    transition: border 0.3s ease-in-out;
}





    /* Formulaire */
    .form-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: calc(1vh - 120px); /* Ajustement pour le header et le footer */
    padding-bottom: 10px;
}

form {
    background-color: white;
    padding: 60px;
    border-radius: 10px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    width: 100%;
    max-width: 400px;
    text-align: center;
}



input {
    margin: 15px 0;
    padding: 12px;
    width: 100%;
    border: 2px solid #007FA9;
    border-radius: 50px;
    font-size: 1rem;
    transition: border 0.3s ease-in-out;
}

select:focus {
    border-color: #4CAF50;
    outline: none;
    box-shadow: 0 0 8px rgba(76, 175, 80, 0.5);
}

button {
    padding: 12px;
    background-color: #007FA9;
    color: white;
    border: none;
    border-radius: 50px;
    font-size: 1rem;
    cursor: pointer;
    width: 100%;
    transition: background-color 0.3s, transform 0.2s;
    margin-top: 20px;
}

button:hover {
    background-color: #005f7a;
    transform: translateY(-2px);
}

button:active {
    transform: translateY(1px);
}



</style>
</head>
<body>
<header class="headeer">
<img class="img1" src="images/logo.png" alt="CIMS">
<h1>Générer une demande</h1>
<img class="img2" src="images/topleft1.png" alt="Ministère">
    
</header>

<aside>
        <nav>
            <a style="padding-top: 30px;" href="gestionRessources.php">Gestion des ressources</a>
            <a href="gestionEtablissement.php">Gestion des établissements</a>
            <a href="gestionCompetences.php">Gestion des Compétences</a>
            <a href="gestionAffectation.php">Gestion des affectations</a>
            <a href="gestionRessourceCompétences.php">Gestion des Evaluations</a>
            <a href="generer_demande.php">Générer une demande</a>
        </nav>
    </aside>


<div class="form-container">
    
    <form action="generer_document.php" method="POST">
        <label for="ressource">Ressource :</label>
        <select name="ressource" id="ressource" required>
            <option value="">Sélectionnez...</option>
            <?php while ($row = pg_fetch_assoc($ressources)): ?>
                <option value="<?= htmlspecialchars($row['id_res']) ?>"><?= htmlspecialchars($row['nomarabe_res'] . " " . $row['prenomarabe_res']) ?></option>
            <?php endwhile; ?>
        </select>

        <label for="etablissement">Établissement :</label>
        <select name="etablissement" id="etablissement" required>
            <option value="">Sélectionnez...</option>
            <?php while ($row = pg_fetch_assoc($etablissements)): ?>
                <option value="<?= htmlspecialchars($row['id_etab']) ?>"><?= htmlspecialchars($row['nomarabe_etab']) ?></option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Télecharger</button>
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


