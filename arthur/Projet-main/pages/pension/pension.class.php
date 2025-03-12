<?php

class Pension
{
    private $idpension;
    private $libpension;
    private $tarifpension;
    private $datedebut;
    private $datefin;
    private $numsire;
    private $afficher;
    private $nomCheval;

    public function __construct($idpension, $libpension, $tarifpension, $datedebut, $datefin, $numsire) {
        $this->idpension = $idpension;
        $this->libpension = $libpension;
        $this->tarifpension = $tarifpension;
        $this->datedebut = $datedebut;
        $this->datefin = $datefin;
        $this->numsire = $numsire;
        $this->afficher = true;
        if ($this->numsire) {
            $this->loadCheval();
        }
    }

    private function loadCheval() {
        global $con;
        $sql = "SELECT nomcheval FROM cavalerie WHERE numsire = :sire AND afficher = true";
        $stmt = $con->prepare($sql);
        $stmt->execute([':sire' => $this->numsire]);
        if ($row = $stmt->fetch()) {
            $this->nomCheval = $row['nomcheval'];
        }
    }

    public function getNomCheval() {
        if (!isset($this->nomCheval)) {
            $this->loadCheval();
        }
        return $this->nomCheval;
    }

    // Getters
    public function getIdPension() { return $this->idpension; }
    public function getLibPension() { return $this->libpension; }
    public function getTarifPension() { return $this->tarifpension; }
    public function getDateDebut() { return $this->datedebut; }
    public function getDateFin() { return $this->datefin; }
    public function getNumSire() { return $this->numsire; }

    // Setters
    public function setLibPension($libpension) { $this->libpension = $libpension; }
    public function setTarifPension($tarifpension) { $this->tarifpension = $tarifpension; }
    public function setDateDebut($datedebut) { $this->datedebut = $datedebut; }
    public function setDateFin($datefin) { $this->datefin = $datefin; }
    public function setNumSire($numsire) { $this->numsire = $numsire; }

    public function InsertPension() {
        global $con;
        
        $sql = "INSERT INTO pension (libpension, tarifpension, datedebut, datefin, numsire, afficher) 
                VALUES (:lib, :tarif, :debut, :fin, :sire, true)";
        
        $stmt = $con->prepare($sql);
        $data = [
            ':lib' => $this->libpension,
            ':tarif' => $this->tarifpension,
            ':debut' => $this->datedebut,
            ':fin' => $this->datefin,
            ':sire' => $this->numsire
        ];

        if ($stmt->execute($data)) {
            echo "Pension ajoutée avec succès";
            return $con->lastInsertId();
        } else {
            echo "Erreur lors de l'ajout : " . implode(", ", $stmt->errorInfo());
            return false;
        }
    }

    public function UpdatePension() {
        global $con;
        
        $sql = "UPDATE pension 
                SET libpension = :lib,
                    tarifpension = :tarif,
                    datedebut = :debut,
                    datefin = :fin,
                    numsire = :sire
                WHERE idpension = :id 
                AND afficher = true";
        
        $stmt = $con->prepare($sql);
        $data = [
            ':id' => $this->idpension,
            ':lib' => $this->libpension,
            ':tarif' => $this->tarifpension,
            ':debut' => $this->datedebut,
            ':fin' => $this->datefin,
            ':sire' => $this->numsire
        ];

        if ($stmt->execute($data)) {
            echo "Pension modifiée avec succès";
            return true;
        } else {
            echo "Erreur lors de la modification : " . implode(", ", $stmt->errorInfo());
            return false;
        }
    }

    public function DeletePension() {
        global $con;
        
        $sql = "UPDATE pension 
                SET afficher = false 
                WHERE idpension = :id";
        
        $stmt = $con->prepare($sql);
        $data = [':id' => $this->idpension];

        if ($stmt->execute($data)) {
            echo "Pension supprimée avec succès";
            return true;
        } else {
            echo "Erreur lors de la suppression : " . implode(", ", $stmt->errorInfo());
            return false;
        }
    }

    public function PensionAll() {
        global $con;
        
        $sql = "SELECT * FROM pension WHERE afficher = true ORDER BY idpension";
        $stmt = $con->query($sql);
        
        $pensions = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pensions[] = new Pension(
                $row['idpension'],
                $row['libpension'],
                $row['tarifpension'],
                $row['datedebut'],
                $row['datefin'],
                $row['numsire']
            );
        }
        
        return $pensions;
    }
}

?>