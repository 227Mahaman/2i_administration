<?php
include_once('../../connexion/connexion.php');
$menuModule = array();
$menuModule['error'] = true;
$menuModule['message'] = "Opération échoué";
$menuModule['data'] = array();
//Recuperetion des données send en input
$post = json_decode(file_get_contents('php://input'), true) ?? $_POST;
if (!empty($_GET['action'])) {//Vérification s'il y a une action à getté
    extract($_GET);
    
    if ($action=='add') {
        if (!empty($post['id_profil']) && !empty($post['id_action'])) {
            $pdo = $GLOBALS['connexion'];
            $sql = "INSERT INTO profil_has_action(id_profil, id_action) VALUES(?, ?)";
            $req = $pdo->prepare($sql);
            $req->execute([$post['id_profil'],$post['id_action']]);
            $menuModule['error'] = false;
            $menuModule['message'] = "Opération ajout réussis";
            $menuModule['data'] = $res;
        }
    }elseif ($action=='delete') {
        
        if (!empty($post['id_profil']) && !empty($post['id_action'])) {
            
            $pdo = $GLOBALS['connexion'];
            $sql = "DELETE FROM profil_has_action WHERE id_profil=? AND id_action=?";
            $req = $pdo->prepare($sql);
            $req->execute([$post['id_profil'],$post['id_action']]);
            $menuModule['error'] = false;
            $menuModule['message'] = "Opération delete réussis";
            $menuModule['data'] = array();
        }
    }
}
echo json_encode($menuModule);

