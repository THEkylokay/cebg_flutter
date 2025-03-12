<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Calendrier</title>
  <?php include "../../includes/haut.inc.php"; ?>
  <script src='../../js/index.global.js'></script>
  <link rel="stylesheet" href="../../css/calendrier.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script>
    document.addEventListener('DOMContentLoaded', async function() {
      var calendarEl = document.getElementById('calendar');
      
      var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        buttonText: {
          today: 'aujourd\'hui',
          month: 'mois',
          week: 'semaine',
          day: 'jour'
        },
        locale: 'fr',
        initialDate: new Date(),
        navLinks: true,
        selectable: true,
        selectMirror: true,
        select: async function(arg) {
          var title = prompt('Titre de l\'événement :');

          if (title !== null && title !== '') {
            var startTime = prompt('Heure de début (HH:MM, 24h):');
            var endTime = prompt('Heure de fin (HH:MM, 24h):');

            if (validateTime(startTime) && validateTime(endTime)) {
              var startDate = new Date(arg.start);
              var endDate = new Date(arg.start);
              var startTimeArr = startTime.split(':');
              var endTimeArr = endTime.split(':');

              startDate.setHours(startTimeArr[0], startTimeArr[1]);
              endDate.setHours(endTimeArr[0], endTimeArr[1]);

              if (startDate < endDate) {
                var eventData = {
                  title: title,
                  datecours : startDate,
                  start: startDate.toISOString(),
                  end: endDate.toISOString(),
                  allDay: false,
                };

                try {
                  const response = await fetch('ajouter_evenement.php', {
                    method: 'POST',
                    headers: {
                      'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(eventData)
                  });
                  const data = await response.json();
                  if (data.success) {
                    eventData.id = data.eventId;
                    calendar.addEvent(eventData);
                  } else {
                    alert('Erreur lors de l\'ajout de l\'événement.');
                  }
                } catch (error) {
                  console.error('Erreur:', error);
                  alert('Erreur lors de l\'enregistrement de l\'événement.');
                }
              } else {
                alert('L\'heure de fin doit être après l\'heure de début.');
              }
            } else {
              alert('Veuillez fournir des heures valides au format HH:MM.');
            }
          }
          calendar.unselect();
        },
        eventClick: async function(arg) {
          if (!arg.event.extendedProps.canDelete) {
            alert('Cet événement a déjà été annulé et ne peut pas être supprimé.');
            return;
          }

          if (confirm('Voulez-vous supprimer ce cours ?')) {
            console.log("ID de l'événement:", arg.event.id);

            if (arg.event.id) {
              fetch('supprimer_evenement.php', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                },
                body: JSON.stringify({ eventId: arg.event.id })
              })
              .then(response => response.json())
              .then(data => {
                if (data.success) {
                  alert("Événement supprimé avec succès");
                  location.reload();
                } else {
                  alert('Erreur lors de la suppression de l\'événement.');
                  console.error(data.message);
                }
              })
              .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de la suppression de l\'événement.');
              });
            } else {
              alert('Aucun ID d\'événement trouvé pour cette suppression.');
            }
            return;
          }

          if (confirm('Voulez-vous modifier ce cours ?')) {
            var newTitle = prompt('Nouveau titre de l\'événement :', arg.event.title);
            if (newTitle !== null && newTitle !== '') {
              var newStartTime = prompt('Nouvelle heure de début (HH:MM, 24h):', arg.event.start.toISOString().substring(11, 16));
              var newEndTime = prompt('Nouvelle heure de fin (HH:MM, 24h):', arg.event.end.toISOString().substring(11, 16));

              if (validateTime(newStartTime) && validateTime(newEndTime)) {
                var newStartDate = new Date(arg.event.start);
                var newEndDate = new Date(arg.event.start);
                var newStartTimeArr = newStartTime.split(':');
                var newEndTimeArr = newEndTime.split(':');

                newStartDate.setHours(newStartTimeArr[0], newStartTimeArr[1]);
                newEndDate.setHours(newEndTimeArr[0], newEndTimeArr[1]);

                if (newStartDate < newEndDate) {
                  var updatedEventData = {
                    id: arg.event.id,
                    title: newTitle,
                    start: newStartDate.toISOString(),
                    end: newEndDate.toISOString(),
                  };

                  try {
                    const response = await fetch('modifier_evenement.php', {
                      method: 'POST',
                      headers: {
                        'Content-Type': 'application/json',
                      },
                      body: JSON.stringify(updatedEventData)
                    });
                    const data = await response.json();
                    if (data.success) {
                      arg.event.setProp('title', newTitle);
                      arg.event.setStart(newStartDate);
                      arg.event.setEnd(newEndDate);
                    } else {
                      alert('Erreur lors de la modification de l\'événement.');
                    }
                  } catch (error) {
                    console.error('Erreur:', error);
                    alert('Erreur lors de la modification de l\'événement.');
                  }
                } else {
                  alert('L\'heure de fin doit être après l\'heure de début.');
                }
              } else {
                alert('Veuillez fournir des heures valides au format HH:MM.');
              }
            }
          }
        },
        editable: true,
        dayMaxEvents: true,
        events: function(info, successCallback, failureCallback) {
          fetch('get_evenement.php')
            .then(response => response.json())
            .then(data => {
              console.log('Données récupérées:', data);
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

    function validateTime(time) {
      const regex = /^([01]\d|2[0-3]):([0-5]\d)$/;
      return regex.test(time);
    }
  </script>
</head>
<body>
  <div id="calendar"></div>
</body>
</html>
