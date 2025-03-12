<?php

class Galop
{
    private $idgalop;
    private $libgalop;
    private $afficher;

    public function __construct($idgalop, $libgalop)
    {
        $this -> idgalop = $idgalop;
        $this -> libgalop = $libgalop;
        $this -> afficher = true;
    }

    public function getIdGalop()
    {
        return $this -> idgalop;
    }

    public function getLibGalop()
    {
        return $this -> libgalop;
    }

    public function setLibGalop($libgalop)
    {
        $this -> libgalop = $libgalop;
    }

    public function InsertGalop() {
        global $con;
        
        $sql = "INSERT INTO galop (libgalop, afficher) VALUES (:lg, true)";
        
        $stmt = $con->prepare($sql);
        $data = [':lg' => $this->libgalop];

        if ($stmt->execute($data)) {
            echo "Galop ajouté avec succès";
            return $con->lastInsertId();
        } else {
            echo "Erreur lors de l'ajout : " . implode(", ", $stmt->errorInfo());
            return false;
        }
    }

    public function UpdateGalop() {
        global $con;
        
        $sql = "UPDATE galop 
                SET libgalop = :lg 
                WHERE idgalop = :id 
                AND afficher = true";
        
        $stmt = $con->prepare($sql);
        $data = [
            ':id' => $this->idgalop,
            ':lg' => $this->libgalop
        ];

        if ($stmt->execute($data)) {
            echo "Galop modifié avec succès";
            return true;
        } else {
            echo "Erreur lors de la modification : " . implode(", ", $stmt->errorInfo());
            return false;
        }
    }

    public function DeleteGalop() {
        global $con;
        
        $sql = "UPDATE galop 
                SET afficher = false 
                WHERE idgalop = :id";
        
        $stmt = $con->prepare($sql);
        $data = [':id' => $this->idgalop];

        if ($stmt->execute($data)) {
            echo "Galop supprimé avec succès";
            return true;
        } else {
            echo "Erreur lors de la suppression : " . implode(", ", $stmt->errorInfo());
            return false;
        }
    }

    public function GalopAll() {
        global $con;
        
        $sql = "SELECT * FROM galop WHERE afficher = true ORDER BY idgalop";
        $stmt = $con->query($sql);
        
        $galops = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $galops[] = new Galop(
                $row['idgalop'],
                $row['libgalop']
            );
        }
        
        return $galops;
    }
}

?>