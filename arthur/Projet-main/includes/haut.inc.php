<?php
include 'bdd.inc.php';
session_start();

// Vérification de la session utilisateur
if (isset($_SESSION['user_id'])) {
    $session_idcompte = $_SESSION['user_id'];

    // Requête pour vérifier si l'utilisateur existe toujours
    $query = $con->prepare("SELECT COUNT(*) FROM compte WHERE idcompte = :idcompte");
    $query->bindParam(':idcompte', $session_idcompte);
    $query->execute();

    // Si l'utilisateur est valide, affichage du pseudo et du bouton de déconnexion
    if ($query->fetchColumn() > 0) {
        $user_pseudo = $_SESSION['user_pseudo'];
    } else {
        header('Location: ../connexion/connexion.php');
        exit();
    }
} else {
    header('Location: ../connexion/connexion.php');
    exit();
}

// Si le bouton de déconnexion est cliqué, détruire la session
if (isset($_POST['logout'])) {
    session_destroy(); // Détruire la session
    header('Location: ../connexion/connexion.php'); // Redirection vers la page de connexion
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="../../css/style.css">
    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/script.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="../../js/onglets.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header class="header-container">
        <a href="../../pages/menu/menu.php"><button id="menu-button">Menu</button></a>
        <div class="user-info">
            Bienvenue, <strong><?php echo htmlspecialchars($user_pseudo); ?></strong>
        </div>
        <form action="" method="post" class="logout-form" style="all:unset">
            <button type="submit" name="logout">Déconnexion</button>
        </form>
    </header>

    <div class="sidebar" style="z-index: 0; height: 100%; overflow-y: auto;">
        <a href="../../pages/calendrier/calendrier.php">Calendrier</a>
        <a href="../../pages/cavalerie/cavalerie.php">Cavalerie</a>
        <a href="../../pages/cavalier/cavalier.php">Cavalier</a>
        <a href="../../pages/commune/commune.php">Commune</a>
        <a href="../../pages/cours/cours.php">Cours</a>
        <a href="../../pages/evenement/evenement.php">Événement</a>
        <a href="../../pages/galop/galop.php">Galop</a>
        <a href="../../pages/insert/insert.php">Insert</a>
        <a href="../../pages/pension/pension.php">Pension</a>
        <a href="../../pages/photo/photo.php">Photo</a>
        <a href="../../pages/race/race.php">Race</a>
        <a href="../../pages/robe/robe.php">Robe</a>
    </div>

    <div class="content">
        <?php
        include '../../pages/cavalerie/cavalerie.class.php';
        include '../../pages/cavalier/cavalier.class.php';
        include '../../pages/commune/commune.class.php';
        include '../../pages/cours/cours.class.php';
        include '../../pages/galop/galop.class.php';
        include '../../pages/participation/participation.class.php';
        include '../../pages/insert/insert.class.php';
        include '../../pages/pension/pension.class.php';
        include '../../pages/photo/photo.class.php';
        include '../../pages/race/race.class.php';
        include '../../pages/robe/robe.class.php';
        ?>
    </div>

    <!-- Flèche pour remonter en haut -->
    <div id="scroll-to-top" class="scroll-to-top" style="display: none;">
        &#8679; <!-- Flèche vers le haut -->
    </div>
</body>
</html>
