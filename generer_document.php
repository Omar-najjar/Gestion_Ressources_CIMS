<?php
// Inclure la connexion à la base de données
include_once 'connexion.php';

function nombreVersTexte($nombre) {
    $nombresArabes = [
        0 => "صفر",
        1 => "واحد",
        2 => "اثنان",
        3 => "ثلاثة",
        4 => "أربعة",
        5 => "خمسة",
        6 => "ستة",
        7 => "سبعة",
        8 => "ثمانية",
        9 => "تسعة",
        10 => "عشرة",
    ];

    return isset($nombresArabes[$nombre]) ? $nombresArabes[$nombre] : $nombre; // Retourne le nombre tel quel si non trouvé
}

// Vérifier la connexion
if (!$con) {
    die("Erreur de connexion : " . pg_last_error());
}

// Récupérer les données depuis le formulaire
$id_res = filter_input(INPUT_POST, 'ressource', FILTER_SANITIZE_STRING);
$id_etab = filter_input(INPUT_POST, 'etablissement', FILTER_SANITIZE_STRING);

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

// Afficher les résultats pour débogage
$res = pg_fetch_assoc($result_res);
$etab = pg_fetch_assoc($result_etab);
echo '<pre>';
print_r($res);
print_r($etab);
echo '</pre>';

if ($res === false) {
    die("Erreur lors de la récupération des données de la ressource : " . pg_last_error($con));
}

if ($etab === false) {
    die("Erreur lors de la récupération des données de l'établissement : " . pg_last_error($con));
}

// Vérifiez l'existence des données d'affectation
$check_affect = pg_query_params($con, "SELECT COUNT(*) FROM affectation WHERE id_res = $1 AND id_etab = $2", array($id_res, $id_etab));
$affect_count = pg_fetch_result($check_affect, 0, 0);

if ($affect_count == 0) {
    die("Aucune donnée d'affectation trouvée pour les identifiants fournis.");
}

// Préparer et exécuter la requête pour récupérer les données d'affectation
$query_affect = pg_prepare($con, "get_assignment", "SELECT date_debut, charge, lundi, mardi, mercredi, jeudi, vendredi, samedi FROM affectation WHERE id_res = $1 AND id_etab = $2");
if (!$query_affect) {
    die("Erreur lors de la préparation de la requête d'affectation : " . pg_last_error($con));
}

$result_affect = pg_execute($con, "get_assignment", array($id_res, $id_etab));
if ($result_affect === false) {
    die("Erreur lors de l'exécution de la requête d'affectation : " . pg_last_error($con));
}

// Afficher les résultats pour débogage
$affect = pg_fetch_assoc($result_affect);
echo '<pre>';
print_r($affect);
echo '</pre>';

if ($affect === false) {
    die("Erreur lors de la récupération des données d'affectation : " . pg_last_error($con));
}

$jours = [];
if ($affect['lundi'] === 't') $jours[] = 'الاثنين';     // Vérifiez si la colonne est 't' pour true
if ($affect['mardi'] === 't') $jours[] = 'الثلاثاء';
if ($affect['mercredi'] === 't') $jours[] = 'الأربعاء';
if ($affect['jeudi'] === 't') $jours[] = 'الخميس';
if ($affect['vendredi'] === 't') $jours[] = 'الجمعة';
if ($affect['samedi'] === 't') $jours[] = 'السبت';

// Construire la chaîne des jours affectés
$jours_affectes_arabe = implode('، ', $jours);
$nombre_jours = count($jours); // Compter le nombre de jours affichés
$nombre_jours_arabe = nombreVersTexte($nombre_jours); 
// Créer le contenu du fichier texte
$content = "تونس في، " . date('d/m/Y') . "\n";
$content .= "الي السيد مدير\n";
$content .= "مستوصف\n";
$content .= "ص-2024-20-35103000-0000122\n";
$content .= "الموضوع : تكليف بمهمة.\n";
$content .= "المرجع : الطلب عدد 144 " . date('d/m/Y') . "\n\n";

