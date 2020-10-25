<?php
//include_once("controle_session.php");
include_once("./connexion/connexion.php");
/* 
 * fonctions de manipultion des profils
 */

//*********fonction d'insertions
function insert_profil($libelle_profil, $id_user_conn){
    $pdo = $GLOBALS['connexion'];
    try
    {
        $pdo->beginTransaction();
        $pdo->exec("insert into profil(libelle_profil, created_by)
                    values ('$libelle_profil', $id_user_conn)
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
    
}//fin fonction insert_profil


//*********fonctions de selections des profils
function select_profil($critere){
    $pdo = $GLOBALS['connexion'];
    $records = $pdo->query("SELECT id_profil, libelle_profil, created_by, created_at, modified_by, modified_at
                 FROM profil
                 WHERE $critere ");
    return $records;
}//fin fonction select_profil

function select_profil_per_page($start, $records_per_page, $critere){
    $pdo = $GLOBALS['connexion'];
    $records = $pdo->query("SELECT id_profil, libelle_profil, created_by, created_at, modified_by, modified_at
                            FROM profil
                            WHERE $critere
                            LIMIT $records_per_page OFFSET $start");
    return $records;
}//fin fonction select_profil_per_page

function select_profil_one($id_profil){
    $pdo = $GLOBALS['connexion'];
    $records = $pdo->query("select * from profil where id_profil = $id_profil");
    return $records;
}//fin fonction select_profil_one


//fonctions de mis à jour des profils
function update_profil($id_profil,$libelle_profil, $id_user_conn, $date){
    $pdo = $GLOBALS['connexion'];
    try
    {
        $pdo->beginTransaction();
        $pdo->exec("update profil set libelle_profil='$libelle_profil', modified_by=$id_user_conn, modified_at='$date'
                     where id_profil = $id_profil
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

//fonctions de suppression des utilisateurs
function delete_profil($id){   
    
}//fin fonction delete_profil


