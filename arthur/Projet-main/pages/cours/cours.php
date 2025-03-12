<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Cours</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  
</head>
<body>

<?php
include '../../includes/haut.inc.php';

// Requête pour récupérer les cours
$oCours = new Cours(null, null, null, null, null);
$ReqCours = $oCours->selectCours();
?>

<div class="container">
    <nav class="nav-menu">
        <button class="nav-btn" data-target="create">🎓 Créer un Cours</button>
        <button class="nav-btn active" data-target="list">📋 Liste des Cours</button>
    </nav>

    <div id="create-section" class="section">
        <h2>Créer un Cours</h2>
        <form action="cours_traitement.php" method="POST" class="form-generic">
            <div class="form-group">
                <label for="nom">Nom du cours:</label>
                <input type="text" name="nom" class="input-field" placeholder="Nom du cours" required>
            </div>

            <div class="form-group">
                <label for="debut">Début du cours:</label>
                <input type="time" name="debut" class="input-field" required>
            </div>

            <div class="form-group">
                <label for="fin">Fin du cours:</label>
                <input type="time" name="fin" class="input-field" required>
            </div>

            <div class="form-group">
                <label for="Jour">Jour du cours:</label>
                <input type="text" name="Jour" class="input-field" placeholder="Jour de la semaine" required>
            </div>

            <input type="submit" value="Créer" class="btn-submit">
        </form>
    </div>

    <div id="list-section" class="table-section section active">
        <h2>Liste des Cours</h2>
        <i class="fas fa-calendar-alt"></i>
        <i class="fas fa-user-cowboy"></i>
        <i class="fas fa-map-marker-alt"></i>
        <i class="fas fa-calendar-check"></i>
        <i class="fas fa-running"></i>
        <i class="fas fa-users"></i>
        <i class="fas fa-home"></i>
        <i class="fas fa-camera"></i>
        <i class="fas fa-layer-group"></i>
        <i class="fas fa-female"></i>
        <table id="CoursTable" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom Cours</th>
                    <th>Horaire Début</th>
                    <th>Horaire Fin</th>
                    <th>Jour</th>  
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ReqCours as $courstableau) : ?>
                    <tr id="row-<?= $courstableau->getIdCours() ?>">
                        <td><?= htmlspecialchars($courstableau->getIdCours()) ?></td>
                        <td>
                            <span class="static-field"><?= htmlspecialchars($courstableau->getLibCours()) ?></span>
                            <input type="text" class="edit-field" name="libcours" value="<?= htmlspecialchars($courstableau->getLibCours()) ?>" style="display:none;">
                        </td>
                        <td>
                            <span class="static-field"><?= htmlspecialchars($courstableau->getHoraireDebut()) ?></span>
                            <input type="datetime-local" class="edit-field" name="horairedebut" value="<?= $courstableau->getHoraireDebut() ?>" style="display:none;">
                        </td>
                        <td>
                            <span class="static-field"><?= htmlspecialchars($courstableau->getHoraireFin()) ?></span>
                            <input type="datetime-local" class="edit-field" name="horairefin" value="<?= $courstableau->getHoraireFin() ?>" style="display:none;">
                        </td>
                        <td>
                            <span class="static-field"><?= htmlspecialchars($courstableau->getJour()) ?></span>
                            <input type="text" class="edit-field" name="jour" value="<?= htmlspecialchars($courstableau->getJour()) ?>" style="display:none;">
                        </td>
                        <td>
                            <button id="modifier" class="modifier-btn" data-id="<?= $courstableau->getIdCours() ?>"><i class="fas fa-edit"></i> Modifier</button>
                            <button class="confirmer-btn" data-id="<?= $courstableau->getIdCours() ?>" style="display:none;"><i class="fas fa-check"></i> Confirmer</button>
                            <button class="annuler-btn" data-id="<?= $courstableau->getIdCours() ?>" style="display:none;"><i class="fas fa-times"></i> Annuler</button>
                            <form action="cours_traitement.php" method="POST" style='display:inline;' onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce cours?');">
                                <input type="hidden" name="supprimer" value="<?= $courstableau->getIdCours() ?>">
                                <button type="submit" class="supprimer-btn"><i class="fas fa-trash-alt"></i> Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#CoursTable').DataTable();
        
        // Gestion des onglets
        document.querySelectorAll('.nav-btn').forEach(button => {
            button.addEventListener('click', () => {
                // Retire la classe active de tous les boutons et sections
                document.querySelectorAll('.nav-btn').forEach(btn => btn.classList.remove('active'));
                document.querySelectorAll('.section').forEach(section => section.classList.remove('active'));
                
                // Ajoute la classe active au bouton cliqué
                button.classList.add('active');
                
                // Affiche la section correspondante
                const target = button.getAttribute('data-target');
                document.getElementById(`${target}-section`).classList.add('active');
            });
        });
    });

    document.querySelectorAll('.modifier-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const row = document.getElementById('row-' + id);
            row.querySelectorAll('.static-field').forEach(field => field.style.display = 'none');
            row.querySelectorAll('.edit-field').forEach(field => field.style.display = 'inline');
            row.querySelector('.modifier-btn').style.display = 'none';
            row.querySelector('.confirmer-btn').style.display = 'inline';
            row.querySelector('.annuler-btn').style.display = 'inline';
        });
    });
    document.querySelectorAll('.confirmer-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const row = document.getElementById('row-' + id);

            // Récupérer les valeurs modifiées
            const libcours = row.querySelector('input[name="libcours"]').value;
            const horairedebut = row.querySelector('input[name="horairedebut"]').value;
            const horairefin = row.querySelector('input[name="horairefin"]').value;
            const jour = row.querySelector('input[name="jour"]').value;

            // Soumettre via un formulaire caché
            const form = document.createElement('form');
            form.action = 'cours_traitement.php';
            form.method = 'POST';
            form.innerHTML = `
                <input type="hidden" name="idcours" value="${id}">
                <input type="hidden" name="libcours" value="${libcours}">
                <input type="hidden" name="horairedebut" value="${horairedebut}">
                <input type="hidden" name="horairefin" value="${horairefin}">
                <input type="hidden" name="jour" value="${jour}">
                <input type="hidden" name="action" value="modifier">
            `;
            document.body.appendChild(form);
            form.submit();
        });
    });


    document.querySelectorAll('.annuler-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const row = document.getElementById('row-' + id);
            row.querySelectorAll('.static-field').forEach(field => field.style.display = 'inline');
            row.querySelectorAll('.edit-field').forEach(field => field.style.display = 'none');
            row.querySelector('.modifier-btn').style.display = 'inline';
            row.querySelector('.confirmer-btn').style.display = 'none';
            row.querySelector('.annuler-btn').style.display = 'none';
        });
    });
</script>

</body>
</html>
