<?php
include '../../includes/haut.inc.php';

try {
    $photo = new Photo();
    
    // Récupération et affichage des photos existantes
    $photos = $photo->getPhotoByNumSire();

    echo "<h2>Galerie des photos</h2>";
    
    echo "<style>
        .photo-container {
            display: inline-block;
            margin: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: center;
        }
        .photo-container img {
            margin-bottom: 10px;
            max-width: 300px;
            height: auto;
        }
    </style>";

    if (empty($photos)) {
        echo "<p>Aucune photo n'est disponible.</p>";
    } else {
        foreach ($photos as $photo) {
            echo $photo->afficherPhoto();
        }
    }

} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
?> 
