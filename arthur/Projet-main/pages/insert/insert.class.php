<?php
class Inserer {
    private $idCours;
    private $idCavalier;

    function __construct($idCours, $idCavalier) {
        $this->idCours = $idCours;
        $this->idCavalier = $idCavalier;
    }

    public function getIdCours() {
        return $this->idCours;
    }

    public function getIdCavalier() {
        return $this->idCavalier;
    }

    public function setIdCours($idCours) {
        $this->idCours = $idCours;
    }

    public function setIdCavalier($idCavalier) {
        $this->idCavalier = $idCavalier;
    }

    public function InsertInserer() {
        global $con;

        $data = [
            ':idcours' => $this->idCours,
            ':idcavalier' => $this->idCavalier
        ];

        $sql = "INSERT INTO inserer (idcours, idcavalier, afficher) VALUES (:idcours, :idcavalier, true)";
        $stmt = $con->prepare($sql);

        try {
            if ($stmt->execute($data)) {
                return $con->lastInsertId();
            }
        } catch (PDOException $e) {
            // Gestion de l'exception pour les clés dupliquées
            if ($e->getCode() == 23000) { // Code d'erreur pour violation de contrainte d'intégrité
                $_SESSION['error_message'] = "Association déjà existante"; // Stocker le message dans la session
                header('Location: insert.php'); // Rediriger vers insert.php
                exit();
            } else {
                $_SESSION['error_message'] = "Erreur : " . $e->getMessage(); // Autres erreurs
                header('Location: insert.php'); // Rediriger vers insert.php
                exit();
            }
        }
    }

    public static function InsererAll() {
        global $con;

        $sql = "SELECT * FROM inserer WHERE afficher = true";
        $req = $con->query($sql);
        $inserers = [];

        foreach ($req->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $inserer = new Inserer(
                $row['idcours'],
                $row['idcavalier']
            );
            $inserers[] = $inserer;
        }

        return $inserers;
    }

    public function DeleteInserer($idCours, $idCavalier) {
        global $con;
        $data = [':idcours' => $idCours, ':idcavalier' => $idCavalier];
        $sql = "DELETE FROM inserer WHERE idcours = :idcours AND idcavalier = :idcavalier";
        $stmt = $con->prepare($sql);

        if ($stmt->execute($data)) {
            echo "Suppression réussie";
            return true;
        } else {
            echo "Erreur lors de la suppression : " . implode(", ", $stmt->errorInfo());
            return false;
        }
    }

    public function UpdateInserer() {
        global $con;
        $data = [
            ':idcours' => $this->idCours,
            ':idcavalier' => $this->idCavalier
        ];

        $sql = "UPDATE inserer
                SET idcavalier = :idcavalier
                WHERE idcours = :idcours";
        $stmt = $con->prepare($sql);

        if ($stmt->execute($data)) {
            echo "Bien modifié";
            return true;
        } else {
            echo implode(", ", $stmt->errorInfo());
            return false;
        }
    }
}
?>
