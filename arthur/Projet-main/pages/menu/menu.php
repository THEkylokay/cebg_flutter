<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    
    <div class="menu-container">
        <!-- Menu principal -->
        <nav class="liens">
            <div class="menu-section">
                <h3>Gestion</h3>
                <a href="../../pages/cavalier/cavalier.php">Cavaliers</a>
                <a href="../../pages/cavalerie/cavalerie.php">Cavalerie</a>
                <a href="../../pages/cours/cours.php">Cours</a>
                <a href="../../pages/pension/pension.php">Pensions</a>
                <a href="../../pages/calendrier/calendrier.php">Calendrier</a>
            </div>
            
            <div class="menu-section">
                <h3>Configuration</h3>
                <a href="../../pages/race/race.php">Races</a>
                <a href="../../pages/robe/robe.php">Robes</a>
                <a href="../../pages/galop/galop.php">Galops</a>
                <a href="../../pages/commune/commune.php">Communes</a>
                <a href="../../pages/evenement/evenement.php">Événements</a>
            </div>
        </nav>

        <!-- Dashboard d'informations -->
        <div class="dashboard">
            <div class="info-section">
                <h3>Derniers événements</h3>
                <div class="event-list">
                    <?php
                    include '../../pages/evenement/evenement.class.php';
                    include '../../pages/cours/cours.class.php';
                    include '../../includes/bdd.inc.php';
                    $events = Evenement::selectEvenements();
                    $recentEvents = array_slice($events, 0, 5); // 3 derniers événements
                    foreach($recentEvents as $event): ?>
                        <div class="event-item">
                            <span class="event-title"><?= htmlspecialchars($event->getTitreEvenement()) ?></span>
                            <p class="event-comment"><?= htmlspecialchars($event->getCommentaire()) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="info-section">
                <h3>Prochains cours</h3>
                <?php
                $oCours = new Cours(null, null, null, null, null);
                $prochainsCours = array_slice($oCours->selectCours(), 0, 5); // 3 prochains cours
                foreach($prochainsCours as $cours): ?>
                    <div class="cours-item">
                        <span class="cours-title"><?= htmlspecialchars($cours->getLibCours()) ?></span>
                        <span class="cours-time"><?= htmlspecialchars($cours->getHoraireDebut()) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>