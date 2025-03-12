<?php
include '../../includes/haut.inc.php';

if (isset($_POST['action']) && $_POST['action'] === 'modifier') {
    $idrobe = $_POST["idrobe"];
    $nomrobe = $_POST["librobe"]; 

    $uneRobe = new Robe($idrobe, $nomrobe);
    $uneRobe->UpdateRobe(); 
    header('Location: robe.php');
    exit();
}

if (isset($_POST["nom"])) {
    $nom = $_POST["nom"];
    
    $uneRobe = new Robe(null, $nom);
    $uneRobe->InsertRobe();
    header("Location: robe.php");
    exit(); 
}

if (isset($_POST["supprimer"])) {
    $idRobe = $_POST["supprimer"]; 
    $uneRobe = new Robe($idRobe, null); 
    $uneRobe->DeleteRobe($idRobe);
    header("Location: robe.php");
    exit(); 
}
?>
