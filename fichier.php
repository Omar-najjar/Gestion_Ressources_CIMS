<?php
// Inclure la connexion à la base de données
include_once 'connexion.php';

// Vérifier si les paramètres requis sont passés
if (isset($_GET['ressource']) && isset($_GET['etablissement'])) {
    // Récupérer les données depuis les paramètres GET
    $id_res = filter_input(INPUT_GET, 'ressource');
    $id_etab = filter_input(INPUT_GET, 'etablissement');

    // Fonction pour convertir les nombres en texte en arabe
    function nombreVersTexte($nombre) {
        $nombresArabes = [
            0 => "صفر يوم",
            1 => "يوم واحد",
            2 => "يومان",
            3 => "ثلاثة أيام",
            4 => "أربعةأيام",
            5 => "خمسةأيام",
            6 => "ستةأيام",
            7 => "سبعة",
            8 => "ثمانية",
            9 => "تسعة",
            10 => "عشرة",
        ];
        return isset($nombresArabes[$nombre]) ? $nombresArabes[$nombre] : $nombre; // Retourne le nombre tel quel si non trouvé
    }

    // Préparer et exécuter les requêtes pour récupérer les informations de la ressource et de l'établissement
    $query_res = pg_prepare($con, "get_resource", "SELECT nomarabe_res, prenomarabe_res, titre_res FROM ressource WHERE id_res = $1");
    $result_res = pg_execute($con, "get_resource", array($id_res));

    if ($result_res === false) {
        die("Erreur lors de l'exécution de la requête pour la ressource : " . pg_last_error($con));
    }

    $query_etab = pg_prepare($con, "get_establishment", "SELECT nomarabe_etab, titre_etab FROM etablissement WHERE id_etab = $1");
    $result_etab = pg_execute($con, "get_establishment", array($id_etab));

    if ($result_etab === false) {
        die("Erreur lors de l'exécution de la requête pour l'établissement : " . pg_last_error($con));
    }

    // Récupérer les résultats
    $res = pg_fetch_assoc($result_res);
    $etab = pg_fetch_assoc($result_etab);

    if ($res === false || $etab === false) {
        die("Erreur lors de la récupération des données : " . pg_last_error($con));
    }

    // Vérifiez l'existence des données d'affectation
    $check_affect = pg_query_params($con, "SELECT COUNT(*) FROM affectation WHERE id_res = $1 AND id_etab = $2", array($id_res, $id_etab));
    $affect_count = pg_fetch_result($check_affect, 0, 0);

    if ($affect_count == 0) {
        die("Aucune donnée d'affectation trouvée pour les identifiants fournis.");
    }

    // Préparer et exécuter la requête pour récupérer les données d'affectation
    $query_affect = pg_prepare($con, "get_assignment", "SELECT date_debut, charge, lundi, mardi, mercredi, jeudi, vendredi, samedi FROM affectation WHERE id_res = $1 AND id_etab = $2");
    $result_affect = pg_execute($con, "get_assignment", array($id_res, $id_etab));

    if ($result_affect === false) {
        die("Erreur lors de l'exécution de la requête d'affectation : " . pg_last_error($con));
    }

    // Récupérer les données d'affectation
    $affect = pg_fetch_assoc($result_affect);
    if ($affect === false) {
        die("Erreur lors de la récupération des données d'affectation : " . pg_last_error($con));
    }

    // Liste des jours d'affectation
    $jours = [];
    if ($affect['lundi'] === 't') $jours[] = 'الاثنين';
    if ($affect['mardi'] === 't') $jours[] = 'الثلاثاء';
    if ($affect['mercredi'] === 't') $jours[] = 'الأربعاء';
    if ($affect['jeudi'] === 't') $jours[] = 'الخميس';
    if ($affect['vendredi'] === 't') $jours[] = 'الجمعة';
    if ($affect['samedi'] === 't') $jours[] = 'السبت';

    // Construire la chaîne des jours affectés
    $jours_affectes_arabe = implode('، ', $jours);
    $nombre_jours = count($jours); // Compter le nombre de jours affichés
    $nombre_jours_arabe = nombreVersTexte($nombre_jours); // Convertir le nombre en texte arabe

    // Créer le contenu du document
    $content = "
        <h4 style=' text-align: left;font-size: 20px;'>تونس في، " . date('d/m/Y') . "</h4>
        <h1 class='big-text'>". htmlspecialchars($etab['titre_etab'], ENT_QUOTES, 'UTF-8')." </h1>
        <h1 class='big-text'>".htmlspecialchars($etab['nomarabe_etab'], ENT_QUOTES, 'UTF-8') ."</h1>
        <br>
        <p class='normal-text'>ص-2024-20-35103000-0000122</p>
        <p class='normal-text'><strong>الموضوع:</strong> تكليف بمهمة</p>
<p class='normal-text' style='display: inline;'>.الطلب عدد 144 بتاريخ " . date('d/m/Y') . "</p>

        <p class='normal-text' style='display: inline;'><strong>  :المرجع    </strong></p>




        <br>


        <p class='normal-text' style='text-indent: 40px;direction: rtl;'>يشرفني إعلامكم بأن مركز الإعلامية لوزارة الصحة قد كلف       " . htmlspecialchars($res['titre_res'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($res['nomarabe_res'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($res['prenomarabe_res'], ENT_QUOTES, 'UTF-8') . " لمساندة مستعملي " . htmlspecialchars($etab['nomarabe_etab'], ENT_QUOTES, 'UTF-8') . " ابتداء من يوم " . htmlspecialchars($affect['date_debut'], ENT_QUOTES, 'UTF-8') . " وذلك " . $nombre_jours_arabe . " في الأسبوع (" . htmlspecialchars($jours_affectes_arabe, ENT_QUOTES, 'UTF-8') . ")</p>
        <br>
        <p class='normal-text' style='text-indent: 60px;direction: rtl;'>.تقبلوا سيدي، فائق عبارات الشكر والتقدير</p>


<br>



     <h3><strong>والســــــــلام</strong></h3>
<h3><strong>المـــــــــدير العــــــام</strong></h3>
<h3><strong>لطـــــفي العـــــلاني</strong></h3>


    ";
} else {
    // Rediriger si les paramètres ne sont pas trouvés
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Document Officiel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 60px;

            
        }

        h3{
            text-align: center;
        }
        
        .big-text {
            text-align: center;
    }
        .normal-text {
        font-size: 20px;
        
    }

        .note {


            
            border: 1px solid #000;
            padding: 20px;
            width: 620px;
            height: 750px;
            margin: 0 auto;
            text-align: right; /* Aligner le texte à droite pour l'arabe */
        }
        @media print {
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class='note'>
        <?php echo $content; ?>
    </div>
    <button class='print-button' onclick='window.print()'>Imprimer</button>
</body>
</html>