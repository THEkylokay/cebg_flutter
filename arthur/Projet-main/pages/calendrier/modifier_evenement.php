<?php
header('Content-Type: application/json');
include("../../includes/bdd.inc.php");

// Récupérer les données envoyées en POST
$data = json_decode(file_get_contents('php://input'), true);

// Vérifier les données
if (isset($data['id']) && isset($data['title']) && isset($data['start'])) {
    $id = (int)$data['id'];
    $title = $data['title'];
    $start = date('Y-m-d H:i:s', strtotime($data['start']));
    $end = isset($data['end']) ? date('Y-m-d H:i:s', strtotime($data['end'])) : $start;

    // Préparer la requête de mise à jour
    $stmt = $con->prepare("UPDATE cours SET libcours = ?, horairedebut = ?, horairefin = ? WHERE idcours = ?");
    
    // Exécuter la requête de mise à jour
    if ($stmt->execute([$title, $start, $end, $id])) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour de l\'événement']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Données manquantes']);
}
?> 