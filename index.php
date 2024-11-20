<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil CIMS</title>

    <!-- Lien vers Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS personnalisé -->
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
            width: 240px;
            height: auto;
            transform: translateX(-1px); /* Déplace img1 vers la droite */
        }

        /* Sidebar */
        aside {
            background-color: #0E918C;
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 80px;
            padding: 20px;
            z-index: 999;
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

        /* Contenu principal */
        .cims-container {
            margin-left: 200px;
            padding: 275px 290px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
        }

        .cims-container h1 {
            font-weight: bold;
            color: #2b4a5e;
            font-size: 3rem;
        }

        .cims-container h3 {
            color: #4c5b67;
            font-size: 1.8rem;
            margin-top: 20px;
        }

        .cims-container p {
            font-size: 1.2rem;
            line-height: 1.8;
            text-align: justify;
            margin-top: 20px;
            color: #333;
        }

        /* Image */
        .img3 {
            width: 100%;
            max-width: 320px;
            height: 320px;
            margin-left: 150px;
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

        @media (max-width: 768px) {
            .cims-container {
                flex-direction: column;
                align-items: center;
            }

            .img3 {
                margin-left: 0;
                margin-top: 50px;
            }
        }
    </style>
</head>
<body>

    <!-- En-tête -->
    <header class="headeer">
        <img class="img1" src="images/logo.png" alt="CIMS">
        <img class="img2" src="images/topleft1.png" alt="Ministère">
    </header>

    <!-- Sidebar -->
    <aside>
        <nav>
            <a  href="gestionRessources.php">Gestion des ressources</a>
            <a href="gestionEtablissement.php">Gestion des établissements</a>
            <a href="gestionCompetences.php">Gestion des Compétences</a>
            <a href="gestionAffectation.php">Gestion des affectations</a>
            <a href="gestionRessourceCompétences.php">Gestion des Evaluations</a>
            <a href="generer_demande.php">Génerer une demande</a>
        </nav>
    </aside>

    <!-- Contenu principal -->
    <div class="cims-container">
        <div>
            <h1>LE CIMS</h1>
            <h3>Centre Informatique du Ministère de la Santé</h3>
            <p>
                Le Centre Informatique du Ministère de la Santé (CIMS), créé par la loi n°92-19 du 3 Février 1992 en tant qu’établissement public à caractère non administratif relevant du Ministère de la Santé. Il est acteur majeur dans le domaine e-santé en Tunisie. Ses missions principales englobent le développement jusqu’au déploiement du système d’information hospitalier et des services numériques ainsi que l’assistance et la formation continue. Il contribue à l’amélioration des conditions des prestations de soins tout en assurant l’accompagnement des structures sanitaires publiques dans leurs transformations numériques conformément aux règles de sécurité en vigueur.
            </p>
        </div>
        <img class="img3" src="images/log1.jpeg" alt="CIMS">
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2024 CIMS. Tous droits réservés.</p>
            <p>Contact : support@cims.com | Tél : +123 456 789</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
