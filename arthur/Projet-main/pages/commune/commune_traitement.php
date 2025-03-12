<?php

include '../../includes/haut.inc.php';

if (isset($_POST['action']) && $_POST['action'] === 'modifier') {
    $idCommune = $_POST["idcommune"];
    $nomCommune = $_POST["ville"];
    $codePostal = $_POST["codepostal"];

    $uneCommune = new Commune($idCommune, $nomCommune, $codePostal);
    $uneCommune->UpdateCommune();
}

if (isset($_POST['nom'])) {
    $nomCommune = $_POST['nom'];
    $codePostal = $_POST['codepostal'];

    $uneCommune = new Commune(null, $nomCommune, $codePostal);
    $uneCommune->InsertCommune();
}

if (isset($_POST['supprimer'])) {
    $idCommune = $_POST['supprimer'];
    $uneCommune = new Commune($idCommune, null, null);
    $uneCommune->DeleteCommune($idCommune);
}

header('Location: commune.php');
exit;