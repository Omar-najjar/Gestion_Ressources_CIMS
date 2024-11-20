<?php
include_once 'connexion.php'; // Fichier de connexion à la base de données

session_start(); // Pour démarrer la session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Préparer la requête de sélection
    $query = "SELECT * FROM users WHERE email = $1";
    $result = pg_query_params($con, $query, array($email));

    if ($result && pg_num_rows($result) > 0) {
        $user = pg_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            // Authentification réussie
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role']; // Récupération du rôle de l'utilisateur
            // Redirection vers index.php après connexion réussie.
            header("Location: index.php");
            exit();
        } else {
            echo "Mot de passe incorrect.";
        }
    } else {
        echo "Aucun utilisateur trouvé avec cet email.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion CIMS</title>

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
            width: 270px;
            height: auto;
            transform: translateX(-1px); /* Déplace img2 légèrement vers la gauche */
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

    /* Formulaire */
.form-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: calc(100vh - 160px); /* Ajustement pour le header et le footer */
    padding-top: 80px;
}

form {
    background-color: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    width: 100%;
    max-width: 400px;
    text-align: center;
}

h3 {
    color: #007FA9;
    font-size: 1.8rem;
    margin-bottom: 20px;
    font-weight: bold;
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

input:focus {
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

/* Lien d'inscription */
.register-link {
    margin-top: 20px;
    font-size: 1rem;
}

.register-link a {
    color: #007FA9;
    text-decoration: none;
    font-weight: bold;
}

.register-link a:hover {
    text-decoration: underline;
    color: #004c6d;
}

    </style>
</head>
<body>

    <!-- En-tête -->
    <header class="headeer">
        <img class="img1" src="images/logo.png" alt="CIMS">
        <img class="img2" src="images/topleft1.png" alt="Ministère">
    </header>

    <!-- Contenu principal -->
    <div class="form-container">
        <form action="signin.php" method="POST">
            <h3>Connexion</h3>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
            <div class="register-link">
                <p>Pas de compte ? <a href="signup.php">Créez-en un ici</a></p>
            </div>
        </form>
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