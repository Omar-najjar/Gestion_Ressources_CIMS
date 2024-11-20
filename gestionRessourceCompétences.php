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

        #bouton {
    width: fit-content;
    margin-bottom: 20px;
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
    right: 650px;
}

        </style>
</head>
<body>
<header class="headeer">
<img class="img1" src="images/logo.png" alt="CIMS">
    <h1>Gestion des Evaluations</h1>
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
    <!-- Boutons d'ajout et de retour -->
    <a href="" class="Btn_addComp" id="addComp"><img src="images/plus.png"> Ajouter</a>
    <a href="index.php" id="bouton"><img src="images/quitter.png"> Retour</a>

    <!-- Popup pour ajouter une compétence -->
    <div class="popup" id="popupFormComp">
        <form action="ajouterRessourceCompetence.php" method="POST">
            <h2>Ajouter une compétence</h2>
            <label for="id_res">Ressource:</label>
            <select id="id_res" name="id_res">
                <?php
                include_once "connexion.php";
                $reqRes = pg_query($con, "SELECT id_res, nom_res, prenom_res FROM ressource");
                while ($rowRes = pg_fetch_assoc($reqRes)) {
                    echo "<option value='" . $rowRes['id_res'] . "'>" . $rowRes['nom_res'] . " " . $rowRes['prenom_res'] . "</option>";
                }
                ?>
            </select>

            <label for="id_competences">Compétence:</label>
            <select id="id_competences" name="id_competences">
                <?php
                $reqComp = pg_query($con, "SELECT id_competences, nom_competence FROM competences");
                while ($rowComp = pg_fetch_assoc($reqComp)) {
                    echo "<option value='" . $rowComp['id_competences'] . "'>" . $rowComp['nom_competence'] . "</option>";
                }
                ?>
            </select>

            <label for="evaluation">Évaluation:</label>
            <input type="text" id="evaluation" name="evaluation">
            <button id="submitBtnComp" name="buttoneComp">Soumettre</button>
            <button  id="btnAnnulerComp" class="btnAnnulerComp"></a>Annuler</button>
        </form>
    </div>
    <div class="overlay" id="overlayComp"></div>

    <!-- Formulaire de recherche -->
    <form method="GET" action="gestionRessourceCompétences.php">
        <input type="text" name="search" id="searchInputComp" placeholder="Rechercher...">
        <button type="submit" id="searchIcon"><img src="images/cherche.png" class="iconchercherComp"></button>
    </form>

    <table class="tableComp">
        <tr id="items">
        <th>ID</th>
            <th>Nom Ressource</th>
            <th>Prénom Ressource</th>
            <th>Compétence</th>
            <th>Évaluation</th>
            <th>Date de Modification</th>
            <th>Modifier</th>
            <th>Supprimer</th>
        </tr>
        <?php
        include_once "connexion.php";

        $search = isset($_GET['search']) ? pg_escape_string($_GET['search']) : '';

  
   $query = "SELECT rc.id_ressource_competences, ressource.nom_res, ressource.prenom_res, 
                     competences.nom_competence, rc.evaluation, rc.date_modification 
              FROM ressource_competences rc
              JOIN ressource ON rc.id_res = ressource.id_res
              JOIN competences ON rc.id_competences = competences.id_competences
              WHERE ressource.nom_res ILIKE '%$search%' OR
                    ressource.prenom_res ILIKE '%$search%' OR
                    competences.nom_competence ILIKE '%$search%' OR
                    rc.evaluation::text ILIKE '%$search%'";
          
           

        // Exécuter la requête
        $req = pg_query($con, $query);

        // Vérifier si la requête a réussi
        if (!$req) {
            echo "Il n'y a pas encore d'association ajoutés !";
        } else {
            // Afficher les résultats
            while ($row = pg_fetch_assoc($req)) {
                ?>
                <tr>
                <td><?=$row['id_ressource_competences']?></td>
                <td><?=$row['nom_res']?></td>
                <td><?=$row['prenom_res']?></td>
                <td><?=$row['nom_competence']?></td>
                <td><?=$row['evaluation']?></td>
                <td><?=$row['date_modification']?></td>
                <td><a href="modifierRessourceCompetence.php?id=<?=$row['id_ressource_competences']?>"><img src="images/pen.png"></a></td>
                <td><a href="#" onclick="confirmerSuppression('supprimerRessourceCompetence.php?id=<?= $row['id_ressource_competences'] ?>')"><img src="images/trash.png"></a></td>
    
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

<script>
    // Script pour afficher la popup
    document.getElementById('addComp').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('popupFormComp').style.display = 'block';
        document.getElementById('overlayComp').style.display = 'block';
    });

    // Script pour masquer la popup
    document.getElementById('overlayComp').addEventListener('click', function() {
        document.getElementById('popupFormComp').style.display = 'none';
        document.getElementById('overlayComp').style.display = 'none';
    });

    function confirmerSuppression(url) {
            if (confirm("Êtes-vous sûr de vouloir supprimer cette évaluation ?")) {
                window.location.href = url;
            }
        }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

