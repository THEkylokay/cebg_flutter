<?php
// supprimer_evenement.php
header('Content-Type: application/json');
include("../../includes/bdd.inc.php"); // Inclure votre fichier de connexion à la BDD

// Récupérer les données envoyées en POST
$data = json_decode(file_get_contents('php://input'), true);

// Vérifier que l'ID de l'événement est présent
if (isset($data['eventId'])) {
    $eventId = (int)$data['eventId'];

    // Préparer la requête pour mettre à jour l'événement et le marquer comme non affiché dans la table calendrier
    $stmt = $con->prepare("UPDATE calendrier SET afficher = false WHERE idcoursassociee = ?");
    
    // Exécuter la requête et capturer l'échec potentiel
    if ($stmt->execute([$eventId])) {
        echo json_encode(['success' => true]);
    } else {
        // Capture l'erreur SQL si l'exécution échoue
        $errorInfo = $stmt->errorInfo();
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour de l\'événement', 'error' => $errorInfo]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID de l\'événement manquant']);
}

?>
