<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Événements</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
</head>
<body>

<?php
include '../../includes/haut.inc.php';
include 'evenement.class.php';

$evenements = Evenement::selectEvenements();
?>

<div class="container">
    <nav class="nav-menu">
        <button class="nav-btn" data-target="create">📅 Créer un Événement</button>
        <button class="nav-btn active" data-target="list">📋 Liste des Événements</button>
    </nav>

    <div id="create-section" class="section">
        <h2>Créer un Événement</h2>
        <form action="evenement_traitement.php" method="POST" class="form-generic">
            <div class="form-group">
                <label for="titreevenement">Titre de l'événement:</label>
                <input type="text" name="titreevenement" class="input-field" required>
            </div>

            <div class="form-group">
                <label for="commentaire">Commentaire:</label>
                <textarea name="commentaire" class="input-field" required></textarea>
            </div>

            <input type="hidden" name="action" value="ajouter">
            <input type="submit" value="Créer" class="btn-submit">
        </form>
    </div>

    <div id="list-section" class="section active">
        <h2>Liste des Événements</h2>
        <table id="EvenementTable" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Commentaire</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($evenements as $evenement): ?>
                    <tr id="row-<?= $evenement->getIdEvenement() ?>">
                        <td><?= htmlspecialchars($evenement->getIdEvenement()) ?></td>
                        <td>
                            <span class="static-field"><?= htmlspecialchars($evenement->getTitreEvenement()) ?></span>
                            <input type="text" class="edit-field" name="titreevenement" value="<?= htmlspecialchars($evenement->getTitreEvenement()) ?>" style="display:none;">
                        </td>
                        <td>
                            <span class="static-field"><?= htmlspecialchars($evenement->getCommentaire()) ?></span>
                            <textarea class="edit-field" name="commentaire" style="display:none;"><?= htmlspecialchars($evenement->getCommentaire()) ?></textarea>
                        </td>
                        <td>
                            <button class="modifier-btn" data-id="<?= $evenement->getIdEvenement() ?>">Modifier</button>
                            <button class="confirmer-btn" data-id="<?= $evenement->getIdEvenement() ?>" style="display:none;">Confirmer</button>
                            <button class="annuler-btn" data-id="<?= $evenement->getIdEvenement() ?>" style="display:none;">Annuler</button>
                            <form action="evenement_traitement.php" method="POST" style="display:inline;" 
                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet événement?');">
                                <input type="hidden" name="supprimer" value="<?= $evenement->getIdEvenement() ?>">
                                <button type="submit" class="supprimer-btn">Supprimer</button>
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
    $('#EvenementTable').DataTable();

    // Gestion des onglets
    $('.nav-btn').on('click', function() {
        $('.nav-btn').removeClass('active');
        $('.section').removeClass('active');
        $(this).addClass('active');
        const target = $(this).data('target');
        $(`#${target}-section`).addClass('active');
    });
});

    // Gestionnaire de clic extérieur
    document.addEventListener('click', function(event) {
        const rows = document.querySelectorAll('tr[id^="row-"]');
        rows.forEach(row => {
            if (row.contains(event.target)) return;
            if (row.querySelector('.confirmer-btn').style.display === 'inline') {
                resetRow(row);
            }
        });
    });

    // Fonction pour réinitialiser une ligne
    function resetRow(row) {
        row.querySelectorAll('.static-field').forEach(field => field.style.display = 'inline');
        row.querySelectorAll('.edit-field').forEach(field => field.style.display = 'none');
        row.querySelector('.modifier-btn').style.display = 'inline';
        row.querySelector('.confirmer-btn').style.display = 'none';
        row.querySelector('.annuler-btn').style.display = 'none';
    }

    // Quand le bouton "Modifier" est cliqué
    document.querySelectorAll('.modifier-btn').forEach(button => {
        button.addEventListener('click', function(event) {
            event.stopPropagation();
            const id = this.getAttribute('data-id');
            const row = document.getElementById('row-' + id);

            row.querySelectorAll('.static-field').forEach(field => field.style.display = 'none');
            row.querySelectorAll('.edit-field').forEach(field => field.style.display = 'inline');

            this.style.display = 'none';
            row.querySelector('.confirmer-btn').style.display = 'inline';
            row.querySelector('.annuler-btn').style.display = 'inline';
        });
    });

    // Quand le bouton "Confirmer" est cliqué
    document.querySelectorAll('.confirmer-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const row = document.getElementById('row-' + id);

            const titreevenement = row.querySelector('input[name="titreevenement"]').value;
            const commentaire = row.querySelector('textarea[name="commentaire"]').value;

            const form = document.createElement('form');
            form.action = 'evenement_traitement.php';
            form.method = 'POST';
            form.innerHTML = `
                <input type="hidden" name="idevenement" value="${id}">
                <input type="hidden" name="titreevenement" value="${titreevenement}">
                <input type="hidden" name="commentaire" value="${commentaire}">
                <input type="hidden" name="action" value="modifier">
            `;
            document.body.appendChild(form);
            form.submit();
        });
    });

    // Quand le bouton "Annuler" est cliqué
    document.querySelectorAll('.annuler-btn').forEach(button => {
        button.addEventListener('click', function(event) {
            event.stopPropagation();
            const id = this.getAttribute('data-id');
            const row = document.getElementById('row-' + id);
            resetRow(row);
        });
    });

    // Empêcher la propagation du clic dans les champs d'édition
    document.querySelectorAll('.edit-field').forEach(field => {
        field.addEventListener('click', function(event) {
            event.stopPropagation();
        });
    });
</script>

</table>

</body>

</html>