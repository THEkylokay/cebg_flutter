<?php

include '../../includes/haut.inc.php';

// Ajoutez cette fonction helper au début du fichier
function sendJsonResponse($success, $message, $data = []) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
    exit();
}

// Modification d'un cavalier
if (isset($_POST['action']) && $_POST['action'] === 'modifier') {
    try {
        $idCavalier = $_POST["idcavalier"];
        $nomCavalier = $_POST["nomcavalier"];
        $prenomCavalier = $_POST["prenomcavalier"];
        $dateNaissanceCavalier = $_POST["datenaissancecavalier"];
        $nomResponsable = $_POST["nomresponsable"];
        $rueResponsable = $_POST["rueresponsable"];
        $telResponsable = $_POST["telresponsable"];
        $emailResponsable = $_POST["emailresponsable"];
        $numLicence = $_POST["numlicence"];
        $numAssurance = $_POST["numassurance"];
        $idcommune = $_POST["idcommune"]; 
        $idGalop = $_POST["idgalop"];

        $unCavalier = new Cavalier(
            $idCavalier,
            $nomCavalier,
            $prenomCavalier,
            $dateNaissanceCavalier,
            $nomResponsable,
            $rueResponsable,
            $telResponsable,
            $emailResponsable,
            null, // password n'est pas modifié
            $numLicence,
            $numAssurance,
            $idcommune,
            $idGalop
        );
        
        if ($unCavalier->UpdateCavalier()) {
            $_SESSION['success'] = "Cavalier modifié avec succès";
        } else {
            $_SESSION['error'] = "Erreur lors de la modification du cavalier";
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Erreur : " . $e->getMessage();
    }
    
    header("Location: cavalier.php");
    exit();
}

// Ajout d'un nouveau cavalier
if (isset($_POST["nomcavalier"]) && !isset($_POST['action'])) {
    $nomCavalier = $_POST["nomcavalier"];
    $prenomCavalier = $_POST["prenomcavalier"];
    $dateNaissanceCavalier = $_POST["datenaissancecavalier"];
    $nomResponsable = $_POST["nomresponsable"];
    $rueResponsable = $_POST["rueresponsable"];
    $telResponsable = $_POST["telresponsable"];
    $emailResponsable = $_POST["emailresponsable"];
    $password = $_POST["password"];
    $numLicence = $_POST["numlicence"];
    $numAssurance = $_POST["numassurance"];
    
    // Création des objets Commune et Galop
    $idcommune = $_POST["idcommune"]; 
    $commune = new Commune($idcommune, null, null);
    $idGalop = $_POST["idgalop"];
    $galop = new Galop($idGalop, null);

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $unCavalier = new Cavalier(
        null,
        $nomCavalier,
        $prenomCavalier,
        $dateNaissanceCavalier,
        $nomResponsable,
        $rueResponsable,
        $telResponsable,
        $emailResponsable,
        $hashed_password,
        $numLicence,
        $numAssurance,
        $commune,
        $galop
    );
    
    $unCavalier->InsertCavalier();
    header("Location: cavalier.php");
    exit(); 
}

// Suppression d'un cavalier
if (isset($_POST["supprimer"])) {
    try {
        $idCavalier = $_POST["supprimer"]; 
        $unCavalier = new Cavalier($idCavalier, null, null, null, null, null, null, null, null, null, null, null, null); 
        $success = $unCavalier->DeleteCavalier($idCavalier);
        
        if ($success) {
            sendJsonResponse(true, "Cavalier supprimé avec succès");
        } else {
            sendJsonResponse(false, "Erreur lors de la suppression du cavalier");
        }
    } catch (Exception $e) {
        sendJsonResponse(false, "Erreur : " . $e->getMessage());
    }
}

?>
