<?php
include '../../includes/haut.inc.php';

// Ajouter une association
if (isset($_POST['action']) && $_POST['action'] === 'ajouter') {
    $idCavalier = $_POST['idcavalier'];
    $idPension = $_POST['idpension'];
    
    $prend = new Prend($idCavalier, $idPension);
    
    if($prend->InsertPrend()) {
        header('Location: prend.php?success=1');
        exit();
    } else {
        header('Location: prend.php?error=1');
        exit();
    }
}

// Supprimer une association
if (isset($_POST['action']) && $_POST['action'] === 'supprimer') {
    $idCavalier = $_POST['idcavalier'];
    $idPension = $_POST['idpension'];
    
    $prend = new Prend($idCavalier, $idPension);
    
    if($prend->DeletePrend()) {
        header('Location: prend.php?success=2');
        exit();
    } else {
        header('Location: prend.php?error=2');
        exit();
    }
}
?> 