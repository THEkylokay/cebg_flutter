<?php
class Cavalier
{
    private $idCavalier;
    private $nomCavalier;
    private $prenomCavalier;
    private $dateNaissanceCavalier;
    private $nomResponsable;
    private $rueResponsable;
    private $telResponsable;
    private $emailResponsable;
    private $password;
    private $numLicence;
    private $numAssurance;
    private $idCommune;
    private $idGalop;
    private $nomCommune;
    private $nomGalop;

    function __construct($idCavalier, $nomCavalier, $prenomCavalier, $dateNaissanceCavalier, $nomResponsable, $rueResponsable, $telResponsable, $emailResponsable, $password, $numLicence, $numAssurance, $idCommune, $idGalop)
    {
        $this->idCavalier = $idCavalier;
        $this->nomCavalier = $nomCavalier;
        $this->prenomCavalier = $prenomCavalier;
        $this->dateNaissanceCavalier = $dateNaissanceCavalier;
        $this->nomResponsable = $nomResponsable;
        $this->rueResponsable = $rueResponsable;
        $this->telResponsable = $telResponsable;
        $this->emailResponsable = $emailResponsable;
        $this->password = $password;
        $this->numLicence = $numLicence;
        $this->numAssurance = $numAssurance;
        $this->idCommune = $idCommune;
        $this->idGalop = $idGalop;
    }

    public function getIdCavalier()
    {
        return $this->idCavalier;
    }

    public function getNomCavalier()
    {
        return $this->nomCavalier;
    }

    public function setNomCavalier($nomCavalier)
    {
        $this->nomCavalier = $nomCavalier;
    }

    public function getPrenomCavalier()
    {
        return $this->prenomCavalier;
    }

    public function setPrenomCavalier($prenomCavalier)
    {
        $this->prenomCavalier = $prenomCavalier;
    }

    public function getDateNaissanceCavalier()
    {
        return $this->dateNaissanceCavalier;
    }

    public function setDateNaissanceCavalier($dateNaissanceCavalier)
    {
        $this->dateNaissanceCavalier = $dateNaissanceCavalier;
    }

    public function getNomResponsable()
    {
        return $this->nomResponsable;
    }

    public function setNomResponsable($nomResponsable)
    {
        $this->nomResponsable = $nomResponsable;
    }

    public function getRueResponsable()
    {
        return $this->rueResponsable;
    }

    public function setRueResponsable($rueResponsable)
    {
        $this->rueResponsable = $rueResponsable;
    }

    public function getTelResponsable()
    {
        return $this->telResponsable;
    }

    public function setTelResponsable($telResponsable)
    {
        $this->telResponsable = $telResponsable;
    }

    public function getEmailResponsable()
    {
        return $this->emailResponsable;
    }

