<?php
include_once "connexion.php";

// Vérifier que le bouton "Soumettre" a bien été cliqué
if (isset($_POST['buttoneComp'])) {
    $id_res = $_POST['id_res'];
    $id_competences = $_POST['id_competences'];
    $evaluation = $_POST['evaluation'];

    // Vérifier que tous les champs sont remplis
    if (!empty($id_res) && !empty($id_competences) && !empty($evaluation)) {
        // Insérer la nouvelle compétence dans la table ressource_competences
        $req = pg_query($con, "INSERT INTO ressource_competences (id_res, id_competences, evaluation, date_modification) 
                               VALUES ('$id_res', '$id_competences', '$evaluation', NOW())");

        if ($req) {
            header("Location: gestionRessourceCompétences.php"); // Rediriger vers la page de gestion des compétences
        } else {
            echo "Erreur lors de l'ajout de la compétence.";
        }
    } else {
        echo "Veuillez remplir tous les champs !";
    }
}
?>