$content .= "يشرفني إعلامكم بأن مركز الإعلامية لوزارة الصحة قد كلف  " . htmlspecialchars($res['titre_res'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($res['nomarabe_res'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($res['prenomarabe_res'], ENT_QUOTES, 'UTF-8') . " لمساندة مستعملي  " . htmlspecialchars($etab['nomarabe_etab'], ENT_QUOTES, 'UTF-8') . "\n";
$content .= "ابتداء من يوم " . htmlspecialchars($affect['date_debut'], ENT_QUOTES, 'UTF-8') . "\n";
$content .= " وذلك "    . $nombre_jours_arabe . " أيام في الأسبوع
  (" . htmlspecialchars($jours_affectes_arabe, ENT_QUOTES, 'UTF-8') . ")\n\n";

$content .= "تقبلوا سيدي، فائق عبارات الشكر والتقدير.\n\n";
$content .= "والســــــــلام\n";
$content .= "المـــــــــدير العــــــام\n";
$content .= "لطـــــفي العـــــلاني\n";

/*
$charge = htmlspecialchars($affect['charge'], ENT_QUOTES, 'UTF-8');

// Liste des jours d'affectation
$jours = [];
if ($affect['lundi']) $jours[] = 'الاثنين';
if ($affect['mardi']) $jours[] = 'الثلاثاء';
if ($affect['mercredi']) $jours[] = 'الأربعاء';
if ($affect['jeudi']) $jours[] = 'الخميس';
if ($affect['vendredi']) $jours[] = 'الجمعة';
if ($affect['samedi']) $jours[] = 'السبت';

//$jours_affectes = implode('، ', $jours);

$jours_affectes_arabe = implode('، ', $jours);
//$nombre_jours_arabe = count($jours); // Vous pouvez adapter la logique pour obtenir le nombre en arabe
$nombre_jours_arabe = htmlspecialchars($charge, ENT_QUOTES, 'UTF-8');

// Créer le contenu du fichier texte
$content = "تونس في، " . date('d/m/Y') . "\n";
$content .= "الي السيد مدير\n";
$content .= "مستوصف\n";
$content .= "ص-2024-20-35103000-0000122\n";
$content .= "الموضوع : تكليف بمهمة.\n";
$content .= "المرجع : الطلب عدد 144 " . date('d/m/Y') . "\n\n";

$content .= "يشرفني إعلامكم بأن مركز الإعلامية لوزارة الصحة قد كلف  " . htmlspecialchars($res['titre_res'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($res['nomarabe_res'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($res['prenomarabe_res'], ENT_QUOTES, 'UTF-8') . " لمساندة مستعملي  " . htmlspecialchars($etab['nomarabe_etab'], ENT_QUOTES, 'UTF-8') . "\n";
$content .= "ابتداء من يوم " . htmlspecialchars($affect['date_debut'], ENT_QUOTES, 'UTF-8') . "\n";
$content .= "وذلك " . $nombre_jours_arabe . " في الأسبوع (" . htmlspecialchars($jours_affectes_arabe, ENT_QUOTES, 'UTF-8') . ")\n\n";

$content .= "تقبلوا سيدي، فائق عبارات الشكر والتقدير.\n\n";
$content .= "والســــــــلام\n";
$content .= "المـــــــــدير العــــــام\n";
$content .= "لطـــــفي العـــــلاني\n";

// Afficher ou sauvegarder le contenu dans un fichier
echo nl2br($content);

*/





/*


// Liste des jours d'affectation
$jours = [];
if ($affect['lundi']) $jours[] = 'الاثنين';
if ($affect['mardi']) $jours[] = 'الثلاثاء';
if ($affect['mercredi']) $jours[] = 'الأربعاء';
if ($affect['jeudi']) $jours[] = 'الخميس';
if ($affect['vendredi']) $jours[] = 'الجمعة';
if ($affect['samedi']) $jours[] = 'السبت';

$jours_affectes = implode('، ', $jours);




// Créer le contenu du fichier texte
$content = "تونس في، " . date('d/m/Y') . "\n";
$content .= htmlspecialchars($etab['titre_etab'], ENT_QUOTES, 'UTF-8') . "\n";
$content .= htmlspecialchars($etab['nomarabe_etab'], ENT_QUOTES, 'UTF-8') . "\n";
$content .= "ص-2024-20-35103000-0000122\n";
$content .= "الموضوع : تكليف بمهمة.\n";
$content .= "المرجع : الطلب عدد 144 " . date('d/m/Y') . "\n\n";

$content .= "يشرفني إعلامكم بأن مركز الإعلامية لوزارة الصحة قد كلف  " . htmlspecialchars($res['titre_res'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($res['nomarabe_res'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($res['prenomarabe_res'], ENT_QUOTES, 'UTF-8') . " لمساندة مستعملي   " . htmlspecialchars($etab['nomarabe_etab'], ENT_QUOTES, 'UTF-8') . "\n";
$content .= "ابتداء من يوم " . htmlspecialchars($affect['date_debut'], ENT_QUOTES, 'UTF-8') . "\n";
$content .= "وذلك ثلاثة أيام في الأسبوع (" . htmlspecialchars($jours_affectes, ENT_QUOTES, 'UTF-8') . ")\n\n";

$content .= "تقبلوا سيدي، فائق عبارات الشكر والتقدير.\n\n";
$content .= "والســــــــلام\n";
$content .= "المـــــــــدير العــــــام\n";
$content .= "لطـــــفي العـــــلاني\n";

*/
/*
// Définir le nom du fichier et le chemin
$filename = 'demande.txt';

// Créer et écrire le fichier avec encodage UTF-8
if (file_put_contents($filename, $content, FILE_TEXT | LOCK_EX) === false) {
    die("Erreur lors de la création du fichier.");
}

echo "Fichier texte généré avec succès : <a href=\"$filename\">Télécharger le fichier</a>";  
*/



// Rediriger vers la page document.php en passant les paramètres
header("Location: fichier.php?ressource=$id_res&etablissement=$id_etab");
exit();



?>




