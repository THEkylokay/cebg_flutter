<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un compte</title>
    <link rel="stylesheet" href="../../css/connexion.css">
</head>
<body>
    <div class="container">
        <h2>Créer un compte</h2>
        <form method="post" action="creation_traitement.php" class="form-generic">
            Email :<input type="mail" name="email" id="email_connexion" class="input-connexion" required><br>
            Pseudo :<input type="text" name="username" id="pseudo_connexion" class="input-connexion" required><br>
            Mot de passe :<input type="password" name="password" id="mdp_connexion" class="input-connexion" required><br>
            <input type="submit" name="boutton" class="btn-submit-connexion" value="Créer un compte">
        </form>
        <a href="../connexion/connexion.php"><div class="btn-create-account">
            Déjà un compte ? Connectez-vous
        </div>
        </a>
    </div>
</body>
</html>