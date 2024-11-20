<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="style.css"/>

    <style>
    .Btn_adComp {
    width: fit-content;
    margin-bottom:20px;
    background-color: #2bc48a;
    padding: 5px 20px;
    color: #fff;
    display: flex;
    align-items: center;
    text-align: 0;
    border-radius: 6px;
    text-decoration: 0;
    position: absolute;
    top: 115px;
    left: 1172px;
}
.Btn_adComp img {
    margin-right: 5px;
    height: 20px;
}

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
    <h1>Gestion des compétences</h1>
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
// Vérifier que le bouton ajouter a bien été cliqué
if (isset($_POST['buttone'])) {
    $nom_competence = $_POST['nom'];
    

    if (!empty($nom_competence)) {
        include_once "connexion.php";
        $req = pg_query($con, "INSERT INTO competences(nom_competence) VALUES('$nom_competence')");
        if ($req) {
            header("location: gestionCompetences.php");
        } else {
            $message = "Compétence non ajouté";
        }
    } else {
        $message = "Veuillez remplir tous les champs !";
    }
}
?>

<div class="container">
    <a href="" class="Btn_addComp" id="add"><img src="images/plus.png"> Ajouter</a>
    <a href="index.php" class="Btn_adComp"><img src="images/quitter.png"> Retour</a>
    <div class="popup" id="popupForm">
        <form action="" method="POST">
            <h2>Ajouter une Compétence</h2>
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom">
        
            <button id="submitBtn" name="buttone">Soumettre</button>
            <button href="gestionCompetences.php" id="btnAnnuler" class="btnAnnulerComp">Annuler</button>
        </form>
    </div>
    <div class="overlay" id="overlay"></div>

    <script>
        document.getElementById('add').addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('popupForm').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        });

        document.getElementById('overlay').addEventListener('click', function() {
            document.getElementById('popupForm').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        });

        function confirmerSuppression(url) {
            if (confirm("Êtes-vous sûr de vouloir supprimer cette compétence ?")) {
                window.location.href = url;
            }
        }
    </script>

    <!-- Formulaire de recherche -->
    <form method="GET" action="gestionCompetences.php">
        <input type="text" name="search" id="searchInputComp" placeholder="Rechercher...">
        <button type="submit" id="searchIcon"><img src="images/cherche.png" class="iconchercherComp"></button>
    </form>

    <table class="tableComp">
        <tr id="items">
            <th>ID</th>
            <th>Nom</th>
        </tr>
        <?php
        include_once "connexion.php";

        // Récupérer le terme de recherche, s'il existe
        $search = isset($_GET['search']) ? pg_escape_string($_GET['search']) : '';

        // Construire la requête SQL avec filtrage
        $query = "SELECT * FROM competences WHERE 
            nom_competence ILIKE '%$search%'";

        // Exécuter la requête
        $req = pg_query($con, $query);

        // Vérifier si la requête a réussi
        if (!$req) {
            echo "Il n'y a pas encore de competence ajoutés !";
        } else {
            // Afficher les résultats
            while ($row = pg_fetch_assoc($req)) {
                ?>
                <tr>
                    <td><?=$row['id_competences']?></td>
                    <td><?=$row['nom_competence']?></td>
                    <td><a href="modifierCompétences.php?id=<?=$row['id_competences']?>"><img src="images/pen.png" alt="modifier"></a></td>
                    <td><a href="#" onclick="confirmerSuppression('supprimerCompétences.php?id=<?= $row['id_competences'] ?>')"><img src="images/trash.png"></a></td>

                </tr>

                <?php
            }
        }
        ?>
    </table>
</div>

<footer class="footer">
    <div class="footer-content">
        <p>&copy; 2024 CIMS. Tous droits réservés.</p>
        <p>Contact : support@cims.com | Tél : +123 456 789</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
