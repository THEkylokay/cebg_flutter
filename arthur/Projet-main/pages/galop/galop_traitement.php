<?php
include '../../includes/haut.inc.php';

// Modification d'un galop
if (isset($_POST['action']) && $_POST['action'] === 'modifier') {
    $idGalop = $_POST['idgalop'];
    $libGalop = $_POST['libgalop'];

    $unGalop = new Galop($idGalop, $libGalop);
    $unGalop->UpdateGalop();
    
    header('Location: galop.php');
    exit();
}

// Ajout d'un nouveau galop
if (isset($_POST['libgalop']) && !isset($_POST['action'])) {
    $libGalop = $_POST['libgalop'];

    $unGalop = new Galop(null, $libGalop);
    $unGalop->InsertGalop();
    
    header('Location: galop.php');
    exit();
}

// Suppression d'un galop
if (isset($_POST['supprimer'])) {
    $idGalop = $_POST['supprimer'];
    
    $unGalop = new Galop($idGalop, null);
    $unGalop->DeleteGalop();
    
    header('Location: galop.php');
    exit();
}
?> 