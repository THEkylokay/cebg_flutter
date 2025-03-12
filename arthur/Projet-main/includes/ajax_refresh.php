<?php
include './bdd.inc.php';

// Pour l'autocomplétion des communes
if(isset($_POST['keyword']) && isset($_POST['type']) && $_POST['type'] == 'commune') {
    $keyword = '%'.$_POST['keyword'].'%';

    $sql = "SELECT idcommune, ville, codepostal FROM commune
            WHERE (ville LIKE :var OR codepostal LIKE :var)
            AND afficher = true
            ORDER BY ville ASC LIMIT 0, 10";

    $req = $con->prepare($sql);
    $req->bindParam(':var', $keyword, PDO::PARAM_STR);
    $req->execute();

    while($res = $req->fetch(PDO::FETCH_ASSOC)) {
        $Listecommune = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $res['ville'].' '.$res['codepostal']);
        echo '<li onclick="set_item(\''.str_replace("'", "\'", $res['ville']).'\',\''.str_replace("'", "\'", $res['codepostal']).'\',\''.str_replace("'", "\'", $res['idcommune']).'\')">'.$Listecommune.'</li>';
    }
}

// Pour l'autocomplétion des communes en modification
elseif(isset($_POST['keyword21'])) {
    $keyword = '%'.$_POST['keyword21'].'%';
    $cavalier_id = $_POST['cavalier_id'];
    
    $sql = "SELECT idcommune, ville, codepostal FROM commune 
            WHERE (ville LIKE :var OR codepostal LIKE :var)
            AND afficher = true 
            ORDER BY ville ASC LIMIT 0, 10";
    
    $req = $con->prepare($sql);
    $req->bindParam(':var', $keyword, PDO::PARAM_STR);
    $req->execute();
    
    while($res = $req->fetch(PDO::FETCH_ASSOC)) {
        $Listecommune = str_replace($_POST['keyword21'], '<b>'.$_POST['keyword21'].'</b>', $res['ville'].' '.$res['codepostal']);
        echo '<li onclick="set_item21(\''.str_replace("'", "\'", $res['ville']).'\',\''.str_replace("'", "\'", $res['codepostal']).'\',\''.str_replace("'", "\'", $res['idcommune']) .'\',\''.$cavalier_id.'\')">'.$Listecommune.'</li>';
    }
}

// Pour l'autocomplétion des galops
elseif(isset($_POST['keyword']) && isset($_POST['type']) && $_POST['type'] === 'galop') {
    $keyword = '%'.$_POST['keyword'].'%';

    $sql = "SELECT idgalop, libgalop FROM galop
            WHERE libgalop LIKE :var
            AND afficher = true
            ORDER BY libgalop ASC LIMIT 0, 10";

    $req = $con->prepare($sql);
    $req->bindParam(':var', $keyword, PDO::PARAM_STR);
    $req->execute();

    while($res = $req->fetch(PDO::FETCH_ASSOC)) {
        $libGalop = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $res['libgalop']);
        echo '<li onclick="set_item2(\''.str_replace("'", "\'", $res['libgalop']).'\',\''.str_replace("'", "\'", $res['idgalop']).'\')">'.$libGalop.'</li>';
    }
}

// Pour l'autocomplétion des galops en modification
elseif(isset($_POST['keyword22'])) {
    $keyword = '%'.$_POST['keyword22'].'%';
    $cavalier_id = $_POST['cavalier_id'];
    
    $sql = "SELECT idgalop, libgalop FROM galop
            WHERE libgalop LIKE :var
            AND afficher = true
            ORDER BY libgalop ASC LIMIT 0, 10";
    
    $req = $con->prepare($sql);
    $req->bindParam(':var', $keyword, PDO::PARAM_STR);
    $req->execute();
    
    while($res = $req->fetch(PDO::FETCH_ASSOC)) {
        $libGalop = str_replace($_POST['keyword22'], '<b>'.$_POST['keyword22'].'</b>', $res['libgalop']);
        echo '<li onclick="set_item22(\''.str_replace("'", "\'", $res['libgalop']).'\',\''.str_replace("'", "\'", $res['idgalop']).'\',\''.$cavalier_id.'\')">'.$libGalop.'</li>';
    }
}

// Pour l'autocomplétion des cavaliers
elseif (isset($_POST['keyword']) && isset($_POST['type']) && $_POST['type'] == 'cavalier') {
    $keyword = '%'.$_POST['keyword'].'%';
    
    $sql = "SELECT idcavalier, nomcavalier, prenomcavalier 
            FROM cavalier 
            WHERE (nomcavalier LIKE :keyword OR prenomcavalier LIKE :keyword)
            AND afficher = true 
            ORDER BY nomcavalier ASC";
    
    $stmt = $con->prepare($sql);
    $stmt->execute([':keyword' => $keyword]);
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $nom_complet = $row['nomcavalier'] . ' ' . $row['prenomcavalier'];
        echo '<li onclick="set_item_cavalier(\''
            .str_replace("'", "\'", $row['nomcavalier']).'\', \''
            .str_replace("'", "\'", $row['prenomcavalier']).'\', \''
            .str_replace("'", "\'", $row['idcavalier']).'\')">'
            .$nom_complet.'</li>';
    }
}

