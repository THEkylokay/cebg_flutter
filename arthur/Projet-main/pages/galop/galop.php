<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des galops</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
</head>
<body>
<?php
include "../../includes/haut.inc.php";

$oGalop = new Galop(null, null);
$ReqGalop = $oGalop->GalopAll();
?>

<div class="container">
    <nav class="nav-menu">
        <button class="nav-btn" data-target="create">🏆 Créer un Galop</button>
        <button class="nav-btn active" data-target="list">📋 Liste des Galops</button>
    </nav>

    <div id="create-section" class="section">
        <h2>Ajouter un Galop</h2>
        <form action="galop_traitement.php" method="POST" class="form-generic">
            <label for="libgalop">Libellé du galop:</label>
            <input type="text" name="libgalop" placeholder="Libellé du galop" required><br>
            <input type="submit" value="Créer">
        </form>
    </div>

    <div id="list-section" class="table-section section active">
        <h2>Liste des galops</h2>
        <table id="GalopsTable" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Libellé</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($ReqGalop as $unGalop): ?>
                <tr id="row-<?= $unGalop->getIdGalop() ?>">
                    <td><?= htmlspecialchars($unGalop->getIdGalop()) ?></td>
                    <td>
                        <span class="static-field"><?= htmlspecialchars($unGalop->getLibGalop()) ?></span>
                        <input type="text" class="edit-field" name="libgalop" 
                            value="<?= htmlspecialchars($unGalop->getLibGalop()) ?>" 
                            style="display:none;">
                    </td>
                    <td>
                        <button class="modifier-btn" data-id="<?= $unGalop->getIdGalop() ?>">Modifier</button>
                        <button class="confirmer-btn" data-id="<?= $unGalop->getIdGalop() ?>" style="display:none;">Confirmer</button>
                        <button class="annuler-btn" data-id="<?= $unGalop->getIdGalop() ?>" style="display:none;">Annuler</button>
                        <form action="galop_traitement.php" method="POST" style='display:inline;' 
                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce galop ?');">
                            <input type="hidden" name="supprimer" value="<?= $unGalop->getIdGalop() ?>">
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
        $('#GalopsTable').DataTable();
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
            const row = this.closest('tr');
            row.querySelectorAll('.static-field').forEach(field => field.style.display = 'none');
            row.querySelectorAll('.edit-field').forEach(field => field.style.display = 'inline');
            this.style.display = 'none';
            row.querySelector('.confirmer-btn').style.display = 'inline';
            row.querySelector('.annuler-btn').style.display = 'inline';
        });
    });

    // Confirmation
    document.querySelectorAll('.confirmer-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const row = document.getElementById('row-' + id);
            const libgalop = row.querySelector('input[name="libgalop"]').value;

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'galop_traitement.php';
            form.innerHTML = `
                <input type="hidden" name="idgalop" value="${id}">
                <input type="hidden" name="libgalop" value="${libgalop}">
                <input type="hidden" name="action" value="modifier">
            `;
            document.body.appendChild(form);
            form.submit();
        });
    });

    // Annulation
    document.querySelectorAll('.annuler-btn').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            row.querySelectorAll('.static-field').forEach(field => field.style.display = 'inline');
            row.querySelectorAll('.edit-field').forEach(field => field.style.display = 'none');
            row.querySelector('.modifier-btn').style.display = 'inline';
            this.style.display = 'none';
            row.querySelector('.confirmer-btn').style.display = 'none';
        });
    });
</script>
</body>
</html> 
