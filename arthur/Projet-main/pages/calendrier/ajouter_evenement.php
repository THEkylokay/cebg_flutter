<?php
header('Content-Type: application/json');
include("../../includes/bdd.inc.php");

// Récupérer les données envoyées en POST
$data = json_decode(file_get_contents('php://input'), true);

// Vérifier les données
if (isset($data['title']) && isset($data['start'])) {
    $title = $data['title'];
  
$start = date('Y-m-d H:i:s', strtotime($data['start'] . ' +1 hour'));
$end = isset($data['end']) ? date('Y-m-d H:i:s', strtotime($data['end'] . ' +1 hour')) : $start;

    $allDay = isset($data['allDay']) ? (int)$data['allDay'] : 0;
    $datecours = date('Y-m-d', strtotime($data['start']));
    $jour = date('l', strtotime($data['start']));

    // Préparer la requête d'insertion pour la table cours
    $stmt = $con->prepare("INSERT INTO cours (libcours, horairedebut, horairefin, jour, afficher) VALUES (?, ?, ?, ?, true)");
    
    // Exécuter la première requête d'insertion (cours)
    if ($stmt->execute([$title, $start, $end, $jour])) {
        // Récupérer l'ID du cours inséré
        $idcours = $con->lastInsertId();

        // Préparer la requête d'insertion pour la table calendrier
        $stmt2 = $con->prepare("INSERT INTO calendrier(idcoursbase, idcoursassociee, datecours, afficher) VALUES (1, ?, ?, true)");

        // Exécuter la deuxième requête d'insertion avec l'ID du cours et la date
        if ($stmt2->execute([$idcours, $datecours])) {
            echo json_encode(['success' => true, 'afficher' => true, 'eventId' => $idcours]);
        } else {
            $errorInfo = $stmt2->errorInfo();
            echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'ajout de l\'événement dans le calendrier', 'error' => $errorInfo]);
        }
    } else {
        $errorInfo = $stmt->errorInfo();
        echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'ajout de l\'événement', 'error' => $errorInfo]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Données manquantes']);
}
?>
