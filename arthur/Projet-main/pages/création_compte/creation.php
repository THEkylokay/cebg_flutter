<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un compte</title>
      <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Créer un compte</h2>
        <form method="post" action="creation_traitement.php">
            <input type="mail" name="email" placeholder="Email" required><br>
            <input type="text" name="username" placeholder="Nom d'utilisateur" required><br>
            <input type="password" name="password" placeholder="Mot de passe" required><br>
            <input type="submit" name="boutton" value="Créer un compte">
        </form>
        <a href="">Si vous avez déjà un compte</a>
    </div>
</body>
</html>