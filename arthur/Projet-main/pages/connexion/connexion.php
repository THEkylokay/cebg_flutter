<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Se connecter</title>
    <link rel="stylesheet" href="../../css/connexion.css">
</head>
<body>
    <div class="container">
        <h2>Se connecter</h2>
        <form method="post" action="connexion_traitement.php" class="login-form">
            Email: <input type="mail" name="email" id="email_connexion" class="input-connexion" required ><br>
            Pseudo: <input type="text" name="pseudo" id="pseudo_connexion" class="input-connexion" required ><br>
            Mot de passe: <input type="password" name="password" id="mdp_connexion" class="input-connexion" required ><br>
            <label>
                <input type="checkbox" name="remember_me"> Se souvenir de moi
            </label><br>
            <input type="submit" name="login" class="btn-submit-connexion" value="Se connecter">
            <a href="../creation/creation.php"><div class="btn-create-account">
                Pas de compte ? Créez-en un
            </div></a>
        </form>
    </div>
    
</body>
</html>
