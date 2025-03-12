<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Pensions par Cavalier</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
</head>
<body>
<?php
include '../../includes/haut.inc.php';
$prend = new Prend(null, null);
$allPrends = $prend->PrendAll();

// Pour les selects
$cavalier = new Cavalier(null, null, null, null, null, null, null, null, null, null, null, null, null);
$allCavaliers = $cavalier->CavalierAll();

$pension = new Pension(null, null, null, null, null, null);
$allPensions = $pension->PensionAll();
?>

<div class="container mt-4">
    <h2>Gestion des Associations Cavalier-Pension</h2>

    <!-- Messages d'alerte -->
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <?php 
            if ($_GET['success'] == 1) echo "Association ajoutée avec succès";
            if ($_GET['success'] == 2) echo "Association supprimée avec succès";
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            <?php 
            if ($_GET['error'] == 1) echo "Erreur lors de l'ajout de l'association";
            if ($_GET['error'] == 2) echo "Erreur lors de la suppression de l'association";
            ?>
        </div>
    <?php endif; ?>

    <!-- Formulaire d'ajout -->
    <div class="card mb-4">
        <div class="card-header">
            <h4>Nouvelle Association</h4>
        </div>
        <div class="card-body">
            <form action="prend_traitement.php" method="POST">
                <input type="hidden" name="action" value="ajouter">
                
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="idcavalier">Cavalier</label>
                            <select class="form-control" name="idcavalier" required>
                                <option value="">Sélectionner un cavalier</option>
                                <?php foreach($allCavaliers as $cav): ?>
                                    <option value="<?= $cav->getIdCavalier() ?>">
                                        <?= htmlspecialchars($cav->getNomCavalier() . ' ' . $cav->getPrenomCavalier()) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="idpension">Pension</label>
                            <select class="form-control" name="idpension" required>
                                <option value="">Sélectionner une pension</option>
                                <?php foreach($allPensions as $pen): ?>
                                    <option value="<?= $pen->getIdPension() ?>">
                                        <?= htmlspecialchars($pen->getLibPension() . ' - ' . $pen->getNomCheval()) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary form-control">Ajouter</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tableau des associations existantes -->
    <div class="card">
        <div class="card-header">
            <h4>Associations Existantes</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Cavalier</th>
                            <th>Pension</th>
                            <th>Cheval</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($allPrends as $p): ?>
                            <tr>
                                <td><?= htmlspecialchars($p->getNomCavalier() . ' ' . $p->getPrenomCavalier()) ?></td>
                                <td><?= htmlspecialchars($p->getLibPension()) ?></td>
                                <td><?= htmlspecialchars($p->getNomCheval()) ?></td>
                                <td>
                                    <form action="prend_traitement.php" method="POST" style="display: inline;">
                                        <input type="hidden" name="action" value="supprimer">
                                        <input type="hidden" name="idcavalier" value="<?= $p->getIdCavalier() ?>">
                                        <input type="hidden" name="idpension" value="<?= $p->getIdPension() ?>">
                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette association ?')">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($allPrends)): ?>
                            <tr>
                                <td colspan="4" class="text-center">Aucune association trouvée</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html> 