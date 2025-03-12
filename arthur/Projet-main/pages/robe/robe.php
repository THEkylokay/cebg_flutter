<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Robe</title>
</head>
<body>

<?php
include '../../includes/haut.inc.php';

// Utilisation de la méthode selectRobe() pour obtenir les robes actives
$oRobe = new Robe(null, null);
$robetableaux = $oRobe->selectRobe();
?>

<div class="container">
    <nav class="nav-menu">
        <button class="nav-btn" data-target="create">🎨 Créer une Robe</button>
        <button class="nav-btn active" data-target="list">📋 Liste des Robes</button>
    </nav>

    <div id="create-section" class="section">
        <h2>Créer une Robe</h2>
        <form action="robe_traitement.php" method="post" class="form-generic">
            <label for="nom">Nom de la robe:</label>
            <input type="text" name="nom" required><br>
            <input type="submit" value="Créer">
        </form>
    </div>

    <div id="list-section" class="table-section section active">
        <h2>Liste des Robes</h2>
        <table id="RobeTable" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom de la robe</th> 
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($robetableaux as $robetableau) : ?>
                <tr id="row-<?= $robetableau->getIdRobe() ?>">
                    <td><?= htmlspecialchars($robetableau->getIdRobe()) ?></td>
                    <td>
                        <span class="static-field"><?= htmlspecialchars($robetableau->getLibRobe()) ?></span>
                        <input type="text" class="edit-field" name="librobe" value="<?= htmlspecialchars($robetableau->getLibRobe()) ?>" style="display:none;">
                    </td>
                    <td>
                        <button class="modifier-btn" data-id="<?= $robetableau->getIdRobe() ?>">Modifier</button>
                        <button class="confirmer-btn" data-id="<?= $robetableau->getIdRobe() ?>" style="display:none;">Confirmer</button>
                        <button class="annuler-btn" data-id="<?= $robetableau->getIdRobe() ?>" style="display:none;">Annuler</button>
                        <form action="robe_traitement.php" method="POST" style='display:inline;' onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette robe?');">
                            <input type="hidden" name="supprimer" value="<?= $robetableau->getIdRobe() ?>">
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
        $('#RobeTable').DataTable();
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
            const librobe = row.querySelector('input[name="librobe"]').value;

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'robe_traitement.php';
            form.innerHTML = `
                <input type="hidden" name="idrobe" value="${id}">
                <input type="hidden" name="librobe" value="${librobe}">
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
