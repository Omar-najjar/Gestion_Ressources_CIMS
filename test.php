<?php
// Définir l'encodage de la connexion à UTF-8
include_once 'connexion.php';
pg_set_client_encoding($con, 'UTF8');

// Créer un contenu simple en arabe
$content = "مرحبا بكم في اختبار UTF-8\n";
$content .= "تونس في، " . date('d/m/Y') . "\n";

// Créer et écrire le fichier
$filename = 'test_utf8.txt';
if (file_put_contents($filename, $content, FILE_TEXT | LOCK_EX) === false) {
    die("Erreur lors de la création du fichier.");
}

echo "Fichier texte généré avec succès : <a href=\"$filename\">Télécharger le fichier</a>";
?>
