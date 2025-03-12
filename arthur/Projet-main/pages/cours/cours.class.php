<?php

class Cours
{
    private $idCours;
    private $libCours;
    private $horaireDebut;
    private $horaireFin;
    private $jour; 

    function __construct($idCours, $libCours, $horaireDebut, $horaireFin, $jour)
    {
        $this->idCours = $idCours;
        $this->libCours = $libCours;
        $this->horaireDebut = $horaireDebut;
        $this->horaireFin = $horaireFin;
        $this->jour = $jour;
    }

    public function getIdCours()
    {
        return $this->idCours;
    }

    public function getLibCours()
    {
        return $this->libCours;
    }

    public function setLibCours($libCours)
    {
        $this->libCours = $libCours;
    }

    public function getHoraireDebut()
    {
        return $this->horaireDebut;
    }

    public function setHoraireDebut($horaireDebut)
    {
        $this->horaireDebut = $horaireDebut;
    }

    public function getHoraireFin()
    {
        return $this->horaireFin;
    }

    public function setHoraireFin($horaireFin) {
        $this->horaireFin = $horaireFin;
    }

    public function getJour()
    {
        return $this->jour;
    }

    public function setJour($jour)
    {
        $this->jour = $jour;
    }

    public function InsertCours($date)
    {
        global $con;
        
        // Convertir l'heure début et fin en timestamp SQL
        $dateDebut = $date . ' ' . $this->horaireDebut . ':00';
        $dateFin = $date . ' ' . $this->horaireFin . ':00';
        
        $data = [   
            ':lc' => $this->libCours,
            ':hd' => $dateDebut,
            ':hf' => $dateFin,
            ':j' => $this->jour
        ];

        $sql = "INSERT INTO cours (idcours, libcours, horairedebut, horairefin, jour, afficher) 
        VALUES (null, :lc, :hd, :hf, :j, true);";
        $stmt = $con->prepare($sql);

        if ($stmt->execute($data)) {
            return $con->lastInsertId();
        } else {
            return false;
        }
    }

    public function selectCours()
    {
        global $con;
        $sql = "SELECT idcours, libcours, horairedebut, horairefin, jour 
                FROM cours
                WHERE afficher = true";
        $req = $con->query($sql);
        $cours = [];

        foreach ($req->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $cour = new Cours($row['idcours'], $row['libcours'], $row['horairedebut'], $row['horairefin'], $row['jour']);
            $cours[] = $cour;
        }

        return $cours;
    }

    public function DeleteCours($id)
    {
        global $con;
        $data = [':id' => $id];
        $sql = "UPDATE  cours SET afficher = false WHERE idcours = :id";
        $stmt = $con->prepare($sql);

        return $stmt->execute($data);
    }

    public function UpdateCours()
    {
        global $con;
        $data = [
            ':idc' => $this->idCours,
            ':lc' => $this->libCours,
            ':hd' => $this->horaireDebut,
            ':hf' => $this->horaireFin,
            ':j' => $this->jour
        ];

        $sql = "UPDATE cours    
                SET libcours = :lc, horairedebut = :hd, horairefin = :hf, jour = :j
                WHERE idcours = :idc;";
        $stmt = $con->prepare($sql);

        return $stmt->execute($data);
    }
}

?>
