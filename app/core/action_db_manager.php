<?php
include_once("controle_session.php");    
include_once("../connexion/connexion.php");
/* 
 * fonctions de manipultion des actions et des groupes d'action
 */

//selection de tous les groupes d'actions
function select_all_groupes(){
    $pdo = $GLOBALS['connexion'];
    $records = $pdo->query("SELECT id_groupe,icon_groupe, libelle_groupe, bloc_menu, ordre_affichage_groupe
                            FROM groupe_action
                            order by ordre_affichage_groupe ASC");
    return $records;
}//fin fonction select_groupe

//selection d'un seul groupe
function select_one_groupe($id_groupe){
    $pdo = $GLOBALS['connexion'];
    $records = $pdo->query("SELECT id_groupe,icon_groupe, libelle_groupe, bloc_menu, ordre_affichage_groupe
                            FROM groupe_action
                            where id_groupe= $id_groupe");
    return $records;
}//fin fonction select_groupe_one

//selection des actions d'un groupe donné
function select_one_groupe_actions($id_groupe){
    $pdo = $GLOBALS['connexion'];
    $records = $pdo->query("SELECT id_action, libelle_action, description_action, url_action, ordre_affichage_action
                            FROM action 
                            WHERE id_groupe= $id_groupe
                            order by ordre_affichage_action");
    return $records;
}//fin fonction select_action_one

//selection des groupes d'un bloc donné
function select_one_bloc_groupes($id_action){
    $pdo = $GLOBALS['connexion'];
    $records = $pdo->query("select * from action where id_action = $id_action");
    return $records;
}//fin fonction select_action_one

//*********fonctions de selections de toutes les actions
function select_all_actions(){
    $pdo = $GLOBALS['connexion'];
    $records = $pdo->query("SELECT a.id_groupe,icon_groupe, libelle_groupe, id_action, libelle_action, description_action
                            FROM action a, groupe_action g
                            WHERE a.id_groupe=g.id_groupe
                            order by libelle_groupe");
    return $records;
}//fin fonction select_action


//*********fonctions de selections de toutes les actions d'un profil donné
function select_all_profil_actions($id_profil){
    $pdo = $GLOBALS['connexion'];
    $records = $pdo->query("SELECT a.id_groupe,icon_groupe, libelle_groupe, pa.id_action, libelle_action, description_action
                            FROM profil_has_action pa,action a, groupe_action g
                            WHERE pa.id_action=a.id_action and a.id_groupe=g.id_groupe and id_profil=$id_profil
                            order by libelle_groupe");
    return $records;
}//fin fonction select_action



