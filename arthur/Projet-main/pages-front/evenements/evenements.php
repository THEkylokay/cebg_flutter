<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Événements - Centre Équestre</title>
    <link rel="stylesheet" href="../../css/style-front.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
                    <li><a href="../cavalerie/cavalerie.php" ><i class="fas fa-horse-head"></i> Nos chevaux</a></li>
                    <li><a href="evenements.php" class="active" ><i class="fas fa-calendar-alt"></i> Évènements</a></li>
                    <li><a href="../cours/cours.php" ><i class="fas fa-chalkboard-teacher"></i> Cours</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="features">
        <div class="container">
            <h2>Nos Événements</h2>
            <div class="features-container">
                <table id="EvenementTable" class="schedule-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Titre</th>
                            <th>Commentaire</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include '../../includes/bdd.inc.php';
                        include '../../pages/evenement/evenement.class.php';

                        $evenements = Evenement::selectEvenements();

                        foreach ($evenements as $evenement): ?>
                            <tr>
                                <td><?= htmlspecialchars($evenement->getIdEvenement()) ?></td>
                                <td><?= htmlspecialchars($evenement->getTitreEvenement()) ?></td>
                                <td><?= htmlspecialchars($evenement->getCommentaire()) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {
            $('#EvenementTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/French.json"
                }
            });
        });
    </script>

    <!-- Footer -->
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