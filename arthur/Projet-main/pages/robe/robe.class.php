<?php
class Robe
{
    private $idrobe;
    private $librobe;

    function __construct($idrobe, $librobe)
    {
        $this->idrobe = $idrobe;
        $this->librobe = $librobe;
    }

    public function getIdRobe()
    {
        return $this->idrobe;
    }

    public function getLibRobe()
    {
        return $this->librobe;
    }

    public function setLibRobe($librobe)
    {
        $this->librobe = $librobe;
    }

    public function InsertRobe()
    {
        global $con;
       
        $data = [
            ':idc' => $this->idrobe,
            ':lr' => $this->librobe
        ];

        $sql = "INSERT INTO robe (idrobe, librobe,afficher) 
        VALUES (:idc, :lr,true);";
        $stmt = $con->prepare($sql);

        if ($stmt->execute($data)) {
            echo "Bien inséré";
            return $con->lastInsertId();
        } else {
            echo implode(", ", $stmt->errorInfo()); 
            return false;
        }
    }

    public function selectRobe()
    {
        global $con;
        $sql = "SELECT idrobe, librobe 
                FROM robe
                WHERE afficher = true";
        $req = $con->query($sql);
        $robes = [];

        foreach ($req->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $robe = new Robe($row['idrobe'], $row['librobe']);
            $robes[] = $robe;
        }

        return $robes;
    }

    public function DeleteRobe($id)
    {
        global $con;
        $data = [':id' => $id];
        $sql = "UPDATE robe SET afficher = false WHERE idrobe = :id";
        $stmt = $con->prepare($sql);

        if ($stmt->execute($data)) {
            echo "Suppression réussie";
            return true;
        } else {
            echo "Erreur lors de la suppression : " . implode(", ", $stmt->errorInfo());
            return false;
        }
    }

    public function UpdateRobe()
    {
        global $con;
        $data = [
            ':idc' => $this->idrobe,
            ':lr' => $this->librobe
        ];

        $sql = "UPDATE robe
                SET librobe = :lr                
                WHERE idrobe = :idc;";
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
