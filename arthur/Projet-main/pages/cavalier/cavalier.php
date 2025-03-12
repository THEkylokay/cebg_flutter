<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des cavaliers</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <style>
        .section {
            display: none;
        }
        .section.active {
            display: block;
        }
        .nav-btn {
            padding: 10px 20px;
            margin: 5px;
            cursor: pointer;
        }
        .nav-btn.active {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>

<?php
include "../../includes/haut.inc.php";

$oCavalier = new Cavalier(null, null, null, null, null, null, null, null, null, null, null, null, null, null);
$ReqCavalier = $oCavalier->CavalierAll();
?>

<div class="container">
    <nav class="nav-menu">
        <button class="nav-btn" data-target="create">🏇 Ajouter un Cavalier</button>
        <button class="nav-btn active" data-target="list">📋 Liste des Cavaliers</button>
    </nav>

    <div id="create-section" class="section">
        <h2>Ajouter un Cavalier</h2>
        <form action="cavalier_traitement.php" method="POST" class="form-generic">
            <div class="form-group">
                <label for="nomcavalier">Nom du cavalier:</label>
                <input type="text" name="nomcavalier" class="input-field" placeholder="Nom du cavalier" required>
            </div>

            <div class="form-group">
                <label for="prenomcavalier">Prénom du cavalier:</label>
                <input type="text" name="prenomcavalier" class="input-field" placeholder="Prénom du cavalier" required>
            </div>

            <div class="form-group">
                <label for="datenaissancecavalier">Date de naissance du cavalier:</label>
                <input type="date" name="datenaissancecavalier" class="input-field" required>
            </div>

            <div class="form-group">
                <label for="nomresponsable">Nom du responsable:</label>
                <input type="text" name="nomresponsable" class="input-field" placeholder="Nom du responsable">
            </div>

            <div class="form-group">
                <label for="rueresponsable">Rue du responsable:</label>
                <input type="text" name="rueresponsable" class="input-field" placeholder="Rue du responsable">
            </div>

            <div class="form-group">
                <label for="telresponsable">Téléphone du responsable:</label>
                <input type="text" name="telresponsable" class="input-field" placeholder="Téléphone du responsable">
            </div>

            <div class="form-group">
                <label for="emailresponsable">Email du responsable:</label>
                <input type="email" name="emailresponsable" class="input-field" placeholder="Email du responsable">
            </div>

            <div class="form-group">
                <label for="password">Mot de passe:</label>
                <input type="password" name="password" class="input-field" placeholder="Mot de passe">
            </div>

            <div class="form-group">
                <label for="numlicence">Numéro de licence:</label>
                <input type="text" name="numlicence" class="input-field" placeholder="Numéro de licence">
            </div>

            <div class="form-group">
                <label for="numassurance">Numéro de l'assurance:</label>
                <input type="text" name="numassurance" class="input-field" placeholder="Numéro d'assurance">
            </div>

            <div class="form-group">
                <label for="nomcommune">Nom de la Commune et Code postal:</label>
                <div class="input_container">
                    <input type="text" name="nom_idcommune" id="nom_idcommune" class="input-field" placeholder="Commune" onkeyup="autocompletcommune()">
                    <input type="text" name="cp" id="cp" class="input-field" placeholder="Code Postal">
                    <input type="hidden" name="idcommune" id="idcommune">
                    <ul id="nom_list_idcommune"></ul>
                </div>
            </div>

            <div class="form-group">
                <label for="idgalop">Niveau de Galop:</label>
                <div class="input_container">
                    <input type="text" name='nomgalop' id="nom_idgalop" class="input-field" placeholder="Galop maitrisé" onkeyup="autocompletgalop()">
                    <input type="hidden" name='idgalop' id="idgalop">
                    <ul id="nom_list_idgalop"></ul>
                </div>
            </div>

            <input type="submit" value="Créer" class="btn-submit">
        </form>
    </div>

    <div id="list-section" class="section active">
        <h1>Liste des cavaliers</h1>
        <table id="CavaliersTable" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Date de Naissance</th>
                    <th>Nom Responsable</th>
                    <th>Rue Responsable</th>
                    <th>Téléphone Responsable</th>
                    <th>Email Responsable</th>
                    <th>Numéro Licence</th>
                    <th>Numéro Assurance</th>
                    <th>ID Commune</th>
                    <th>ID Galop</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($ReqCavalier as $unCavalier): ?>
                <tr id="row-<?= $unCavalier->getIdCavalier() ?>">
                    <td><?= htmlspecialchars($unCavalier->getIdCavalier()) ?></td>
                    <td>
                        <span class="static-field"><?= htmlspecialchars($unCavalier->getNomCavalier()) ?></span>
                        <input type="text" class="edit-field" name="nomcavalier" value="<?= htmlspecialchars($unCavalier->getNomCavalier()) ?>" style="display:none;">
                    </td>
                    <td>
                        <span class="static-field"><?= htmlspecialchars($unCavalier->getPrenomCavalier()) ?></span>
                        <input type="text" class="edit-field" name="prenomcavalier" value="<?= htmlspecialchars($unCavalier->getPrenomCavalier()) ?>" style="display:none;">
                    </td>
                    <td>
                        <span class="static-field"><?= htmlspecialchars($unCavalier->getDateNaissanceCavalier()) ?></span>
                        <input type="date" class="edit-field" name="datenaissancecavalier" value="<?= htmlspecialchars($unCavalier->getDateNaissanceCavalier()) ?>" style="display:none;">
                    </td>
                    <td>
                        <span class="static-field"><?= htmlspecialchars($unCavalier->getNomResponsable()) ?></span>
                        <input type="text" class="edit-field" name="nomresponsable" value="<?= htmlspecialchars($unCavalier->getNomResponsable()) ?>" style="display:none;">
                    </td>
                    <td>
                        <span class="static-field"><?= htmlspecialchars($unCavalier->getRueResponsable()) ?></span>
                        <input type="text" class="edit-field" name="rueresponsable" value="<?= htmlspecialchars($unCavalier->getRueResponsable()) ?>" style="display:none;">
                    </td>
                    <td>
                        <span class="static-field"><?= htmlspecialchars($unCavalier->getTelResponsable()) ?></span>
                        <input type="text" class="edit-field" name="telresponsable" value="<?= htmlspecialchars($unCavalier->getTelResponsable()) ?>" style="display:none;">
                    </td>
                    <td>
                        <span class="static-field"><?= htmlspecialchars($unCavalier->getEmailResponsable()) ?></span>
                        <input type="email" class="edit-field" name="emailresponsable" value="<?= htmlspecialchars($unCavalier->getEmailResponsable()) ?>" style="display:none;">
                    </td>
                    <td>
                        <span class="static-field"><?= htmlspecialchars($unCavalier->getNumLicence()) ?></span>
                        <input type="text" class="edit-field" name="numlicence" value="<?= htmlspecialchars($unCavalier->getNumLicence()) ?>" style="display:none;">
                    </td>
                    <td>
                        <span class="static-field"><?= htmlspecialchars($unCavalier->getNumAssurance()) ?></span>
                        <input type="text" class="edit-field" name="numassurance" value="<?= htmlspecialchars($unCavalier->getNumAssurance()) ?>" style="display:none;">
                    </td>
                    <td> 
                    <div class="content">
                        <div class="input_container">
                            <span class="static-field"><?= htmlspecialchars($unCavalier->getNomCommune()) ?></span>
                            <input type="text" class="edit-field" 
                                name="nom_idcommune21_<?= $unCavalier->getIdCavalier() ?>" 
                                id="nom_idcommune21_<?= $unCavalier->getIdCavalier() ?>" 
                                value="<?= htmlspecialchars($unCavalier->getNomCommune()) ?>" 
                                style="display:none;" 
                                onkeyup="autocompletcommune21('<?= $unCavalier->getIdCavalier() ?>')">
                            <input type="hidden" 
                                name="idcommune21" 
                                id="idcommune21_<?= $unCavalier->getIdCavalier() ?>" 
                                value="<?= $unCavalier->getIdCommune()->getIdCommune() ?>">
                            <ul id="nom_list_idcommune21_<?= $unCavalier->getIdCavalier() ?>" style="display:none;"></ul>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="content">
                        <div class="input_container">
                            <span class="static-field"><?= htmlspecialchars($unCavalier->getNomGalop()) ?></span>
                            <input type="text" class="edit-field" 
                                name="nom_idgalop22_<?= $unCavalier->getIdCavalier() ?>" 
                                id="nom_idgalop22_<?= $unCavalier->getIdCavalier() ?>" 
                                value="<?= htmlspecialchars($unCavalier->getNomGalop()) ?>" 
                                style="display:none;" 
                                onkeyup="autocompletgalop22('<?= $unCavalier->getIdCavalier() ?>')">
                            <input type="hidden" 
                                name="idgalop22" 
                                id="idgalop22_<?= $unCavalier->getIdCavalier() ?>" 
                                value="<?= $unCavalier->getIdGalop()->getIdGalop() ?>">
                            <ul id="nom_list_idgalop22_<?= $unCavalier->getIdCavalier() ?>" style="display:none;"></ul>
                        </div>
                    </div>
                </td>

                        <td>
                            <button class="modifier-btn" data-id="<?= $unCavalier->getIdCavalier() ?>">Modifier</button>
                            <form action="cavalier_traitement.php" method="POST" style="display:none;" class="edit-form">
                                <input type="hidden" name="action" value="modifier">
                                <input type="hidden" name="idcavalier" value="<?= $unCavalier->getIdCavalier() ?>">
                                <button type="submit" class="confirmer-btn" data-id="<?= $unCavalier->getIdCavalier() ?>">Confirmer</button>
                            </form>
                            <button class="annuler-btn" data-id="<?= $unCavalier->getIdCavalier() ?>" style="display:none;">Annuler</button>
                        </td>
                        <td>
                            <form action="cavalier_traitement.php" method="POST" style='all:unset' onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce cavalier ?');">
                                <input type="hidden" name="supprimer" value="<?= $unCavalier->getIdCavalier() ?>">
                                <input type="submit" value="Supprimer" class="delete-btn">
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
        // Initialisation de DataTable
        const table = $('#CavaliersTable').DataTable({
            stateSave: true,
            drawCallback: function() {
                attachEventHandlers();
            }
        });

        function attachEventHandlers() {
            // Gestion des boutons modifier
            $('.modifier-btn').off('click').on('click', function() {
                const row = $(this).closest('tr');
                row.find('.static-field').hide();
                row.find('.edit-field').show();
                $(this).hide();
                row.find('.edit-form').show();
                row.find('.annuler-btn').show();
            });

            // Gestion des boutons annuler
            $('.annuler-btn').off('click').on('click', function() {
                const row = $(this).closest('tr');
                row.find('.static-field').show();
                row.find('.edit-field').hide();
                row.find('.modifier-btn').show();
                row.find('.edit-form').hide();
                $(this).hide();
            });

            // Gestion de la soumission du formulaire de modification
            $('.edit-form').on('submit', function(e) {
                const row = $(this).closest('tr');
                // Ajout des valeurs des champs au formulaire avant soumission
                $(this).append(`
                    <input type="hidden" name="nomcavalier" value="${row.find('input[name="nomcavalier"]').val()}">
                    <input type="hidden" name="prenomcavalier" value="${row.find('input[name="prenomcavalier"]').val()}">
                    <input type="hidden" name="datenaissancecavalier" value="${row.find('input[name="datenaissancecavalier"]').val()}">
                    <input type="hidden" name="nomresponsable" value="${row.find('input[name="nomresponsable"]').val()}">
                    <input type="hidden" name="rueresponsable" value="${row.find('input[name="rueresponsable"]').val()}">
                    <input type="hidden" name="telresponsable" value="${row.find('input[name="telresponsable"]').val()}">
                    <input type="hidden" name="emailresponsable" value="${row.find('input[name="emailresponsable"]').val()}">
                    <input type="hidden" name="numlicence" value="${row.find('input[name="numlicence"]').val()}">
                    <input type="hidden" name="numassurance" value="${row.find('input[name="numassurance"]').val()}">
                    <input type="hidden" name="idcommune" value="${row.find('input[id^="idcommune21_"]').val()}">
                    <input type="hidden" name="idgalop" value="${row.find('input[id^="idgalop22_"]').val()}">
                `);
            });
        }

        // Modification du gestionnaire de suppression
        $(document).on('submit', 'form', function(e) {
            if ($(this).find('input[name="supprimer"]').length) {
                e.preventDefault();
                if (confirm('Êtes-vous sûr de vouloir supprimer ce cavalier ?')) {
                    const formData = new FormData(this);
                    
                    $.ajax({
                        url: 'cavalier_traitement.php',
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            try {
                                const data = JSON.parse(response);
                                if (data.success) {
                                    table.ajax.reload(null, false);
                                    alert('Suppression réussie');
                                } else {
                                    alert('Erreur lors de la suppression: ' + data.message);
                                }
                            } catch (e) {
                                console.error('Erreur:', e);
                                alert('Erreur lors du traitement de la réponse');
                            }
                        }
                    });
                }
            }
        });

        // Gestion des onglets
        $('.nav-btn').on('click', function() {
            // Retire la classe active de tous les boutons et sections
            $('.nav-btn').removeClass('active');
            $('.section').removeClass('active');
            
            // Ajoute la classe active au bouton cliqué
            $(this).addClass('active');
            
            // Affiche la section correspondante
            const target = $(this).data('target');
            $(`#${target}-section`).addClass('active');
        });
    });
</script>

</body>
</html>
