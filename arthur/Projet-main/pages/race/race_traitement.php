<?php

include '../../includes/haut.inc.php';


if (isset($_POST['action']) && $_POST['action'] === 'modifier') {
  
    $idrace = $_POST["idrace"];
    $nomrace = $_POST["librace"]; 
    

    $uneRace = new Race($idrace, $nomrace);

    $uneRace->UpdateRace(); 
    header('Location: race.php');
    exit();
}

if (isset($_POST["nom"]) ) {
    $nom = $_POST["nom"];
    

    $uneRace = new Race(null, $nom);
    $uneRace->InsertRace();
    header("Location: race.php");
exit(); 
}


if (isset($_POST["supprimer"])) {
    $idRace = $_POST["supprimer"]; 
    $uneRace = new Race($idRace, null); 
    $uneRace->DeleteRace($idRace);
    header("Location: race.php");
exit(); 
}



?>
