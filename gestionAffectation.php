<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Affectations</title>
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
        
      
        .Btn_addAffectation {
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
            left: 260px;
        }
        .Btn_addAffectation img {
            margin-right: 5px;
            height: 20px;
        }
        .checked {
            background-color: #d4edda; /* Vert clair */
            text-align: center;
            color: green;
        }
        .unchecked {
            background-color: #f8d7da; /* Rouge clair */
            text-align: center;
            color: red;
        }
        .tableAffectation {
            width: 5%;
            border-collapse: collapse;
            margin-bottom: 20px;
            overflow-x: auto;
        }
        .tableAffectation th, .tableAffectation td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .tableAffectation th {
            background-color: #f4f4f4;
        }
        .tableAffectation tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .tableAffectation tr:hover {
            background-color: #f1f1f1;
        }
        .tableAffectation td img {
            width: 20px;
            height: 20px;
        }
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
           
            
            
            overflow-x: auto;
        }
        .container::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        .container::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 10px;
        }
        .container::-webkit-scrollbar-track {
            background-color: #f4f4f4;
        }
        .Btn_adAffectation {
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
            left: 1172px;
        }
        .Btn_adAffectation img {
            margin-right: 5px;
            height: 20px;
        }
        .searchInputAffectation-container {
            text-align: center;
            margin-bottom: 15px;
        }
        #searchInputAffectation {
            width: 20%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            position: absolute;
            top: 105px;
            left: 590px;
        }
        #searchInputAffectation:focus {
            outline: none;
            border-color: #2a85d0; /* Couleur de bordure au focus */
        }
        .iconchercherAffectation {
            position: absolute;
            top: 115px;
            left: 825px;
        }
    </style>
</head>
<body>
<header class="headeer">
<img class="img1" src="images/logo.png" alt="CIMS">
<h1>Gestion des Affectations</h1>
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
include_once "connexion.php";

// Affichage des erreurs PHP pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



// Vérifier la connexion à la base de données
if (!$con) {
    die("Échec de la connexion à la base de données: " . pg_last_error());
}

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_res = $_POST['ressource_id'] ?? null;
    $id_etab = $_POST['etablissement_id'] ?? null;
    $date_debut = $_POST['date_debut'] ?? null;
    $date_fin = $_POST['date_fin'] ?? null;

    // Afficher les paramètres reçus pour vérification
    var_dump($id_res, $id_etab, $date_debut, $date_fin);

    // Calcul du nombre de jours affectés
    $jours_affectes = 0;
    $jours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
    $daysChecked = [];

    foreach ($jours as $jour) {
        if (isset($_POST[$jour])) {
            $jours_affectes++;
            $daysChecked[] = $jour;
        }
    }

    if (!empty($daysChecked)) {
        // Vérification de l'existence d'affectations pour les jours choisis
        $queryCheck = "SELECT COUNT(*) FROM affectation 
                       WHERE id_res = $1 
                       AND (date_debut <= $2 AND date_fin >= $3) 
                       AND (";

        // Ajoute les conditions pour les jours en utilisant TRUE
        $conditions = [];
        foreach ($daysChecked as $day) {
            $conditions[] = "$day = TRUE";
        }
        $queryCheck .= implode(" OR ", $conditions) . ")";

        $resultCheck = pg_query_params($con, $queryCheck, [
            $id_res,
            $date_fin,
            $date_debut
        ]);

        if (!$resultCheck) {
            echo "<p>Erreur SQL durant la vérification : " . pg_last_error($con) . "</p>";
        } else {
            $rowCount = pg_fetch_result($resultCheck, 0, 0);
            if ($rowCount > 0) {
                echo "<p>Cette ressource est déjà affectée pour les jours choisis à un autre établissement pendant cette période.</p>";
            } else {
// Insérer l'affectation dans la base de données
$query = "INSERT INTO affectation (id_res, id_etab, lundi, mardi, mercredi, jeudi, vendredi, samedi, charge, date_debut, date_fin) 
          VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11)";

$result = pg_query_params($con, $query, [
    $id_res,
    $id_etab,
    isset($_POST['lundi']) && $_POST['lundi'] === 'on' ? 'TRUE' : 'FALSE',
    isset($_POST['mardi']) && $_POST['mardi'] === 'on' ? 'TRUE' : 'FALSE',
    isset($_POST['mercredi']) && $_POST['mercredi'] === 'on' ? 'TRUE' : 'FALSE',
    isset($_POST['jeudi']) && $_POST['jeudi'] === 'on' ? 'TRUE' : 'FALSE',
    isset($_POST['vendredi']) && $_POST['vendredi'] === 'on' ? 'TRUE' : 'FALSE',
    isset($_POST['samedi']) && $_POST['samedi'] === 'on' ? 'TRUE' : 'FALSE',
    $jours_affectes,
    $date_debut,
    $date_fin
]);

if ($result) {
    echo "<p>Affectation ajoutée avec succès.</p>";
} else {
    echo "<p>Erreur lors de l'affectation : " . pg_last_error($con) . "</p>";
}
            }
        }
    } else {
        echo "<p>Aucun jour d'affectation sélectionné.</p>";
    }
}

// Récupération des ressources et établissements pour le formulaire
$ressources = pg_query($con, "SELECT id_res, nom_res, prenom_res FROM ressource");
$etablissements = pg_query($con, "SELECT id_etab, nom_etab FROM etablissement");

// Vérifier les résultats des requêtes
if (!$ressources) {
    echo "<p>Erreur lors de la récupération des ressources : " . pg_last_error($con) . "</p>";
}

if (!$etablissements) {
    echo "<p>Erreur lors de la récupération des établissements : " . pg_last_error($con) . "</p>";
}
?>

