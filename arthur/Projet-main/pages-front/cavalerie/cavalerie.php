<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Chevaux - Centre Équestre</title>
    <link rel="stylesheet" href="../../css/style-front.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../js/modal.js"></script>
    <script src="../../js/script-front.js"></script>
</head>

<body>
    <header>
        <div class="container">
            <a href="../../index.html"><img src="../../pages-front/images-front/93863d47-8a92-4b31-b3c8-8f9891f6792a-removebg-preview.png" alt="Logo du Centre Équestre" class="logo"></a>
            <nav>
                <ul>
                    <li><a href="../../index.html" ><i class="fas fa-home"></i> Accueil</a></li>
                    <li><a href="../info/info.html" ><i class="fas fa-info-circle"></i> Info</a></li>
                    <li><a href="../services/services.html" ><i class="fas fa-cogs"></i> Services</a></li>
                    <li><a href="../inscription/inscription.html" ><i class="fas fa-envelope"></i> S'inscrire</a></li>
                    <li><a href="cavalerie.php" class="active" ><i class="fas fa-horse-head"></i> Nos chevaux</a></li>
                    <li><a href="../evenements/evenements.php" ><i class="fas fa-calendar-alt"></i> Évènements</a></li>
                    <li><a href="../cours/cours.php" ><i class="fas fa-chalkboard-teacher"></i> Cours</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="features">
        <div class="container">
            <h2>Nos Chevaux</h2>
        </div>
    </section>

    <section class="chevaux-section">
        <div class="container">
            <div class="chevaux-grid">
                <?php
                include '../../includes/bdd.inc.php';
                include '../../pages/cavalerie/cavalerie.class.php';

                $cavalerie = new Cavalerie(null, null, null, null, null, null);
                $chevaux = $cavalerie->selectChevaux();

                foreach ($chevaux as $cheval): 
                    $photos = $cheval->getPhotos($cheval->getNumsire());
                    $race = $cheval->getRaceLibelle($cheval->getIdRace());
                    $dateNaissance = $cheval->getDateNaissanceCheval();
                ?>
                    <div class="card-wrapper">
                        <div class="cheval-card" data-photos="<?= htmlspecialchars(json_encode($photos)) ?>" 
                             data-date-naissance="<?= htmlspecialchars($dateNaissance) ?>" 
                             data-id="<?= htmlspecialchars($cheval->getNumsire()) ?>" 
                             data-garot="<?= htmlspecialchars($cheval->getGarot()) ?>"
                             data-robe="<?= htmlspecialchars($cheval->getRobeLibelle($cheval->getIdRobe())) ?>"
                             onclick="openModal(this)">
                            <?php if ($photos): ?>
                                <img src="<?= htmlspecialchars($photos[0]) ?>" alt="Photo de <?= htmlspecialchars($cheval->getNomCheval()) ?>">
                            <?php else: ?>
                                <img src="cheval-default.jpg" alt="Photo par défaut">
                            <?php endif; ?>
                            <h3><?= htmlspecialchars($cheval->getNomCheval()) ?></h3>
                            <div class="hover-info">
                                <p class="age"></p>
                                <p class="race">Race : <?= htmlspecialchars($race) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <script>
        function calculerAge(dateNaissance) {
            const dateNaissanceObj = new Date(dateNaissance);
            const aujourdhui = new Date();
            let age = aujourdhui.getFullYear() - dateNaissanceObj.getFullYear();
            
            if (aujourdhui.getMonth() < dateNaissanceObj.getMonth() || 
                (aujourdhui.getMonth() === dateNaissanceObj.getMonth() && 
                 aujourdhui.getDate() < dateNaissanceObj.getDate())) {
                age--;
            }
            
            return age;
        }

        document.querySelectorAll('.cheval-card').forEach(card => {
            const dateNaissance = card.dataset.dateNaissance;
            const age = calculerAge(dateNaissance);
            const ageElement = card.querySelector('.age');
            ageElement.textContent = `${age} an${age > 1 ? 's' : ''}`;
        });
    </script>

    <footer>
        <div class="container">
            <p>
                <span>Email :</span> contact@centreequestre.com | 
                <span>Téléphone :</span> 01 23 45 67 89
            </p>
            <div class="separator"></div>
            <p class="copyright">
                &copy; 2024 Centre Équestre. Tous droits réservés.
            </p>
        </div>
    </footer>

    <button class="scroll-to-top" id="scroll-to-top">
        <i class="fas fa-arrow-up"></i> <!-- Utilisation d'une icône Font Awesome -->
    </button>

</body>
</html> 