// Pour l'autocomplétion des cavaliers en modification
elseif (isset($_POST['keyword22']) && isset($_POST['type']) && $_POST['type'] == 'cavalier') {
    $keyword = '%'.$_POST['keyword22'].'%';
    $idcavalier = $_POST['idcavalier'];
    
    $sql = "SELECT idcavalier, nomcavalier, prenomcavalier FROM cavalier
            WHERE (nomcavalier LIKE :keyword OR prenomcavalier LIKE :keyword)
            AND afficher = true";
    $stmt = $con->prepare($sql);
    $stmt->execute([':keyword' => $keyword]);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $nom_complet = $row['nomcavalier'] . ' ' . $row['prenomcavalier'];
        echo '<li onclick="set_item_cavalier22(\''.$nom_complet.'\', '.$row['idcavalier'].', \''.$idcavalier.'\')">'.$nom_complet.'</li>';
    }
}

// Pour l'autocomplétion des chevaux
elseif(isset($_POST['type']) && $_POST['type'] === 'cheval') {
    $keyword = $_POST['keyword'];
    
    $sql = "SELECT numsire, nomcheval 
            FROM cavalerie 
            WHERE nomcheval LIKE :keyword 
            AND afficher = true 
            ORDER BY nomcheval ASC";
    
    $stmt = $con->prepare($sql);
    $stmt->execute([':keyword' => '%'.$keyword.'%']);
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $nomCheval = str_replace($keyword, '<b>'.$keyword.'</b>', $row['nomcheval']);
        echo '<li onclick="set_item_cheval(\''
            .str_replace("'", "\'", $row['nomcheval']).'\', \''
            .str_replace("'", "\'", $row['numsire']).'\')">'
            .$nomCheval.'</li>';
    }
}

// Pour l'autocomplétion des robes dans le formulaire
elseif (isset($_POST['type']) && $_POST['type'] == 'robe' && !isset($_POST['numsire'])) {
    $keyword = '%'.$_POST['keyword'].'%';

    $sql = "SELECT idrobe, librobe FROM robe
            WHERE librobe LIKE :var
            AND afficher = true
            ORDER BY librobe ASC LIMIT 0, 10";

    $req = $con->prepare($sql);
    $req->bindParam(':var', $keyword, PDO::PARAM_STR);
    $req->execute();

    while($res = $req->fetch(PDO::FETCH_ASSOC)) {
        $libRobe = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $res['librobe']);
        echo '<li onclick="set_item3(\''
            .str_replace("'", "\'", $res['librobe']).'\',\''
            .str_replace("'", "\'", $res['idrobe']).'\')">'
            .$libRobe.'</li>';
    }
}

// Pour l'autocomplétion des robes dans la liste (édition)
elseif (isset($_POST['type']) && $_POST['type'] == 'robe' && isset($_POST['numsire'])) {
    $keyword = '%'.$_POST['keyword'].'%';

    $sql = "SELECT idrobe, librobe FROM robe
            WHERE librobe LIKE :var
            AND afficher = true
            ORDER BY librobe ASC LIMIT 0, 10";

    $req = $con->prepare($sql);
    $req->bindParam(':var', $keyword, PDO::PARAM_STR);
    $req->execute();

    while($res = $req->fetch(PDO::FETCH_ASSOC)) {
        $libRobe = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $res['librobe']);
        echo '<li onclick="set_item_robe_edit(\''
            .str_replace("'", "\'", $res['librobe']).'\',\''
            .str_replace("'", "\'", $res['idrobe']).'\',\''
            .$_POST['numsire'].'\')">'
            .$libRobe.'</li>';
    }
}

// Pour l'autocomplétion des races dans le formulaire
elseif (isset($_POST['type']) && $_POST['type'] == 'race' && !isset($_POST['numsire'])) {
    $keyword = '%'.$_POST['keyword'].'%';

    $sql = "SELECT idrace, librace FROM race
            WHERE librace LIKE :var
            AND afficher = true
            ORDER BY librace ASC LIMIT 0, 10";

    $req = $con->prepare($sql);
    $req->bindParam(':var', $keyword, PDO::PARAM_STR);
    $req->execute();

    while($res = $req->fetch(PDO::FETCH_ASSOC)) {
        $libRace = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $res['librace']);
        echo '<li onclick="set_item4(\''
            .str_replace("'", "\'", $res['librace']).'\',\''
            .str_replace("'", "\'", $res['idrace']).'\')">'
            .$libRace.'</li>';
    }
}