<div class="container">
    <a href="" class="Btn_addAffectation" id="add"><img src="images/plus.png"> Ajouter</a>
    <a href="index.php" class="Btn_adAffectation"><img src="images/quitter.png"> Retour</a>

    <div class="popup" id="popupForm">
        <form method="POST" action="">
            <h2>Ajouter une affectation</h2>
            <label for="ressource_id">Ressource :</label>
            <select name="ressource_id" id="ressource_id" required>
                <?php while ($ressource = pg_fetch_assoc($ressources)) : ?>
                    <option value="<?= $ressource['id_res'] ?>"><?= $ressource['prenom_res'] . ' ' . $ressource['nom_res'] ?></option>
                <?php endwhile; ?>
            </select>

            <label for="etablissement_id">Établissement :</label>
            <select name="etablissement_id" id="etablissement_id" required>
                <?php while ($etablissement = pg_fetch_assoc($etablissements)) : ?>
                    <option value="<?= $etablissement['id_etab'] ?>"><?= $etablissement['nom_etab'] ?></option>
                <?php endwhile; ?>
            </select>

            <label for="date_debut">Date de début :</label>
            <input type="date" id="date_debut" name="date_debut" required>

            <label for="date_fin">Date de fin :</label>
            <input type="date" id="date_fin" name="date_fin" required>

            <div>
                <label>Jours d'affectation :</label><br>
                <label><input type="checkbox" name="lundi"> Lundi</label><br>
                <label><input type="checkbox" name="mardi"> Mardi</label><br>
                <label><input type="checkbox" name="mercredi"> Mercredi</label><br>
                <label><input type="checkbox" name="jeudi"> Jeudi</label><br>
                <label><input type="checkbox" name="vendredi"> Vendredi</label><br>
                <label><input type="checkbox" name="samedi"> Samedi</label><br>
            </div>

            <button type="submit">Affecter</button>
            <button type="submit"  href="gestionAffectation.php">Annuler</button>
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
            if (confirm("Êtes-vous sûr de vouloir supprimer cette affectation ?")) {
                window.location.href = url;
            }
        }
    </script>

    <!-- Formulaire de recherche -->
    <form method="GET" action="gestionAffectation.php">
        <input type="text" name="search" id="searchInputAffectation" placeholder="Rechercher...">
        <button type="submit" id="searchIcon"><img src="images/cherche.png" class="iconchercherAffectation"></button>
    </form>

    <table class="tableAffectation">
        <tr id="items">
            <th>ID</th>
            <th>Nom Ressource</th>
            <th>Nom Établissement</th>
            <th>Date Début</th>
            <th>Date Fin</th>
            <th>Lundi</th>
            <th>Mardi</th>
            <th>Mercredi</th>
            <th>Jeudi</th>
            <th>Vendredi</th>
            <th>Samedi</th>
            <th>Charge</th>
            <th>Modifier</th>
            <th>Supprimer</th>
            <th>imprimer</th>
        </tr>
        <?php
        // Construire la requête SQL avec filtrage
        $search = isset($_GET['search']) ? pg_escape_string($_GET['search']) : '';
        $query = "SELECT a.*, r.prenom_res, r.nom_res, e.nom_etab
                  FROM affectation a
                  JOIN ressource r ON a.id_res = r.id_res
                  JOIN etablissement e ON a.id_etab = e.id_etab
                  WHERE r.nom_res ILIKE '%$search%' OR e.nom_etab ILIKE '%$search%'";

        $req = pg_query($con, $query);

        if (!$req) {
            echo "<tr><td colspan='13'>Erreur lors de la récupération des données : " . pg_last_error($con) . "</td></tr>";
        } else {
            if (pg_num_rows($req) == 0) {
                echo "<tr><td colspan='13'>Il n'y a pas encore d'affectations ajoutées !</td></tr>";
            } else {
                while ($row = pg_fetch_assoc($req)) {
                    ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['prenom_res'] . ' ' . $row['nom_res'] ?></td>
                        <td><?= $row['nom_etab'] ?></td>
                        <td><?= $row['date_debut'] ?></td>
                        <td><?= $row['date_fin'] ?></td>
                        <td class="<?= $row['lundi'] == 't' ? 'checked' : 'unchecked' ?>">
                            <?= $row['lundi'] == 't' ? 'Affecté' : 'Non affecté' ?>
                        </td>
                        <td class="<?= $row['mardi'] == 't' ? 'checked' : 'unchecked' ?>">
                            <?= $row['mardi'] == 't' ? 'Affecté' : 'Non affecté' ?>
                        </td>
                        <td class="<?= $row['mercredi'] == 't' ? 'checked' : 'unchecked' ?>">
                            <?= $row['mercredi'] == 't' ? 'Affecté' : 'Non affecté' ?>
                        </td>
                        <td class="<?= $row['jeudi'] == 't' ? 'checked' : 'unchecked' ?>">
                            <?= $row['jeudi'] == 't' ? 'Affecté' : 'Non affecté' ?>
                        </td>
                        <td class="<?= $row['vendredi'] == 't' ? 'checked' : 'unchecked' ?>">
                            <?= $row['vendredi'] == 't' ? 'Affecté' : 'Non affecté' ?>
                        </td>
                        <td class="<?= $row['samedi'] == 't' ? 'checked' : 'unchecked' ?>">
                            <?= $row['samedi'] == 't' ? 'Affecté' : 'Non affecté' ?>
                        </td>
                        <td><?= $row['charge'] ?></td>
                        <td><a href="modifierAffectation.php?id=<?= $row['id'] ?>"><img src="images/pen.png"></a></td>
                        <td><a href="#" onclick="confirmerSuppression('supprimerAffectation.php?id=<?= $row['id'] ?>')"><img src="images/trash.png"></a></td>
                        <td></td>
                    </tr>
                    <?php
                }
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