<?php
include '../../includes/haut.inc.php';
include 'evenement.class.php';

if (isset($_POST['action'])) {
    if ($_POST['action'] === 'ajouter') {
        $titreEvenement = $_POST['titreevenement'];
        $commentaire = $_POST['commentaire'];

        $evenement = new Evenement(null, $titreEvenement, $commentaire);
        $evenement->InsertEvenement();
        header("Location: evenement.php");
        exit();
    }

    if ($_POST['action'] === 'modifier') {
        $idEvenement = $_POST['idevenement'];
        $titreEvenement = $_POST['titreevenement'];
        $commentaire = $_POST['commentaire'];

        $evenement = new Evenement($idEvenement, $titreEvenement, $commentaire);
        $evenement->UpdateEvenement();
        header("Location: evenement.php");
        exit();
    }
}

if (isset($_POST["supprimer"])) {
    $idEvenement = $_POST["supprimer"];
    $evenement = new Evenement($idEvenement, null, null);
    $evenement->DeleteEvenement($idEvenement);
    header("Location: evenement.php");
    exit();
}
?> 