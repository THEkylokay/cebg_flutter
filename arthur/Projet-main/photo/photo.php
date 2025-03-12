<?php
include '../../includes/haut.inc.php';

try {
    $photo = new Photo();
    $photos = $photo->getPhotoByNumSire();
?>
    <div class="container">
        <h2>Galerie des photos</h2>
        
        <div class="gallery-container">
            <?php if (empty($photos)): ?>
                <p class="no-photos">Aucune photo n'est disponible.</p>
            <?php else: ?>
                <?php foreach ($photos as $photo): ?>
                    <div class="photo-container">
                        <?php echo $photo->afficherPhoto(); ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

<?php
} catch (Exception $e) {
    echo "<div class='error-message'>Erreur : " . $e->getMessage() . "</div>";
}
?> 
