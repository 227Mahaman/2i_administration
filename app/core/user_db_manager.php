<?php
// include_once("controle_session.php");
include_once("./connexion/connexion.php");
/*
 * fonctions de manipultion des users
 */

//*********fonction d'insertions
function insert_user($id_profil, $nom, $prenom, $login, $password, $id_user_conn){
    $pdo = $GLOBALS['connexion'];
    try
    {
        $pdo->beginTransaction();
        $pdo->exec("INSERT INTO user(nom_user, prenom_user, login, password, id_profil, created_by)
            VALUES ('$nom', '$prenom', '$login', '$password', '$id_profil', '$id_user_conn')
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

}//fin fonction insert_user


//*********fonctions de selections des users
function select_user($critere){
    $pdo = $GLOBALS['connexion'];
    $records = $pdo->query("SELECT id_user, libelle_profil, nom_user, prenom_user, login, statut_activation
                 FROM user u, profil p
                 WHERE u.id_profil=p.id_profil and $critere");
    return $records;
}//fin fonction select_user

function select_user_per_page($start, $records_per_page, $critere){
    $pdo = $GLOBALS['connexion'];
    $records = $pdo->query("SELECT id_user, libelle_profil, u.id_profil, nom_user, prenom_user, login, password, statut_activation
                            FROM users u, profil p
                            WHERE u.id_profil=p.id_profil and $critere
                            ORDER BY id_user DESC
                            LIMIT $records_per_page offset $start");
    return $records;
}//fin fonction select_user_per_page

function select_user_one($id_user){
    $pdo = $GLOBALS['connexion'];
    $records = $pdo->query("select * from user where id_user = $id_user");
    return $records;
}//fin fonction select_user_per_page


//fonctions de mis à jour des users
function update_user($id_user, $id_profil, $nom, $prenom, $login, $password, $date){
    $pdo = $GLOBALS['connexion'];
    try
    {
        $pdo->beginTransaction();
        $pdo->exec("UPDATE user SET nom_user='$nom', prenom_user='$prenom', login='$login', id_profil='$id_profil', modified_at='$date'
                    WHERE id_user = '$id_user'
                    ");
        //maj du mot de passe au cas ou il n'est pas vide
        if($password != "")
        {
            $password = md5($password);
            $pdo->exec("UPDATE user SET password='$password' WHERE id_user = '$id_user' ");
        }
        $pdo->commit();

        return true;
    }
    catch(Exception $e) //en cas d'erreur
    {
        //on annule la transation
        $pdo->rollback();
        return false;
    }
}//fin fonction update_user

//fonctions de suppression des utilisateurs
function delete_user($id){

}//fin fonction delete_user

// fonction de verification des identifiants d'un utilisateur
function verify_user($login, $password)
{
    global $pdo;

    $SQL = "SELECT * FROM users
                WHERE login = ? AND password = ?
                LIMIT 1";

    $select = $pdo->prepare($SQL);
    $select->execute([$login, $password]);

    return $select;
}

// Mise a jour du mot de passe d'un utilisateur
function update_password_user($login, $password)
{
    global $pdo;

    $SQL = "UPDATE users SET password = ?
                WHERE login = ?";

    try
    {
        $update = $pdo->prepare($SQL);
        $update->execute([$password, $login]);

        return true;
    }
    catch(Exception $e)
    {
        return false;
    }
}

/**
 * Function select Profil de l'user
 * @param Int id profil
 * @return résulat
 */
function select_profil_user($profil){
    $pdo = $GLOBALS['connexion'];
    $records = $pdo->query("SELECT * FROM profil WHERE id_profil = '$profil'");
    return $records;
}


