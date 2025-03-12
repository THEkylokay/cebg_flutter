<?php

class Commune
{
    private $idcommune;
    private $ville;
    private $codepostal;

    public function __construct($idcommune, $ville, $codepostal)
    {
        $this->idcommune = $idcommune;
        $this->ville = $ville;
        $this->codepostal = $codepostal;
    }

    public function getIdCommune()
    {
        return $this->idcommune;
    }

    public function getVille()
    {
        return $this->ville;
    }

    public function getCodePostal()
    {
        return $this->codepostal;
    }

    public function setVille($ville)
    {
        $this->ville = $ville;
    }

    public function setCodePostal($codepostal)
    {
        $this->codepostal = $codepostal;
    }

    public function selectCommune()
    {
        global $con;
        $sql = "SELECT idcommune, ville, codepostal FROM commune WHERE afficher = true";
        $req = $con->query($sql);
        $communes = [];

        foreach ($req->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $commune = new Commune($row['idcommune'], $row['ville'], $row['codepostal']);
            $communes[] = $commune;
        }

        return $communes;
    }

    public function InsertCommune()
    {
        global $con;
        $data = [
            ':ville' => $this->ville,
            ':codepostal' => $this->codepostal
        ];

        $sql = "INSERT INTO commune (idcommune, ville, codepostal, afficher) VALUES (null, :ville, :codepostal, true)";
        $stmt = $con->prepare($sql);

        if ($stmt->execute($data)) {
            return $con->lastInsertId();
        } else {
            return false;
        }
    }

    public function UpdateCommune()
    {
        global $con;
        $data = [
            ':idcommune' => $this->idcommune,
            ':ville' => $this->ville,
            ':codepostal' => $this->codepostal
        ];

        $sql = "UPDATE commune SET ville = :ville, codepostal = :codepostal WHERE idcommune = :idcommune";
        $stmt = $con->prepare($sql);

        return $stmt->execute($data);
    }

    public function DeleteCommune($id)
    {
        global $con;
        $data = [':id' => $id];
        $sql = "UPDATE commune SET afficher = false WHERE idcommune = :id";
        $stmt = $con->prepare($sql);

        return $stmt->execute($data);
    }
}