// Pour l'autocomplétion des races dans la liste (édition)
elseif (isset($_POST['type']) && $_POST['type'] == 'race' && isset($_POST['numsire'])) {
    $keyword = '%'.$_POST['keyword'].'%';

    $sql = "SELECT idrace, librace FROM race
            WHERE librace LIKE :var
            AND afficher = true
            ORDER BY librace ASC LIMIT 0, 10";

    $req = $con->prepare($sql);
    $req->bindParam(':var', $keyword, PDO::PARAM_STR);
    $req->execute();

    while($res = $req->fetch(PDO::FETCH_ASSOC)) {
        $libRace = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $res['librace']);
        echo '<li onclick="set_item_race_edit(\''
            .str_replace("'", "\'", $res['librace']).'\',\''
            .str_replace("'", "\'", $res['idrace']).'\',\''
            .$_POST['numsire'].'\')">'
            .$libRace.'</li>';
    }
}

// Pour l'autocomplétion des cours
elseif (isset($_POST['type']) && $_POST['type'] == 'cours') {
    $keyword = '%'.$_POST['keyword'].'%';
    $sql = "SELECT idcours, libcours FROM cours WHERE libcours LIKE :keyword AND afficher = true ORDER BY libcours ASC LIMIT 0, 10";
    $stmt = $con->prepare($sql);
    $stmt->execute([':keyword' => $keyword]);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<li onclick="set_item_cours_base(\''.str_replace("'", "\'", $row['libcours']).'\', '.$row['idcours'].')">'.$row['libcours'].'</li>';
    }
}

// Pour l'autocomplétion des cours en modification
elseif (isset($_POST['keyword21'])) {
    $keyword = '%'.$_POST['keyword21'].'%';
    $idcours = $_POST['idcours'];
    $sql = "SELECT idcours, libcours FROM cours WHERE libcours LIKE :keyword AND afficher = true ORDER BY libcours ASC LIMIT 0, 10";
    $stmt = $con->prepare($sql);
    $stmt->execute([':keyword' => $keyword]);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<li onclick="set_item_cours21(\''.str_replace("'", "\'", $row['libcours']).'\', '.$row['idcours'].', \''.$idcours.'\')">'.$row['libcours'].'</li>';
    }
}

if(isset($_POST['keyword']) && isset($_POST['type']) && $_POST['type'] === 'cavalier') {
    $keyword = '%'.$_POST['keyword'].'%';
    
    $sql = "SELECT idcavalier, nomcavalier FROM cavalier 
            WHERE nomcavalier LIKE :var 
            AND afficher = true 
            ORDER BY nomcavalier ASC LIMIT 0, 10";
    
    $req = $con->prepare($sql);
    $req->bindParam(':var', $keyword, PDO::PARAM_STR);
    $req->execute();
    $list = $req->fetchAll();
    
    foreach ($list as $res) {
    
        //  affichage
    
        $Listecav = str_replace($_POST['keyword'], '<b>', $res['nomcavalier']);
    
        // sélection
    
        echo '<li onclick="set_item_cavalier(\''.str_replace("'", "\'", $res['nomcavalier']).'\',\''
                                           .str_replace("'", "\'", $res['idcavalier']).'\')">'
            .$Listecav.'</li>';
    }
    
    }

// LISTE - Autocomplétion robe en édition
elseif (isset($_POST['type']) && $_POST['type'] == 'robe_edit') {
    $keyword = '%'.$_POST['keyword'].'%';
    $numsire = $_POST['numsire'];

    $sql = "SELECT idrobe, librobe FROM robe
            WHERE librobe LIKE :var
            AND afficher = true
            ORDER BY librobe ASC LIMIT 0, 10";

    $req = $con->prepare($sql);
    $req->bindParam(':var', $keyword, PDO::PARAM_STR);
    $req->execute();

    while($res = $req->fetch(PDO::FETCH_ASSOC)) {
        $libRobe = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $res['librobe']);
        echo '<li onclick="set_item_robe_edit(\''
            .str_replace("'", "\'", $res['librobe']).'\',\''
            .str_replace("'", "\'", $res['idrobe']).'\',\''
            .$numsire.'\')">'
            .$libRobe.'</li>';
    }
}

// LISTE - Autocomplétion race en édition
elseif (isset($_POST['type']) && $_POST['type'] == 'race_edit') {
    $keyword = '%'.$_POST['keyword'].'%';
    $numsire = $_POST['numsire'];

    $sql = "SELECT idrace, librace FROM race
            WHERE librace LIKE :var
            AND afficher = true
            ORDER BY librace ASC LIMIT 0, 10";

    $req = $con->prepare($sql);
    $req->bindParam(':var', $keyword, PDO::PARAM_STR);
    $req->execute();

    while($res = $req->fetch(PDO::FETCH_ASSOC)) {
        $libRace = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $res['librace']);
        echo '<li onclick="set_item_race_edit(\''
            .str_replace("'", "\'", $res['librace']).'\',\''
            .str_replace("'", "\'", $res['idrace']).'\',\''
            .$numsire.'\')">'
            .$libRace.'</li>';
    }
}