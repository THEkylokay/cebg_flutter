<?php
class Photo {
    private $idphoto;

    private $nom_photo;
    private $lien;
    private $numsire;
    private $idevenement;
    

    public function __construct() {
  
    }

    // Getters et Setters
    public function getIdPhoto() { return $this->idphoto; }
    public function getnom_photo() { return $this->nom_photo; }
    public function getLien() { return $this->lien; }
    public function getNumSire() { return $this->numsire; }
    public function getIdEvenement() { return $this->idevenement; }

    public function setIdPhoto($idphoto) { $this->idphoto = $idphoto; }
    public function setnom_photo($nom_photo) { $this->nom_photo = $nom_photo; }
    public function setLien($lien) { $this->lien = $lien; }
    public function setNumSire($numsire) { $this->numsire = $numsire; }
    public function setIdEvenement($idevenement) { $this->idevenement = $idevenement; }

    // Nouvelle méthode pour sauvegarder uniquement le lien
    public function saveLink() {
        global $con;
        $data = [
            ':nom_photo' => $this->nom_photo,
            ':lien' => $this->lien,
            ':numsire' => $this->numsire,
            ':idevenement' => $this->idevenement,
        ];

        $sql = "INSERT INTO photo (nom_photo, lien, numsire, idevenement) 
                VALUES (:nom_photo, :lien, :numsire, :idevenement)";
        
        $stmt = $con->prepare($sql);
        
        if ($stmt->execute($data)) {
            return true;
        } else {
            error_log("Erreur lors de l'insertion de la photo: " . implode(", ", $stmt->errorInfo()));
            return false;
        }
    }

    public function getPhotoByNumSire($numsire = 0) {
        try {
            global $con;
            $sql = "SELECT * FROM photo";
            if ($numsire !== 0) {
                $sql .= " WHERE numsire = :numsire";
            }
            $stmt = $con->prepare($sql);
            if ($numsire !== 0) {
                $stmt->bindParam(':numsire', $numsire);
            }
            $stmt->execute();
            $photos = [];
            
            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $photo = new Photo();
                $photo->setIdPhoto($row['idphoto']);
                $photo->setnom_photo($row['nom_photo']);
                $photo->setLien($row['lien']);
                $photo->setNumSire($row['numsire']);
                $photo->setIdEvenement($row['idevenement']);
                $photos[] = $photo;
            }
            return $photos;
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des photos: " . $e->getMessage());
            return false;
        }
    }

    public function update() {
        global $con;
        $sql = "UPDATE photo SET nom_photo = :nom_photo,  lien = :lien, numsire = :numsire, idevenement = :idevenement WHERE idphoto = :idphoto";
        $stmt = $this->$con->prepare($sql);
        $data = [
            ':nom_photo' => $this->nom_photo,
            ':lien' => $this->lien,
            ':numsire' => $this->numsire,
            ':idevenement' => $this->idevenement,
            ':idphoto' => $this->idphoto
        ];
        return $stmt->execute($data);
    }

    public function delete() {
        if (file_exists($this->lien)) {
            unlink($this->lien);
        }
        global $con;
        $sql = "DELETE FROM photo WHERE idphoto = :idphoto";
        $stmt = $this->$con->prepare($sql);
        return $stmt->execute([':idphoto' => $this->idphoto]);
    }

    public function updateNumSire($idphoto, $numsire) {
        try {
            global $con;
            // Mettre à jour l'ancien numsire à 0
            $sql1 = "UPDATE photo SET numsire = 0 WHERE numsire = :numsire";
            $stmt1 = $con->prepare($sql1);
            $stmt1->execute([':numsire' => $numsire]);

            // Mettre à jour la photo sélectionnée avec le nouveau numsire
            $sql2 = "UPDATE photo SET numsire = :numsire WHERE idphoto = :idphoto";
            $stmt2 = $con->prepare($sql2);
            return $stmt2->execute([
                ':numsire' => $numsire,
                ':idphoto' => $idphoto
            ]);
        } catch (PDOException $e) {
            error_log("Erreur lors de la mise à jour du numsire: " . $e->getMessage());
            return false;
        }
    }

    public function getPhotoById($idphoto) {
        try {
            global $con;
            $sql = "SELECT * FROM photo WHERE idphoto = :idphoto";
            $stmt = $con->prepare($sql);
            $stmt->execute([':idphoto' => $idphoto]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération de la photo: " . $e->getMessage());
            return false;
        }
    }

    public function afficherPhoto() {
        return "<div class='photo-container'>
                    <img src='{$this->lien}' alt='{$this->nom_photo}' style='max-width: 300px; height: auto;'>
                    <p>Nom: {$this->nom_photo}</p>
                    <p>NumSire: {$this->numsire}</p>
                </div>";
    }
}
?>
