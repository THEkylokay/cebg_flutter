<?php
include '../../includes/haut.inc.php';

// Modification d'une participation
if (isset($_POST['action']) && $_POST['action'] === 'modifier') {
    $idCoursbase = $_POST['idcoursbase'];
    $idCoursassociee = $_POST['idcoursassociee'];
    $idCavalier = $_POST['idcavalier'];
    $present = $_POST['present'];

    $uneParticipation = new Participation($idCoursbase, $idCoursassociee, $idCavalier, $present);
    $uneParticipation->UpdateParticipation();
    
    header('Location: participation.php');
    exit();
}

// Ajout d'une nouvelle participation
if (isset($_POST['idcoursbase']) && !isset($_POST['action'])) {
    $idCoursbase = $_POST['idcoursbase'];
    $idCoursassociee = $_POST['idcoursassociee'];
    $idCavalier = $_POST['idcavalier'];
    $present = $_POST['present'];

    $uneParticipation = new Participation($idCoursbase, $idCoursassociee, $idCavalier, $present);
    $uneParticipation->InsertParticipation();
    
    header('Location: participation.php');
    exit();
}

// Suppression d'une participation
if (isset($_POST['supprimer_coursbase'])) {
    $idCoursbase = $_POST['supprimer_coursbase'];
    $idCoursassociee = $_POST['supprimer_coursassociee'];
    $idCavalier = $_POST['supprimer_cavalier'];
    
    $uneParticipation = new Participation($idCoursbase, $idCoursassociee, $idCavalier, null);
    $uneParticipation->DeleteParticipation();
    
    header('Location: participation.php');
    exit();
}
?> 