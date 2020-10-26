<?php
//include_once("../controle_session.php");    
include_once("./connexion/connexion.php");
/* 
 * fonctions de manipultion des menus et des groupes d'action
 */

//selection de tous les groupes menus
function select_all_groupes(){
    $pdo = $GLOBALS['connexion'];
    $records = $pdo->query("SELECT id_groupe,icon_groupe, libelle_groupe, bloc_menu, ordre_affichage_groupe
                            FROM groupe_action
                            order by ordre_affichage_groupe ASC");
    return $records;
}//fin fonction select_groupe

//selection d'un seul groupe
function select_one_groupe($id){
    $pdo = $GLOBALS['connexion'];
    $records = $pdo->query("SELECT id_groupe,icon_groupe, libelle_groupe, bloc_menu, ordre_affichage_groupe
                            FROM groupe_action
                            where id_groupe= $id");
    return $records;
}//fin fonction select_groupe_one

//selection des menus d'un groupe donné
function select_one_groupe_menus($id){
    $pdo = $GLOBALS['connexion'];
    $records = $pdo->query("SELECT id_action, libelle_action, description_action, url_action, ordre_affichage_action
                            FROM action 
                            WHERE id_groupe= $id
                            order by ordre_affichage_action");
    return $records;
}//fin fonction select_action_one

//selection des groupes d'un bloc donné
function select_one_bloc_groupes($id){
    $pdo = $GLOBALS['connexion'];
    $records = $pdo->query("select * from action where id_action = $id");
    return $records;
}//fin fonction select_action_one

//*********fonctions de selections de toutes les menus
function select_all_menus(){
    $pdo = $GLOBALS['connexion'];
    $records = $pdo->query("SELECT a.id_groupe,icon_groupe, libelle_groupe, id_action, libelle_action, description_action, url_action
                            FROM action a, groupe_action g
                            WHERE a.id_groupe=g.id_groupe
                            order by libelle_groupe");
    return $records;
}//fin fonction select_action


//*********fonctions de selections de toutes les menus d'un profil donné
function select_all_profil_menus($id){
    $pdo = $GLOBALS['connexion'];
    $records = $pdo->query("SELECT a.id_groupe,icon_groupe, libelle_groupe, pa.id_action, libelle_action, description_action
                            FROM profil_has_action pa,action a, groupe_action g
                            WHERE pa.id_action=a.id_action and a.id_groupe=g.id_groupe and id_profil=$id
                            order by libelle_groupe");
    return $records;
}//fin fonction select_action

//fonctions de mis à jour des menus
function update_menu($id, $groupe, $libelle, $description, $url, $ordre){
    $pdo = $GLOBALS['connexion'];
    try
    {
        $pdo->beginTransaction();
        $pdo->exec("UPDATE action
            SET id_groupe = '$groupe', libelle_action='$libelle', description_action = '$description', url_action = '$url', ordre_affichage_action = '$ordre'
            WHERE id_action = $id
        ");
        $pdo->commit();
        return true;
    }
    catch(Exception $e) //en cas d'erreur
    {
        //on annule la transation
        $pdo->rollback();
        return false;
    }
}//fin fonction update_menu

function select_menu_one($id){
    $pdo = $GLOBALS['connexion'];
    $records = $pdo->query("SELECT * FROM action WHERE id_action = $id");
    return $records;
}//fin fonction select_menu_one

//fonctions de suppression de module
function delete_menu($id){   
    $pdo = $GLOBALS['connexion'];
    try
    {
        $pdo->beginTransaction();
        $pdo->exec("DELETE FROM action WHERE id_action ='$id'");
        $pdo->commit();
        
        return true;
    }
    catch(Exception $e) //en cas d'erreur
    {
        //on annule la transation
        $pdo->rollback();
        return false;
    }
}//fin fonction delete_menu



