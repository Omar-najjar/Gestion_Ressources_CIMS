<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
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
<h1>Gestion des ressources Techniques</h1>
<img class="img2" src="images/topleft1.png" alt="Ministère">
    
</header>

<aside>
        <nav>
            <a style="padding-top: 30px;" href="gestionRessources.php">Gestion des ressources</a>
            <a href="gestionEtablissement.php">Gestion des établissements</a>
            <a href="gestionCompetences.php">Gestion des Compétences</a>
            <a href="gestionAffectation.php">Gestion des affectations</a>
            <a href="gestionRessourceCompétences.php">Gestion des Evaluations</a>
            <a href="generer_demande.php">Génerer une demande</a>
        </nav>
    </aside>

<?php
// Vérifier que le bouton ajouter a bien été cliqué
if (isset($_POST['buttonRess'])) {
    $nom_res = $_POST['nom'];
    $prenom_res = $_POST['prenom'];
    $nomarabe_res = $_POST['nomArabe'];
    $prenomarabe_res = $_POST['prenomArabe'];
    $num_telephone_res = $_POST['num_telephone'];
    $titre_res = $_POST['titre'];
    $fonction_res = $_POST['fonction'];

    if (!empty($nom_res) && !empty($prenom_res) && !empty($nomarabe_res) && !empty($prenomarabe_res) && !empty($num_telephone_res) && !empty($titre_res) && !empty($fonction_res)) {
        include_once "connexion.php";
        $req = pg_query($con, "INSERT INTO ressource(nom_res, prenom_res, nomarabe_res, prenomarabe_res, num_telephone_res, titre_res, fonction_res) VALUES('$nom_res', '$prenom_res', '$nomarabe_res', '$prenomarabe_res', '$num_telephone_res', '$titre_res', '$fonction_res')");
        if ($req) {
            header("location: gestionRessources.php");
        } else {
            $message = "Ressource non ajoutée";
        }
    } else {
        $message = "Veuillez remplir tous les champs !";
    }
}
?>

<div class="container">
    <a href="" class="Btn_add" id="add"><img src="images/plus.png"> Ajouter</a>
    <a href="index.php" class="Btn_ad"><img src="images/quitter.png"> Retour</a>
    <div class="popup" id="popupForm">
        <form action="" method="POST">
            <h2>Ajouter une ressource</h2>
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom">
            <label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom">
            <label for="nomArabe">Nom Arabe:</label>
            <input type="text" id="nomArabe" name="nomArabe">
            <label for="prenomArabe">Prénom Arabe:</label>
            <input type="text" id="prenomArabe" name="prenomArabe">
            <label for="num_telephone">Numéro de téléphone:</label>
            <input type="text" id="num_telephone" name="num_telephone"  placeholder="+21621123468">
            <label for="titre">Titre:</label>
            <select id="titre" name="titre">
                <option> السيد</option>
                <option> السيدة </option>
            </select>
            <label for="fonction">Fonction:</label>
            <select id="fonction" name="fonction">
                <option>Correspendant</option>
                <option>Technicien</option>
            </select>
            <button id="submitBtn" name="buttonRess">Soumettre</button>
            <button  href="gestionRessources.php" id="btnAnnuler" class="btnAnnuler">Annuler</button>
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
            if (confirm("Êtes-vous sûr de vouloir supprimer cette ressource ?")) {
                window.location.href = url;
            }
        }
    </script>

    <!-- Formulaire de recherche -->
    <form method="GET" action="gestionRessources.php">
        <input type="text" name="search" id="searchInput" placeholder="Rechercher...">
        <button type="submit" id="searchIcon"><img src="images/cherche.png" class="iconchercher"></button>
    </form>

    <table class="table">
        <tr id="items">
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Nom Arabe</th>
            <th>Prénom Arabe</th>
            <th>Numéro de téléphone</th>
            <th>Titre</th>
            <th>Fonction</th>
            <th>Modifier</th>
            <th>Supprimer</th>
        </tr>
        <?php
        include_once "connexion.php";

        // Récupérer le terme de recherche, s'il existe
        $search = isset($_GET['search']) ? pg_escape_string($_GET['search']) : '';

        // Construire la requête SQL avec filtrage
        $query = "SELECT * FROM ressource WHERE 
            nom_res ILIKE '%$search%' OR
            prenom_res ILIKE '%$search%' OR
            nomarabe_res ILIKE '%$search%' OR
            prenomarabe_res ILIKE '%$search%' OR
            num_telephone_res ILIKE '%$search%' OR
            titre_res ILIKE '%$search%' OR
            fonction_res ILIKE '%$search%'";

        // Exécuter la requête
        $req = pg_query($con, $query);

        // Vérifier si la requête a réussi
        if (!$req) {
            echo "Il n'y a pas encore de ressources ajoutées !";
        } else {
            // Afficher les résultats
            while ($row = pg_fetch_assoc($req)) {
                ?>
                <tr>
                    <td><?=$row['id_res']?></td>
                    <td><?=$row['nom_res']?></td>
                    <td><?=$row['prenom_res']?></td>
                    <td><?=$row['nomarabe_res']?></td>
                    <td><?=$row['prenomarabe_res']?></td>
                    <td><?=$row['num_telephone_res']?></td>
                    <td><?=$row['titre_res']?></td>
                    <td><?=$row['fonction_res']?></td>
                    <td><a href="modifierRessources.php?id=<?=$row['id_res']?>"><img src="images/pen.png"></a></td>
                    <td><a href="#" onclick="confirmerSuppression('supprimerRessources.php?id=<?= $row['id_res'] ?>')"><img src="images/trash.png"></a></td>
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
</body>
</html>
