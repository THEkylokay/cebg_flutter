<?php
include '../../includes/haut.inc.php';

// Debug - Afficher les données reçues
echo "<h3>Données reçues :</h3>";
echo "<pre>";
print_r($_POST);
echo "</pre>";

// Modification d'une pension
if (isset($_POST['action']) && $_POST['action'] === 'modifier') {
    $idPension = $_POST['idpension'];
    $libPension = $_POST['libpension'];
    $tarifPension = $_POST['tarifpension'];
    $dateDebut = $_POST['datedebut'];
    $dateFin = $_POST['datefin'];
    $numSire = $_POST['numsire'];

    $unePension = new Pension(
        $idPension,
        $libPension,
        $tarifPension,
        $dateDebut,
        $dateFin,
        $numSire
    );
    
    if($unePension->UpdatePension()) {
        header('Location: pension.php');
        exit();
    } else {
        echo "Erreur lors de la modification de la pension";
    }
}

// Ajout d'une nouvelle pension
if (isset($_POST["libpension"]) && !isset($_POST['action'])) {
    $libPension = $_POST['libpension'];
    $tarifPension = $_POST['tarifpension'];
    $dateDebut = $_POST['datedebut'];
    $dateFin = $_POST['datefin'];
    $numSire = $_POST['numsire'];
    $idCavalier = $_POST['idcavalier'];

    $unePension = new Pension(
        null,
        $libPension,
        $tarifPension,
        $dateDebut,
        $dateFin,
        $numSire
    );
    
    if($unePension->InsertPension()) {
        $idPension = $con->lastInsertId();
        $sql = "INSERT INTO prend (idcavalier, idpension) VALUES (:idcavalier, :idpension)";
        $stmt = $con->prepare($sql);
        $stmt->execute([':idcavalier' => $idCavalier, ':idpension' => $idPension]);
        
        header('Location: pension.php');
        exit();
    } else {
        echo "Erreur lors de l'ajout de la pension";
    }
}

// Suppression d'une pension (mise à jour de afficher = false)
if (isset($_POST['supprimer'])) {
    $idPension = $_POST['supprimer'];
    
    $unePension = new Pension($idPension, null, null, null, null, null);
    
    if($unePension->DeletePension()) {
        header('Location: pension.php');
        exit();
    } else {
        echo "Erreur lors de la suppression de la pension";
    }
}
?>