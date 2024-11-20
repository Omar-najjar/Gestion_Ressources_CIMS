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

// Supprimer l'affectation de la base de données
$query = "DELETE FROM affectation WHERE id = $1";
$result = pg_query_params($con, $query, [$id]);

if ($result) {
    echo "<p>Affectation supprimée avec succès !</p>";
    // Rediriger vers la page de gestion des affectations
    header("Location: gestionAffectation.php");
    exit();
} else {
    echo "<p>Erreur lors de la suppression de l'affectation.</p>";
    echo "<p>" . pg_last_error($con) . "</p>"; // Affiche les erreurs SQL
}
?>
