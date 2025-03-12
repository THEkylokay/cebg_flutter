<?php
class Race
{
    private $idrace;
    private $librace;

    function __construct($idrace, $librace)
    {
        $this->idrace = $idrace;
        $this->librace = $librace;
    }

    public function getIdRace()
    {
        return $this->idrace;
    }

    public function getLibRace()
    {
        return $this->librace;
    }

    public function setLibRace($librace)
    {
        $this->librace = $librace;
    }


    public function InsertRace()
    {
        global $con;
       
        $data = [
            ':idc' => $this->idrace,
            ':lr' => $this->librace
        ];

        $sql = "INSERT INTO race (idrace, librace,afficher) 
        VALUES (:idc, :lr, true);";
        $stmt = $con->prepare($sql);

        if ($stmt->execute($data)) {
            echo "Bien inséré";
            return $con->lastInsertId();
        } else {
            echo implode(", ", $stmt->errorInfo()); 
            return false;
        }
    }



    public function selectRace()
    {
        global $con;
        $sql = "SELECT idrace, librace 
                FROM race 
                WHERE afficher = true"; 
        $req = $con->query($sql);
        $races = [];

        foreach ($req->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $race = new Race($row['idrace'], $row['librace']);
            $races[] = $race;
        }

        return $races;
    }

    public function DeleteRace($id)
    {
        global $con;
        $data = [':id' => $id];
        $sql = "UPDATE  race SET afficher = false WHERE idrace = :id";
        $stmt = $con->prepare($sql);

        if ($stmt->execute($data)) {
            echo "Suppression réussie";
            return true;
        } else {
            echo "Erreur lors de la suppression : " . implode(", ", $stmt->errorInfo());
            return false;
        }
    }

    public function UpdateRace()
    {
        global $con;
        $data = [
            ':idc' => $this->idrace,
            ':lr' => $this->librace
        ];

        $sql = "UPDATE race
                SET librace = :lr                
                WHERE idrace = :idc;";
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
