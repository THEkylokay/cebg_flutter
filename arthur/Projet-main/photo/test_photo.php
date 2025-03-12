<?php  // Ajustez le chemin selon votre structure
include '../../includes/haut.inc.php'; // Ajustez le chemin selon votre structure
// Ajustez le chemin selon votre structure

// Test de création d'une nouvelle photo
try {
    $photo = new Photo();
    
    // Test avec des données fictives
    $photo->setLien("https://example.com/photo.jpg");
    $photo->setNumSire(1); // Remplacez par un numsire valide de votre base
    $photo->setIdEvenement(null);
    
    // Test de la méthode saveLink()
    if ($photo->saveLink()) {
        echo "Test saveLink : SUCCESS - La photo a été enregistrée<br>";
    } else {
        echo "Test saveLink : FAILED - Erreur lors de l'enregistrement<br>";
    }
    
    // Test de la méthode getPhotoByNumSire()
    $result = $photo->getPhotoByNumSire(1); // Remplacez par un numsire valide
    if ($result) {
        echo "Test getPhotoByNumSire : SUCCESS - Photo trouvée<br>";
        print_r($result);
    } else {
        echo "Test getPhotoByNumSire : FAILED - Aucune photo trouvée<br>";
    }

} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
?> 
