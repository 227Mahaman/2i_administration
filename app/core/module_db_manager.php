<?php
//include_once("controle_session.php");
include_once("./connexion/connexion.php");
/* 
 * fonctions de manipultion des modules (Groupe)
 */

//*********fonction d'insertions
function insert_module($libelle, $icon, $bloc, $ordre){
    $pdo = $GLOBALS['connexion'];
    try
    {
        $pdo->beginTransaction();
        $pdo->exec("INSERT INTO groupe_action(libelle_groupe, icon_groupe, bloc_menu, ordre_affichage_groupe)
                    VALUES ('$libelle', '$icon', '$bloc', '$ordre')
                    ");
        $pdo->commit();
        return true;
    }
    catch(Exception $e) //en cas d'erreur
    {
        //on annule la transaction
        $pdo->rollback();
        return false;
    }
    
}//fin fonction insert_module


//*********fonctions de selections des modules
function select_module($critere){
    $pdo = $GLOBALS['connexion'];
    $records = $pdo->query("SELECT id_groupe, libelle_groupe, icon_groupe, bloc_menu, ordre_affichage_groupe
                 FROM groupe_action
                 WHERE $critere ");
    return $records;
}//fin fonction select_module

function select_module_per_page($start, $records_per_page, $critere){
    $pdo = $GLOBALS['connexion'];
    $records = $pdo->query("SELECT id_groupe, libelle_groupe, created_by, created_at, modified_by, modified_at
                            FROM groupe_action
                            WHERE $critere
                            LIMIT $records_per_page OFFSET $start");
    return $records;
}//fin fonction select_module_per_page

function select_module_one($id){
    $pdo = $GLOBALS['connexion'];
    $records = $pdo->query("SELECT * FROM groupe_action WHERE id_groupe = $id");
    return $records;
}//fin fonction select_module_one


//fonctions de mis à jour des modules
function update_module($id, $libelle, $icon, $bloc, $ordre){
    $pdo = $GLOBALS['connexion'];
    try
    {
        $pdo->beginTransaction();
        $pdo->exec("UPDATE groupe_action
            SET libelle_groupe='$libelle', icon_groupe = '$icon', bloc_menu = '$bloc', ordre_affichage_groupe = '$ordre'
            WHERE id_groupe = $id
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
}//fin fonction update_profil

//fonctions de suppression de module
function delete_module($id){   
    $pdo = $GLOBALS['connexion'];
    try
    {
        $pdo->beginTransaction();
        $pdo->exec("DELETE FROM groupe_action WHERE id_groupe ='$id'");
        $pdo->commit();
        
        return true;
    }
    catch(Exception $e) //en cas d'erreur
    {
        //on annule la transation
        $pdo->rollback();
        return false;
    }
}//fin fonction delete_module


