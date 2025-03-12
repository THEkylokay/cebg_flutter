<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Si la requête est une requête OPTIONS, terminer ici
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$host = "localhost";
$user = "root";
$password = ""; 
$dbname = "cebg";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);
        
        // Vérifier si les données JSON ont été correctement décodées
        if ($data === null) {
            throw new Exception("Erreur de décodage JSON");
        }

        // Gestion de la connexion
        if (isset($data['action']) && $data['action'] === 'login') {
            if (!isset($data['email']) || !isset($data['password'])) {
                echo json_encode([
                    "success" => false, 
                    "error" => "Email et mot de passe requis"
                ]);
                exit;
            }

            $stmt = $conn->prepare("SELECT idcavalier, password FROM cavalier WHERE emailresponsable = :email AND afficher = 1");
            $stmt->bindParam(':email', $data['email']);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if (password_verify($data['password'], $user['password'])) {
                    echo json_encode([
                        "success" => true,
                        "message" => "Connexion réussie",
                        "user" => [
                            "id" => $user['idcavalier']
                        ]
                    ]);
                } else {
                    echo json_encode([
                        "success" => false, 
                        "error" => "Mot de passe incorrect"
                    ]);
                }
            } else {
                echo json_encode([
                    "success" => false, 
                    "error" => "Email non trouvé"
                ]);
            }
            exit;
        }

        // Gestion de l'inscription
        if (isset($data['action']) && $data['action'] === 'register') {
            // Vérification des champs requis
            $requiredFields = [
                'nomcavalier', 
                'prenomcavalier', 
                'datenaissancecavalier',
                'nomresponsable', 
                'rueresponsable', 
                'telresponsable',
                'emailresponsable', 
                'password', 
                'numlicence',
                'numassurance', 
                'idcommune', 
                'idgalop'
            ];

            foreach ($requiredFields as $field) {
                if (!isset($data[$field]) || empty($data[$field])) {
                    echo json_encode([
                        "success" => false, 
                        "error" => "Champ manquant ou vide: $field"
                    ]);
                    exit;
                }
            }

            // Vérifier si l'email existe déjà
            $stmt = $conn->prepare("SELECT idcavalier FROM cavalier WHERE emailresponsable = :email");
            $stmt->bindParam(':email', $data['emailresponsable']);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                echo json_encode([
                    "success" => false, 
                    "error" => "Cet email existe déjà"
                ]);
                exit;
            }

            // Vérifier si la commune existe
            $stmt = $conn->prepare("SELECT idcommune FROM commune WHERE idcommune = :idcommune");
            $stmt->bindParam(':idcommune', $data['idcommune']);
            $stmt->execute();
            
            if ($stmt->rowCount() == 0) {
                echo json_encode([
                    "success" => false, 
                    "error" => "Commune invalide"
                ]);
                exit;
            }

            // Vérifier si le galop existe
            $stmt = $conn->prepare("SELECT idgalop FROM galop WHERE idgalop = :idgalop");
            $stmt->bindParam(':idgalop', $data['idgalop']);
            $stmt->execute();
            
            if ($stmt->rowCount() == 0) {
                echo json_encode([
                    "success" => false, 
                    "error" => "Galop invalide"
                ]);
                exit;
            }

            // Hashage du mot de passe
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

            // Insertion du nouveau cavalier
            $stmt = $conn->prepare("
                INSERT INTO cavalier (
                    nomcavalier, 
                    prenomcavalier, 
                    datenaissancecavalier, 
                    nomresponsable, 
                    rueresponsable, 
                    telresponsable, 
                    emailresponsable, 
                    password, 
                    numlicence, 
                    numassurance, 
                    idcommune, 
                    idgalop, 
                    afficher,
                    iduser
                ) VALUES (
                    :nom, 
                    :prenom, 
                    :datenaissance, 
                    :nomresp, 
                    :rueresp, 
                    :telresp, 
                    :emailresp, 
                    :password, 
                    :numlicence, 
                    :numassurance, 
                    :idcommune, 
                    :idgalop, 
                    1,
                    1
                )
            ");

            try {
                $stmt->execute([
                    ':nom' => $data['nomcavalier'],
                    ':prenom' => $data['prenomcavalier'],
                    ':datenaissance' => $data['datenaissancecavalier'],
                    ':nomresp' => $data['nomresponsable'],
                    ':rueresp' => $data['rueresponsable'],
                    ':telresp' => $data['telresponsable'],
                    ':emailresp' => $data['emailresponsable'],
                    ':password' => $hashedPassword,
                    ':numlicence' => $data['numlicence'],
                    ':numassurance' => $data['numassurance'],
                    ':idcommune' => $data['idcommune'],
                    ':idgalop' => $data['idgalop']
                ]);

                echo json_encode([
                    "success" => true,
                    "message" => "Inscription réussie"
                ]);
            } catch (PDOException $e) {
                echo json_encode([
                    "success" => false,
                    "error" => "Erreur lors de l'insertion : " . $e->getMessage()
                ]);
            }
            exit;
        }

        // Si aucune action valide n'est spécifiée
        echo json_encode([
            "success" => false,
            "error" => "Action non valide"
        ]);
    } else {
        // Si la méthode HTTP n'est pas POST
        echo json_encode([
            "success" => false,
            "error" => "Méthode non autorisée"
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "error" => "Erreur de base de données : " . $e->getMessage()
    ]);
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "error" => "Erreur : " . $e->getMessage()
    ]);
}
?>