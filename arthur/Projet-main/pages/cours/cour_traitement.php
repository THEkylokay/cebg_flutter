<?php

include '../../includes/haut.inc.php';

if (isset($_POST['action']) && $_POST['action'] === 'modifier') {

    $idCours = $_POST["idcours"];
    $nomCours = $_POST["libcours"];
    $horaireDebut = $_POST["horairedebut"];
    $horaireFin = $_POST["horairefin"];
    $jour = $_POST["jour"];

    $unCours = new Cours($idCours, $nomCours, $horaireDebut, $horaireFin, $jour);

    $unCours->UpdateCours();
    header('Location: cours.php');
    exit();
}

// Fonction pour calculer la prochaine date d'un jour donné à partir de la date actuelle
function getNextWeekDay($day) {
    $daysOfWeek = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];
    $currentDay = strtolower(date('l', strtotime('today')));
    $currentDate = new DateTime();
    $currentDayOfWeek = $currentDate->format('N'); // 1 (lundi) to 7 (dimanche)

    // Trouver le jour de la semaine correspondant à la saisie
    $dayIndex = array_search(strtolower($day), $daysOfWeek);

    // Calculer la différence en jours
    $diff = ($dayIndex + 1 - $currentDayOfWeek + 7) % 7;

    // Si le jour est aujourd'hui ou dans le futur
    $nextDate = $currentDate->modify("+$diff days");

    return $nextDate->format('Y-m-d');
}

// Lors de la soumission du formulaire pour la création du cours
if (isset($_POST["nom"]) && isset($_POST["debut"]) && isset($_POST["fin"]) && isset($_POST["Jour"])) {
    $nom = $_POST["nom"];
    $debut = $_POST["debut"];
    $fin = $_POST["fin"];
    $jour = $_POST["Jour"];

    // Créer un objet Cours
    $unCours = new Cours(null, $nom, $debut, $fin, $jour);

    // Obtenir la prochaine date du cours
    $firstDate = getNextWeekDay($jour);

    // Insert the course and get the last insert ID
    $unCours->InsertCours(date('Y-m-d', strtotime($firstDate)));

    
    $idcours = $con->lastInsertId(); // Assuming $con is your PDO connection object

    // Créer les cours récurrents pour 1 an
    for ($i = 1; $i < 53; $i++) {
        // Calculate the date for the current iteration
        $date = date("Y-m-d", strtotime("+$i week", strtotime($firstDate)));

        // Prepare the SQL statement with placeholders
        $stmt = $con->prepare("INSERT INTO calendrier (idcoursbase, idcoursassociee, datecours) VALUES (?, ?, ?)");

        if ($stmt === false) {
            die('prepare() failed: ' . htmlspecialchars($con->error));
        }

        // Bind the parameters to the prepared statement
        $stmt->bindParam(1, $i, PDO::PARAM_INT);
        $stmt->bindParam(2, $idcours, PDO::PARAM_INT);
        $stmt->bindParam(3, $date, PDO::PARAM_STR);

        // Execute the statement
        if (!$stmt->execute()) {
            die('execute() failed: ' . htmlspecialchars($stmt->error));
        }
    }

    header("Location: cours.php");
    exit();
}

if (isset($_POST["supprimer"])) {
    $idCours = $_POST["supprimer"];
    $unCours = new Cours($idCours, null, null, null, null); // Crée un objet Cours avec seulement l'ID
    $unCours->DeleteCours($idCours);
    header("Location: cours.php");
    exit();
}

?>
