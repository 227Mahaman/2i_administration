<?php
/**
 * Recuperetion de l'ensemble des Menu du Profil
 */
include_once('../../connexion/connexion.php');
$menuModule = array();
$menuModule['error'] = true;
$menuModule['message'] = "Opération échoué";
$menuModule['data'] = array();

if (!empty($_GET['id_profil']) && !empty($_GET['id_action'])) {
    $pdo = $GLOBALS['connexion'];
    $sql = "SELECT * FROM profil_has_action WHERE id_profil=? AND id_action=?";
    $req = $pdo->prepare($sql);
    $req->execute([$_GET['id_profil'],$_GET['id_action']]);

    if ($res = $req->fetch()) {
        $menuModule['error'] = false;
        $menuModule['message'] = "Opération réussis";
        $menuModule['data'] = $res;
        
    }  else {
        echo 'ok';
    }
}
echo json_encode($menuModule);

