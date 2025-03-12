<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cours - Centre Équestre</title>
    <link rel="stylesheet" href="../../css/style-front.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src='../../js/index.global.js'></script>
    
        <style>
      :root {
    --primary-color: #2e4d1a;
    --secondary-color: #b29e3b;
    --accent-color: #d3c76f;
    --dark-color: #1d0f2c;
    --light-color: #f9f4f4;
    --gradient-start: #2e4d1a;
    --gradient-end: #4b8c2d;
}

main {
    background: linear-gradient(rgba(255, 255, 255, 0.92), rgba(255, 255, 255, 0.92)),
                url('../../pages-front/images-front/background-horse.jpg') no-repeat center center fixed;
    background-size: cover;
    min-height: calc(100vh - 160px);
    padding: 120px 20px 40px; /* Augmenté le padding-top pour éviter le header */
    position: relative;
}

.calendar-container {
    max-width: 1000px; /* Réduit la largeur maximale */
    width: 90%;
    margin: 0 auto;
    background: white;
    border-radius: 20px;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    position: relative;
    z-index: 1;
}

.calendar-header {
    background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
    color: white;
    padding: 30px; /* Réduit le padding */
    text-align: center;
    border-bottom: 5px solid var(--accent-color);
}

.calendar-header h1 {
    font-size: 2.5em; /* Réduit la taille du titre */
    margin: 0;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
}

.calendar-header p {
    font-size: 1.1em; /* Réduit la taille du texte */
    margin-top: 10px;
    opacity: 0.9;
}

#calendar {
    padding: 20px;
    background: white;
}

/* Ajustement de la taille des événements */
.fc-event {
    padding: 6px !important;
    font-size: 0.9em !important;
}

/* Ajustement de la taille des boutons */
.fc .fc-button-primary {
    padding: 8px 16px !important;
    font-size: 0.9em !important;
}

/* Ajustement du titre du calendrier */
.fc .fc-toolbar-title {
    font-size: 1.5em !important;
}

/* Responsive */
@media (max-width: 768px) {
    main {
        padding: 100px 10px 40px; /* Ajusté pour mobile */
    }

    .calendar-container {
        width: 95%;
        margin: 0 auto;
        border-radius: 15px;
    }

    .calendar-header {
        padding: 20px;
    }

    .calendar-header h1 {
        font-size: 1.8em;
    }

    .calendar-header p {
        font-size: 0.9em;
    }

    #calendar {
        padding: 10px;
    }

    .fc .fc-toolbar {
        flex-direction: column;
        gap: 8px;
    }
}

/* Ajustement pour les très petits écrans */
@media screen and (max-height: 700px) {
    main {
        padding: 90px 20px 30px;
    }

    .calendar-header {
        padding: 15px;
    }

    .calendar-header h1 {
        font-size: 1.5em;
    }
}

/* Ajustement pour les grands écrans */
@media screen and (min-height: 1000px) {
    main {
        display: flex;
        align-items: center;
        justify-content: center;
        padding-top: 80px;
    }
}

    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                initialDate: new Date(),
                locale: 'fr',
                navLinks: true,
                editable: false,
                dayMaxEvents: true,
                events: function(info, successCallback, failureCallback) {
                    fetch('../../pages/calendrier/get_evenement.php')
                        .then(response => response.json())
                        .then(data => {
                            console.log('Données récupérées:', data); // Pour déboguer
                            successCallback(data);
                        })
                        .catch(error => {
                            console.error('Erreur:', error);
                            failureCallback(error);
                        });
                }
            });
            calendar.render();
        });
    </script>
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
                    <li><a href="../evenements/evenements.php" ><i class="fas fa-calendar-alt"></i> Évènements</a></li>
                    <li><a href="/cours.php" ><i class="fas fa-chalkboard-teacher"></i> Cours</a></li>
                </ul>
            </nav>
        </div>
    </header>

   
    <main>
        <div class="calendar-container">
            <div class="calendar-header">
                <h1>Planning des Cours</h1>
                <p>Découvrez et réservez vos séances d'équitation en quelques clics</p>
            </div>
            <div id="calendar"></div>
        </div>
    </main>
    

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
