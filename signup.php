<?php
include_once 'connexion.php'; // Assurez-vous que ce fichier contient la connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['first_name']; // Récupérer le prénom
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];

    // Vérifier si les mots de passe correspondent
    if ($password !== $confirmPassword) {
        echo "<script>alert('Les mots de passe ne correspondent pas.');</script>";
    } else {
        // Vérifier si le prénom, le nom d'utilisateur ou l'email existent déjà
        $checkQuery = "SELECT * FROM users WHERE username = $1 OR email = $2 OR first_name = $3";
        $checkResult = pg_query_params($con, $checkQuery, array($username, $email, $firstName));

        if (pg_num_rows($checkResult) > 0) {
            echo "<script>alert('Le prénom, le nom d utilisateur ou l email existe déjà.');</script>";
        } else {
            // Hachage du mot de passe
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            
            // Préparer la requête d'insertion
            $query = "INSERT INTO users (first_name, username, email, password, phone, role) VALUES ($1, $2, $3, $4, $5, $6)";
            $result = pg_query_params($con, $query, array($firstName, $username, $email, $hashedPassword, $phone, $role));

            if ($result) {
                echo "<script>alert('Compte créé avec succès !'); window.location.href='signin.php';</script>";
                exit();
            } else {
                echo "Erreur : " . pg_last_error($con);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription CIMS</title>

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
            transform: translateX(-1px); /* Déplace img1 vers la droite */
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
    width: 100%;
    padding-top: 160px; /* Pour s'assurer que le formulaire ne chevauche pas l'en-tête */
}

form {
    background-color: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    width: 100%;
    max-width: 400px; /* Largeur fixe pour le formulaire */
    text-align: center;
}

h3 {
    color: #007FA9;
    font-size: 1.8rem;
    margin-bottom: 20px;
    font-weight: bold;
}

input, select {
    margin: 15px 0;
    padding: 12px;
    width: 100%;
    border: 2px solid #007FA9;
    border-radius: 50px;
    font-size: 1rem;
    transition: border 0.3s ease-in-out;
}

input:focus, select:focus {
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

/* Lien pour se connecter */
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
        <form action="signup.php" method="POST">
            <h3>Inscription</h3>
            <input type="text" name="username" placeholder="Nom d'utilisateur" required>
            <input type="text" name="first_name" placeholder="Prénom" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <input type="password" name="confirm_password" placeholder="Confirmer le mot de passe" required>
            <input type="tel" name="phone" placeholder="Numéro de téléphone" required pattern="[0-9]{8}" title="Veuillez entrer un numéro de téléphone valide (8 chiffres)">
            <select name="role" required>
                <option value="" disabled selected>Sélectionnez un rôle</option>
                <option value="administrateur">Administrateur</option>
                <option value="utilisateur">Utilisateur</option>
            </select>
            <button type="submit">S'inscrire</button>
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