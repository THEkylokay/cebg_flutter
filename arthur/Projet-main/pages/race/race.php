<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Race</title>
    
</head>
<body>

<?php
include '../../includes/haut.inc.php';
//SELECT BDD 
//RACE.PHP
$stmt = $con->query('SELECT idrace, librace FROM race WHERE afficher = 1');
$racetableaux= $stmt->fetchAll(PDO::FETCH_ASSOC);
$oRace = new Race(null, null);
$ReqRace = $oRace->selectRace();

?>

<div class="container">
    <nav class="nav-menu">
        <button class="nav-btn" data-target="create">🐎 Créer une Race</button>
        <button class="nav-btn active" data-target="list">📜 Liste des Races</button>
    </nav>

    <div id="create-section" class="section">
        <h2>Créer une Race</h2>
        <form action="race_traitement.php" method="post" class="form-generic">
            <div class="form-group">
                <label for="nom">Nom de la race:</label>
                <input type="text" name="nom" class="input-field" required>
            </div>
            <input type="submit" value="Créer" class="btn-submit">
        </form>
    </div>

    <div id="list-section" class="section active">
        <h2>Liste des Races</h2>
        <table id="RaceTable" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom de la race</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($racetableaux as $racetableau) : ?>
                <tr id="row-<?= $racetableau['idrace'] ?>">
                    <td><?= htmlspecialchars($racetableau['idrace']) ?></td>
                    <td>
                        <span class="static-field"><?= htmlspecialchars($racetableau['librace']) ?></span>
                        <input type="text" class="edit-field input-field" name="librace" 
                            value="<?= htmlspecialchars($racetableau['librace']) ?>" style="display:none;">
                    </td>
                    <td>
                        <button class="modifier-btn" data-id="<?= $racetableau['idrace'] ?>">Modifier</button>
                        <button class="confirmer-btn" data-id="<?= $racetableau['idrace'] ?>" style="display:none;">Confirmer</button>
                        <button class="annuler-btn" data-id="<?= $racetableau['idrace'] ?>" style="display:none;">Annuler</button>
                        <form action="race_traitement.php" method="POST" style="display:inline;" 
                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette race?');">
                            <input type="hidden" name="supprimer" value="<?= $racetableau['idrace'] ?>">
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
    // Activation de DataTables sur la table
    $(document).ready(function() {
        $('#RaceTable').DataTable();
    });

    // Quand le bouton "Modifier" est cliqué
    document.querySelectorAll('.modifier-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const row = document.getElementById('row-' + id);
            
            // Masquer les champs statiques et afficher les champs modifiables
            row.querySelectorAll('.static-field').forEach(field => field.style.display = 'none');
            row.querySelectorAll('.edit-field').forEach(field => field.style.display = 'inline');

            // Afficher les boutons "Confirmer" et "Annuler"
            row.querySelector('.modifier-btn').style.display = 'none';
            row.querySelector('.confirmer-btn').style.display = 'inline';
            row.querySelector('.annuler-btn').style.display = 'inline';
        });
    });

    // Quand le bouton "Confirmer" est cliqué
    document.querySelectorAll('.confirmer-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const row = document.getElementById('row-' + id);
            
            // Récupérer les valeurs modifiées
            const librace = row.querySelector('input[name="librace"]').value;
           

            // Créer un formulaire caché pour soumettre les données modifiées
            const form = document.createElement('form');
            form.action = 'race_traitement.php';
            form.method = 'POST';

            form.innerHTML = `
                <input type="hidden" name="idrace" id ="idrace" value="${id}">
                <input type="hidden" name="librace"id ="librace" value="${librace}">
               
                <input type="hidden" name="action" value="modifier">
            `;

            document.body.appendChild(form);
            form.submit();
        });
    });

    // Quand le bouton "Annuler" est cliqué
    document.querySelectorAll('.annuler-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const row = document.getElementById('row-' + id);
            
            // Réinitialiser les champs modifiables et retourner aux champs statiques
            row.querySelectorAll('.static-field').forEach(field => field.style.display = 'inline');
            row.querySelectorAll('.edit-field').forEach(field => field.style.display = 'none');

            // Cacher les boutons "Confirmer" et "Annuler", afficher "Modifier"
            row.querySelector('.modifier-btn').style.display = 'inline';
            row.querySelector('.confirmer-btn').style.display = 'none';
            row.querySelector('.annuler-btn').style.display = 'none';
        });
    });
</script>
    


</body>
</html>
