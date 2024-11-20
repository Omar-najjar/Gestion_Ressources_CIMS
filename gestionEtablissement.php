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
<h1>Gestion des établissements</h1>
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
if (isset($_POST['buttone'])) {
    $nom_etab = $_POST['nom'];
    $nomarabe_etab = $_POST['nomArabe'];
    $titre_etab = $_POST['titre'];
    $type_etab = $_POST['type'];
    $gouvernorat_etab = $_POST['gouvernorat'];

    if (!empty($nom_etab) && !empty($nomarabe_etab)&& !empty($titre_etab) && !empty($type_etab) && !empty($gouvernorat_etab)) {
        include_once "connexion.php";
        $req = pg_query($con, "INSERT INTO etablissement(nom_etab, nomarabe_etab, titre_etab, type_etab, gouvernorat_etab) VALUES('$nom_etab', '$nomarabe_etab', '$titre_etab','$type_etab','$gouvernorat_etab')");
        if ($req) {
            header("location: gestionEtablissement.php");
        } else {
            $message = "Établissement non ajouté";
        }
    } else {
        $message = "Veuillez remplir tous les champs !";
    }
}
?>

<div class="container">
    <a href="" class="Btn_addEtab" id="add"><img src="images/plus.png"> Ajouter</a>
    <a href="index.php" class="Btn_adEtab"><img src="images/quitter.png"> Retour</a>
    <div class="popup" id="popupForm">
        <form action="" method="POST">
            <h2>Ajouter un établissement</h2>
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom">
            <label for="nomArabe">Nom Arabe:</label>
            <input type="text" id="nomArabe" name="nomArabe">
            <label for="titre">Titre:</label>
            <select id="titre" name="titre">
                <option> إلى السيد مدير </option>
                <option> إلى السيد مديرة  </option>
            </select>
            <label for="type">Type:</label>
            <input type="text" id="type" name="type">
            <label for="gouvernorat">Gouvernorat:</label>
            <select id="gouvernorat" name="gouvernorat">
            <option>Ariana</option>
                    <option>Béja</option>
                    <option>Ben Arous</option>
                    <option>Bizerte</option>
                    <option>Gabès</option>
                    <option>Gafsa</option>
                    <option>Jendouba</option>
                    <option>Kairouan</option>
                    <option>Kasserine</option>
                    <option>Kébili</option>
                    <option>Kef</option>
                    <option>Mahdia</option>
                    <option>Manouba</option>
                    <option>Médenine</option>
                    <option>Monastir</option>
                    <option>Nabeul</option>
                    <option>Sfax</option>
                    <option>Sidi Bouzid</option>
                    <option>Siliana</option>
                    <option>Sousse</option>
                    <option>Tataouine</option>
                    <option>Tozeur</option>
                    <option>Tunis</option>
                    <option>Zaghouan</option>
            </select>
            <button id="submitBtn" name="buttone">Soumettre</button>
            <button href="gestionEtablissement.php" id="btnAnnuler" class="btnAnnulerEtab">Annuler</button>
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
            if (confirm("Êtes-vous sûr de vouloir supprimer cette établissement ?")) {
                window.location.href = url;
            }
        }
    </script>

    <!-- Formulaire de recherche -->
    <form method="GET" action="gestionEtablissement.php">
        <input type="text" name="search" id="searchInputEtab" placeholder="Rechercher...">
        <button type="submit" id="searchIcon"><img src="images/cherche.png" class="iconchercherEtab"></button>
    </form>

    <table class="tableEtab">
        <tr id="items">
            <th>ID</th>
            <th>Nom</th>
            <th>Nom_Arabe</th>
            <th>Titre</th>
            <th>Type</th>
            <th>Gouvernorat</th>
            <th>Modifier</th>
            <th>Supprimer</th>
        </tr>
        <?php
        include_once "connexion.php";

        // Récupérer le terme de recherche, s'il existe
        $search = isset($_GET['search']) ? pg_escape_string($_GET['search']) : '';

        // Construire la requête SQL avec filtrage
        $query = "SELECT * FROM etablissement WHERE 
            nom_etab ILIKE '%$search%' OR
            nomarabe_etab ILIKE '%$search%' OR
            titre_etab ILIKE '%$search%' OR
            type_etab ILIKE '%$search%' OR
            gouvernorat_etab ILIKE '%$search%'";

        // Exécuter la requête
        $req = pg_query($con, $query);

        // Vérifier si la requête a réussi
        if (!$req) {
            echo "Il n'y a pas encore d'établissements ajoutés !";
        } else {
            // Afficher les résultats
            while ($row = pg_fetch_assoc($req)) {
                ?>
                <tr>
                    <td><?=$row['id_etab']?></td>
                    <td><?=$row['nom_etab']?></td>
                    <td><?=$row['nomarabe_etab']?></td>
                    <td><?=$row['titre_etab']?></td>
                    <td><?=$row['type_etab']?></td>
                    <td><?=$row['gouvernorat_etab']?></td>
                    <td><a href="modifierEtablissemnt.php?id=<?=$row['id_etab']?>"><img src="images/pen.png"></a></td>
                    <td><a href="#" onclick="confirmerSuppression('supprimerEtablissement.php?id=<?= $row['id_etab'] ?>')"><img src="images/trash.png"></a></td>

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
