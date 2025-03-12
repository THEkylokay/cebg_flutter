<?php
require_once __DIR__ . '../../../includes/bdd.inc.php';

function securisation($donnee) {
    return htmlspecialchars(trim(stripslashes($donnee)));
}

if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["email"])) {
    $username = securisation($_POST['username']);
    $password = securisation($_POST['password']);
    $email = securisation($_POST['email']);

    if (empty($username) || empty($password) || empty($email)) {
        echo "<script type='text/javascript'>
                alert('Veuillez remplir tous les champs.');
                window.history.back();
              </script>";
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $requete = $con->prepare("INSERT INTO compte (email, pseudo, mdp) VALUES (:email, :pseudo, :mdp)");
    $requete->bindParam(':pseudo', $username);
    $requete->bindParam(':mdp', $hashed_password);
    $requete->bindParam(':email', $email);
    $result = $requete->execute();

    if ($result) {
        echo "<script type='text/javascript'>
                alert('Compte créé avec succès.');
                window.location = '../connexion/connexion.php';
              </script>";
    } else {
        echo "<script type='text/javascript'>
                alert('Erreur de création de compte');
              </script>";
    }
} else {
    echo "<script type='text/javascript'>
            alert('Veuillez remplir tous les champs.');
          </script>";
}
?>
