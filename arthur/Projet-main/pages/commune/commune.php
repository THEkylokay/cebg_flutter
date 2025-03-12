<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Communes</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
</head>
<body>

<?php
include '../../includes/haut.inc.php';

// Requête pour récupérer les communes
$oCommune = new Commune(null, null, null);
$ReqCommune = $oCommune->selectCommune();
?>

<div class="container">
    <nav class="nav-menu">
        <button class="nav-btn" data-target="create">🏘️ Créer une Commune</button>
        <button class="nav-btn active" data-target="list">📍 Liste des Communes</button>
    </nav>

    <div id="create-section" class="section ">
        <h2>Créer une Commune</h2>
        <form action="commune_traitement.php" method="POST" class="form-generic">
            <label for="nom">Nom de la commune:</label>
            <input type="text" name="nom" required><br>

            <label for="codepostal">Code Postal:</label>
            <input type="text" name="codepostal" required><br>

            <input type="submit" value="Créer">
        </form>
    </div>

    <div id="list-section" class="table-section section active">
        <h2>Liste des Communes</h2>
        <table id="CommuneTable" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom Commune</th>
                    <th>Code Postal</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ReqCommune as $commune) : ?>
                    <tr id="row-<?= $commune->getIdCommune() ?>">
                        <td><?= htmlspecialchars($commune->getIdCommune()) ?></td>
                        <td>
                            <span class="static-field"><?= htmlspecialchars($commune->getVille()) ?></span>
                            <input type="text" class="edit-field" name="ville" value="<?= htmlspecialchars($commune->getVille()) ?>" style="display:none;">
                        </td>
                        <td>
                            <span class="static-field"><?= htmlspecialchars($commune->getCodePostal()) ?></span>
                            <input type="text" class="edit-field" name="codepostal" value="<?= htmlspecialchars($commune->getCodePostal()) ?>" style="display:none;">
                        </td>
                        <td>
                            <button class="modifier-btn" data-id="<?= $commune->getIdCommune() ?>">Modifier</button>
                            <button class="confirmer-btn" data-id="<?= $commune->getIdCommune() ?>" style="display:none;">Confirmer</button>
                            <button class="annuler-btn" data-id="<?= $commune->getIdCommune() ?>" style="display:none;">Annuler</button>
                            <form action="commune_traitement.php" method="POST" style='display:inline;' 
                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette commune?');">
                                <input type="hidden" name="supprimer" value="<?= $commune->getIdCommune() ?>">
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
        $('#CommuneTable').DataTable();
    });

    // Gestion des onglets
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.nav-btn').forEach(button => {
            button.addEventListener('click', function() {
                document.querySelectorAll('.nav-btn').forEach(btn => btn.classList.remove('active'));
                document.querySelectorAll('.section').forEach(section => section.classList.remove('active'));
                button.classList.add('active');
                const target = button.getAttribute('data-target');
                document.getElementById(`${target}-section`).classList.add('active');
            });
        });
    });

    // Modification
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

    // Confirmation
    document.querySelectorAll('.confirmer-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const row = document.getElementById('row-' + id);
            const ville = row.querySelector('input[name="ville"]').value;
            const codepostal = row.querySelector('input[name="codepostal"]').value;

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'commune_traitement.php';
            form.innerHTML = `
                <input type="hidden" name="idcommune" value="${id}">
                <input type="hidden" name="ville" value="${ville}">
                <input type="hidden" name="codepostal" value="${codepostal}">
                <input type="hidden" name="action" value="modifier">
            `;
            document.body.appendChild(form);
            form.submit();
        });
    });

    // Annulation
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
