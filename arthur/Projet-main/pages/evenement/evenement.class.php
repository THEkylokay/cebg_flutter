<?php

class Evenement
{
    private $idEvenement;
    private $titreEvenement;
    private $commentaire;

    public function __construct($idEvenement, $titreEvenement, $commentaire)
    {
        $this->idEvenement = $idEvenement;
        $this->titreEvenement = $titreEvenement;
        $this->commentaire = $commentaire;
    }

    public function getIdEvenement()
    {
        return $this->idEvenement;
    }

    public function getTitreEvenement()
    {
        return $this->titreEvenement;
    }

    public function getCommentaire()
    {
        return $this->commentaire;
    }

    public function setTitreEvenement($titreEvenement)
    {
        $this->titreEvenement = $titreEvenement;
    }

    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;
    }

    public function InsertEvenement()
    {
        global $con;
        $data = [
            ':te' => $this->titreEvenement,
            ':c' => $this->commentaire
        ];

        $sql = "INSERT INTO evenement (titreevenement, commentaire) VALUES (:te, :c)";
        $stmt = $con->prepare($sql);
        return $stmt->execute($data);
    }

    public function UpdateEvenement()
    {
        global $con;
        $data = [
            ':id' => $this->idEvenement,
            ':te' => $this->titreEvenement,
            ':c' => $this->commentaire
        ];

        $sql = "UPDATE evenement SET titreevenement = :te, commentaire = :c WHERE idevenement = :id";
        $stmt = $con->prepare($sql);
        return $stmt->execute($data);
    }

    public function DeleteEvenement($id)
    {
        global $con;
        $data = [':id' => $id];
        $sql = "DELETE FROM evenement WHERE idevenement = :id";
        $stmt = $con->prepare($sql);
        return $stmt->execute($data);
    }

    public static function selectEvenements()
    {
        global $con;
        $sql = "SELECT * FROM evenement";
        $stmt = $con->query($sql);
        
        $evenements = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $evenement = new Evenement(
                $row['idevenement'],
                $row['titreevenement'],
                $row['commentaire']
            );
            $evenements[] = $evenement;
        }
        
        return $evenements;
    }
}
?>