    public function setEmailResponsable($emailResponsable)
    {
        $this->emailResponsable = $emailResponsable;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getNumLicence()
    {
        return $this->numLicence;
    }

    public function setNumLicence($numLicence)
    {
        $this->numLicence = $numLicence;
    }

    public function getNumAssurance()
    {
        return $this->numAssurance;
    }

    public function setNumAssurance($numAssurance)
    {
        $this->numAssurance = $numAssurance;
    }

    public function getIdCommune()
    {
        return $this->idCommune;
    }

    public function setIdCommune($idCommune)
    {
        $this->idCommune = $idCommune;
    }

    public function getIdGalop()
    {
        return $this->idGalop;
    }

    public function setIdGalop($idGalop)
    {
        $this->idGalop = $idGalop;
    }

    public function getNomCommune()
    {
        return $this->nomCommune;
    }

    public function setNomCommune($nomCommune)
    {
        $this->nomCommune = $nomCommune;
    }

    public function getNomGalop()
    {
        return $this->nomGalop;
    }

    public function setNomGalop($nomGalop)
    {
        $this->nomGalop = $nomGalop;
    }

    public function InsertCavalier()
    {
        global $con;
        global $session_idcompte;



        $data = [
            ':nc' => $this->nomCavalier,
            ':pc' => $this->prenomCavalier,
            ':dnc' => $this->dateNaissanceCavalier,
            ':nr' => $this->nomResponsable,
            ':rr' => $this->rueResponsable,
            ':tr' => $this->telResponsable,
            ':er' => $this->emailResponsable,
            ':pw' => $this->password,
            ':nl' => $this->numLicence,
            ':na' => $this->numAssurance,
            ':idc' => $this->idCommune->getIdCommune(),
            ':idg' => $this->idGalop->getIdGalop()
        ];

        $sql = "INSERT INTO cavalier (idcavalier, nomcavalier, prenomcavalier, datenaissancecavalier, nomresponsable, rueresponsable, telresponsable, emailresponsable, password, numlicence, numassurance, idcommune, idgalop, afficher, iduser) 
                VALUES (null, :nc, :pc, :dnc, :nr, :rr, :tr, :er, :pw, :nl, :na, :idc, :idg,true,$session_idcompte);";
        $stmt = $con->prepare($sql);

        if ($stmt->execute($data)) {
            echo "Bien inséré";
            return $con->lastInsertId();
        } else {
            echo implode(", ", $stmt->errorInfo());
            return false;
        }
    }

    public function CavalierAll() 
    {
        global $con;

        // Requête SQL avec jointure pour inclure les données de la table commune
        $sql = "SELECT cavalier.idcavalier, cavalier.nomcavalier, cavalier.prenomcavalier, cavalier.datenaissancecavalier, 
                    cavalier.nomresponsable, cavalier.rueresponsable, cavalier.telresponsable, cavalier.emailresponsable, 
                    cavalier.numlicence, cavalier.numassurance, cavalier.idcommune, cavalier.idgalop, commune.ville AS nomcommune, galop.libgalop AS nomGalop
                FROM cavalier 
                JOIN commune ON cavalier.idcommune = commune.idcommune
                JOIN galop ON cavalier.idgalop = galop.idgalop
                WHERE cavalier.afficher = true";
                
        $req = $con->query($sql);
        $cavaliers = [];

        foreach ($req->fetchAll(PDO::FETCH_ASSOC) as $row) {
            // Construction de l'objet Cavalier avec les données de la base
            $commune = new Commune($row['idcommune'], $row['nomcommune'], null);
            $galop = new Galop($row['idgalop'], $row['nomGalop']);    
            $cavalier = new Cavalier(
                $row['idcavalier'], 
                $row['nomcavalier'], 
                $row['prenomcavalier'], 
                $row['datenaissancecavalier'], 
                $row['nomresponsable'], 
                $row['rueresponsable'], 
                $row['telresponsable'], 
                $row['emailresponsable'], 
                null,
                $row['numlicence'], 
                $row['numassurance'], 
                $commune,  // Objet Commune
                $galop    // Objet Galop
            );
            // Associer également le nom de la commune si souhaité
            $cavalier->nomCommune = $row['nomcommune'];
            $cavalier->nomGalop = $row['nomGalop'];

            $cavaliers[] = $cavalier;
        }

        return $cavaliers;
    }



    public function DeleteCavalier($id)
    {
        global $con;
        $data = [':id' => $id];
        $sql = "UPDATE  cavalier SET afficher = false WHERE idcavalier = :id";
        $stmt = $con->prepare($sql);

        if ($stmt->execute($data)) {
            echo "Suppression réussie";
            return true;
        } else {
            echo "Erreur lors de la suppression : " . implode(", ", $stmt->errorInfo());
            return false;
        }
    }


    public function UpdateCavalier()
    {
        global $con;
        $data = [
            ':idcav' => $this->idCavalier,
            ':nc' => $this->nomCavalier,
            ':pc' => $this->prenomCavalier,
            ':dnc' => $this->dateNaissanceCavalier,
            ':nr' => $this->nomResponsable,
            ':rr' => $this->rueResponsable,
            ':tr' => $this->telResponsable,
            ':er' => $this->emailResponsable,
            ':pw' => $this->password,
            ':nl' => $this->numLicence,
            ':na' => $this->numAssurance,
            ':idc' => $this->idCommune,
            ':idg' => $this->idGalop
        ];

        $sql = "UPDATE cavalier	
                SET nomcavalier = :nc, prenomcavalier = :pc, datenaissancecavalier = :dnc, nomresponsable = :nr, rueresponsable = :rr, telresponsable = :tr, emailresponsable = :er, password = :pw, numlicence = :nl, numassurance = :na, idcommune = :idc, idgalop = :idg
                WHERE idcavalier = :idcav;";
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
